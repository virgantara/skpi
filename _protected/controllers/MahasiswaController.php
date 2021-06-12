<?php

namespace app\controllers;

use Yii;
use app\models\RiwayatKamar;
use app\models\RiwayatPelanggaran;
use app\models\SimakMastermahasiswa;
use app\models\MahasiswaSearch;
use app\models\Asrama;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\helpers\MyHelper;
use yii\httpclient\Client;
use yii\filters\AccessControl;

/**
 * MahasiswaController implements the CRUD actions for SimakMastermahasiswa model.
 */
class MahasiswaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page');
                },
                'only' => ['update','index','view','konsulat'],
                'rules' => [
                    
                    [
                        'actions' => [
                            'update','index','view','konsulat'
                        ],
                        'allow' => true,
                        'roles' => ['theCreator','admin','operatorCabang'],
                    ],
                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionKonsulatRekap()
    {
        $query = new \yii\db\Query();
        $results = $query->select(['konsulat', 'c.name','c.latitude','c.longitude', 'count(*) as total'])
        ->from('simak_mastermahasiswa m')
        ->innerJoin('cities c', 'm.konsulat = c.id')
        ->groupBy(['m.konsulat', 'c.name','c.latitude','c.longitude'])
        ->orderBy('total DESC')
        // ->limit(10)
        ->all();

        return $this->render('konsulat_rekap',[
            'results' => $results 
        ]);
    }

    public function actionAddKonsulat()
    {
        $dataku = $_POST['dataku'];
        $nim = $dataku['nim'];
        $city = $dataku['city'];
        if (!empty($dataku['nim'])) {
            if (!empty($dataku['city'])) {
                $data = SimakMastermahasiswa::find()->where(['nim_mhs' => $nim])->one();
                
                if(empty($data->konsulat))
                {
                    $data->konsulat = $city;
                    $data->save(false,['konsulat']);
                
                    $results = [
                        'code' => 200,
                        'msg' => "Berhasil",
                        
                    ];
                }

                else if($city == $data->konsulat)
                {
                    $results = [
                        'code' => 500,
                        'msg' => "Oops, mahasiswa ini sudah di konsulat ini",
                        
                    ];
                }

                else
                {
                    $results = [
                        'code' => 500,
                        'msg' => "Oops, mahasiswa ini sudah ada di konsulat lain",
                        
                    ];
                }

            }
            else{
                $results = [
                    'code' => 500,
                    'msg' => "Konsulat kosong, Isi terlebih dahulu",
                    
                ];

            }
        }
        else {
            $results = [
                    'code' => 500,
                    'msg' => "NIM kosong, Isi terlebih dahulu",
                    
                ];
        }

         echo json_encode($results);
        die();
    }

    public function actionRemoveKonsulat()
    {
        $dataku = $_POST['dataku'];
        $nim = $dataku['nim'];
        if (!empty($dataku['nim'])) {
            $data = SimakMastermahasiswa::find()->where(['nim_mhs' => $nim])->one();
            $data->konsulat = null;
            $data->save(false,['konsulat']);
            $results = [
                'code' => 200,
                'msg' => "Berhasil",
                
            ];
        }
        else {
            $results = [
                'code' => 500,
                'msg' => "NIM kosong, Isi terlebih dahulu",
                
            ];
        }

        echo json_encode($results);
        die();
    }

    public function actionKonsulat()
    {
        $model = new SimakMastermahasiswa;
        $results = [];
        
        if (!empty($_GET['SimakMastermahasiswa']['konsulat'])) {
            
            $results = SimakMastermahasiswa::find()->where([
                'konsulat' => $_GET['SimakMastermahasiswa']['konsulat'],
            ])->all();          
            
        }

        // print_r($_GET['SimakMastermahasiswa']['konsulat']);exit;
        return $this->render('konsulat',[
            'model' => $model,
            'results' => $results,
        ]);
    } 

    /**
     * Lists all SimakMastermahasiswa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MahasiswaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $listKampus = ArrayHelper::map(\app\models\SimakKampus::find()->all(),'nama_kampus','nama_kampus');
        $prodis = ArrayHelper::map(\app\models\SimakMasterprogramstudi::find()->all(),'kode_prodi','nama_prodi');
        $fakultas = ArrayHelper::map(\app\models\SimakMasterfakultas::find()->all(),'kode_fakultas','nama_fakultas');

        $status_aktif = ArrayHelper::map(\app\models\SimakPilihan::find()->where(['kode'=>'05'])->all(),'value','label');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'listKampus' => $listKampus,
            'prodis' => $prodis,
            'fakultas' => $fakultas,
            'status_aktif' => $status_aktif
        ]);
    }

    /**
     * Displays a single SimakMastermahasiswa model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $query = RiwayatPelanggaran::find()->where([
            'nim'=> $model->nim_mhs
        ]);

        $query->orderBy(['created_at'=>SORT_DESC]);

        $riwayat = $query->all();

        $query = RiwayatKamar::find()->where([
            'nim'=> $model->nim_mhs
        ]);

        $querykrs = new \yii\db\Query();
        $querykrsmhs = $querykrs->select(['c.label as tahun','SUM(a.sks) as jumlah','SUM(a.sks * b.angka) as nilai', 'SUM(a.sks * b.angka) / SUM(a.sks) as ip'])
                ->from('simak_datakrs a')
                ->innerJoin('simak_konversi b', 'a.nilai_huruf = b.huruf')
                ->innerJoin('simak_pilihan c', 'a.tahun_akademik = c.value')
                ->where(['a.mahasiswa' => $model->nim_mhs])
                ->andWhere(['!=', 'a.nilai_huruf', "NULL" ])
                ->andWhere(['>', 'a.sks', '0'])
                ->groupBy(['c.label'])
                ->orderBy('c.label ASC')
                ->all();

        $query->orderBy(['created_at'=>SORT_DESC]);

        $riwayatKamar = $query->all();

        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $client_token = Yii::$app->params['client_token'];
        $headers = ['x-access-token'=>$client_token];
        $response = $client->get('/b/tagihan/mahasiswa', ['nim' => $model->nim_mhs],$headers)->send();
        
        $riwayatPembayaran = [];
       
        if ($response->isOk) {
            $result = $response->data['values'];
            // print_r($result);exit;
            if(!empty($result))
            {
                $riwayatPembayaran = $result;
            }

          
        }

        return $this->render('view', [
            'model' => $model,
            'riwayat' => $riwayat,
            'riwayatKamar' => $riwayatKamar,
            'dataKrs' => $querykrsmhs,
            'riwayatPembayaran' => $riwayatPembayaran
        ]);
    }


    /**
     * Creates a new SimakMastermahasiswa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SimakMastermahasiswa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SimakMastermahasiswa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // $states = \app\models\States::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            if(!$model->save())
            {
                print_r($model->getErrors());exit;
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            
        ]);
    }

    /**
     * Deletes an existing SimakMastermahasiswa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SimakMastermahasiswa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SimakMastermahasiswa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakMastermahasiswa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
