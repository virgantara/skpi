<?php

namespace app\controllers;

use Yii;
use app\models\IzinMahasiswa;
use app\models\IzinMahasiswaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\httpclient\Client;
use yii\helpers\ArrayHelper;
use app\models\Asrama;
/**
 * IzinMahasiswaController implements the CRUD actions for IzinMahasiswa model.
 */
class IzinMahasiswaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all IzinMahasiswa models.
     * @return mixed
     */
    public function actionIndex()
    {
         $asramas = ArrayHelper::map(Asrama::find()->all(),'id','nama');
        $prodis = ArrayHelper::map(\app\models\SimakMasterprogramstudi::find()->all(),'kode_prodi','nama_prodi');
        $fakultas = ArrayHelper::map(\app\models\SimakMasterfakultas::find()->all(),'kode_fakultas','nama_fakultas');
        $searchModel = new IzinMahasiswaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'asramas' => $asramas,
            'prodis' => $prodis,
            'fakultas' => $fakultas,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single IzinMahasiswa model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new IzinMahasiswa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new IzinMahasiswa();

        $mahasiswa = [];
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        // if(!empty($nim))
        // {
        
        //     $response = $client->get('/m/profil/nim', ['nim' => $nim],['x-access-token'=>Yii::$app->params['client_token']])->send();
            
        //     if ($response->isOk) {
        //         $mahasiswa = $response->data['values'][0];
        //     }    
        // }

        $response = $client->get('/tahun/aktif',[],['x-access-token'=>Yii::$app->params['client_token']])->send();
        $tahun_aktif = [];
        if ($response->isOk) {
            $tahun_aktif = $response->data['values'][0];
        }

        $model->tahun_akademik = $tahun_aktif['tahun_id'];

        // $model->nim = $mahasiswa['nim_mhs'] ?: '';
        
        // print_r($mahasiswa);exit;
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try 
        {
            if ($model->load(Yii::$app->request->post())) 
            {
                if(!empty($model->nim))
                {
                
                    $response = $client->get('/m/profil/nim', ['nim' => $model->nim],['x-access-token'=>Yii::$app->params['client_token']])->send();
                    
                    if ($response->isOk) {
                        $mahasiswa = $response->data['values'][0];
                        $model->semester = $mahasiswa['semester'];
                    }    
                }

                $model->tanggal_berangkat = \app\helpers\MyHelper::dmYtoYmd($model->tanggal_berangkat);
                $model->tanggal_pulang = \app\helpers\MyHelper::dmYtoYmd($model->tanggal_pulang);
                $model->save();

                $transaction->commit();
                return $this->redirect(['izin-mahasiswa/index']);
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing IzinMahasiswa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateStatus($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update_izin', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing IzinMahasiswa model.
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

    public function actionKembali()
    {

        if(Yii::$app->request->isPost)
        {

            $dataku = $_POST['dataku'];
            $id = $dataku['id'];
            $kode = $dataku['kode'];
            $model = $this->findModel($id);
            
            $model->status = $kode;
            $model->save(false,['status']);
        

            $results = [
                'code' => 200,
                'msg' => "Approval Berhasil"
            ];
            echo json_encode($results);        
        }

        die();
    }

    public function actionApproval()
    {

        if(Yii::$app->request->isPost)
        {

            $dataku = $_POST['dataku'];
            $id = $dataku['id'];
            $model = $this->findModel($id);
            if(Yii::$app->user->can('stafBAPAK'))
            {
                $model->approved = 1;
                $model->save(false,['approved']);
            }

            else if(Yii::$app->user->can('kaprodi'))
            {

                $model->prodi_approved = 1;
                $model->save(false,['prodi_approved']);
            }

            else if(Yii::$app->user->can('kepalaBAAK'))
            {
                $model->baak_approved = 1;
                $model->save(false,['baak_approved']);
            }

            $results = [
                'code' => 200,
                'msg' => "Approval Berhasil"
            ];
            echo json_encode($results);        
        }

        die();
    }

    /**
     * Finds the IzinMahasiswa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return IzinMahasiswa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IzinMahasiswa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
