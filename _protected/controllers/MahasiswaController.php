<?php

namespace app\controllers;

use Yii;

use app\models\SkpiPermohonan;
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
                'only' => ['update', 'index', 'view', 'konsulat', 'konsulat-wni','koordinator','skpi','kompetensi'],
                'rules' => [
                    [
                        'actions' => [
                            'skpi','kompetensi'
                        ],
                        'allow' => true,
                        'roles' => ['Mahasiswa'],
                    ],

                    [
                        'actions' => [
                            'update', 'index', 'view', 'konsulat', 'konsulat-wni','koordinator','skpi'
                        ],
                        'allow' => true,
                        'roles' => ['theCreator', 'admin', 'akpamPusat','sekretearis','fakultas'],
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

    public function actionKompetensi()
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/site/login']);
        }

        $model = SkpiPermohonan::findOne(['nim' => Yii::$app->user->identity->nim ]);
        $mhs = null;
        if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
            $mhs =  SimakMastermahasiswa::findOne(['nim_mhs' => Yii::$app->user->identity->nim]);
        }
        
        return $this->render('kompetensi', [
            'model' => $model,
            'mhs' => $mhs
        ]);
    }

    public function actionSkpi()
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/site/login']);
        }

        
        if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
            $mhs =  SimakMastermahasiswa::findOne(['nim_mhs' => Yii::$app->user->identity->nim]);

            $model = SkpiPermohonan::findOne(['nim' => Yii::$app->user->identity->nim ]);
            

            return $this->render('skpi', [
                'model' => $model,
                'mhs' => $mhs
            ]);
        }
        
        $kode_prodi = '';
        $kode_fakultas = '';
        $searchModel = new MahasiswaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $list_fakultas = [];
        
        $kode_prodi = '';
        $kode_fakultas = '';
        $list_prodi = [];
        if(Yii::$app->user->identity->access_role == 'sekretearis'){
            $kode_prodi = Yii::$app->user->identity->prodi;
            $prodi = \app\models\SimakMasterprogramstudi::findOne(['kode_prodi' => $kode_prodi]);

            if(!empty($prodi)){
                $kode_fakultas = $prodi->kode_fakultas;

                $list_fakultas = \app\models\SimakMasterfakultas::find()->where(['kode_fakultas' => $kode_fakultas])->orderBy(['nama_fakultas'=>SORT_ASC])->all();
            }            

            $kode_prodi = Yii::$app->user->identity->prodi;
            $listProdi = \app\models\SimakMasterprogramstudi::find()->where(['kode_prodi' => $kode_prodi])->all();

            foreach ($listProdi as $item_name) {
                $list_prodi[$item_name->kode_prodi] = $item_name->nama_prodi;
            } 
            
        }
        else if(Yii::$app->user->identity->access_role == 'fakultas'){
            $kode_fakultas = Yii::$app->user->identity->fakultas;
            $list_fakultas = \app\models\SimakMasterfakultas::find()->where(['kode_fakultas' => Yii::$app->user->identity->fakultas])->orderBy(['nama_fakultas'=>SORT_ASC])->all();

            $listProdi = \app\models\SimakMasterprogramstudi::find()->where(['kode_fakultas' => $kode_fakultas])->all();

            foreach ($listProdi as $item_name) {
                $list_prodi[$item_name->kode_prodi] = $item_name->nama_prodi;
            } 
        }
        else{
            $list_fakultas = \app\models\SimakMasterfakultas::find()->orderBy(['nama_fakultas'=>SORT_ASC])->all();
            $listProdi = \app\models\SimakMasterprogramstudi::find()->all();

            foreach ($listProdi as $item_name) {
                $list_prodi[$item_name->kode_prodi] = $item_name->nama_prodi;
            } 
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'kode_prodi' => $kode_prodi,
            'list_prodi' => $list_prodi,
            'list_fakultas' =>$list_fakultas,
            'kode_fakultas' => $kode_fakultas
        ]);
        
    }

    public function actionAjaxCariMahasiswa()
    {

        $q = $_GET['term'];

        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $client_token = Yii::$app->params['client_token'];
        $headers = ['x-access-token' => $client_token];

        $prodi = !empty($_GET['prodi']) ? $_GET['prodi'] : null;

        $params = [
            'key' => $q,
            'kampus' => !empty($_GET['kampus']) ? $_GET['kampus'] : null,
            'prodi' => $prodi,
            'semester' => !empty($_GET['semester']) ? $_GET['semester'] : null,
            'status' => !empty($_GET['status']) ? $_GET['status'] : null
        ];
        $response = $client->get('/m/cari', $params, $headers)->send();

        $out = [];


        if ($response->isOk) {
            $result = $response->data['values'];
            // print_r($result);exit;
            if (!empty($result)) {
                foreach ($result as $d) {
                    $out[] = [
                        'id' => $d['id'],
                        'nim' => $d['nim_mhs'],
                        'label' => $d['nim_mhs'] . ' - ' . $d['nama_mahasiswa'] . ' - ' . $d['nama_prodi'] . ' - ' . $d['nama_kampus'],
                        'prodi' => $d['kode_prodi'],
                        'nama_prodi' => $d['nama_prodi'],
                        'kampus' => $d['kampus'],
                        'nama_kampus' => $d['nama_kampus'],
                        'semester' => $d['semester'],
                        'kode_pd' => $d['kode_pd']

                    ];
                }
            } else {
                $out[] = [
                    'id' => 0,
                    'label' => 'Data mahasiswa tidak ditemukan',

                ];
            }
        }


        echo \yii\helpers\Json::encode($out);
    }

    public function actionAjaxCariMahasiswaByNim()
    {

        $q = $_GET['term'];

        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $client_token = Yii::$app->params['client_token'];
        $headers = ['x-access-token' => $client_token];

        $params = [
            'nim' => $q,
        ];
        $response = $client->get('/m/profil/nim', $params, $headers)->send();

        $out = [];


        if ($response->isOk) {
            $result = $response->data['values'];
            // print_r($result);exit;
            if (!empty($result)) {
                foreach ($result as $d) {
                    $out[] = [
                        'id' => $d['id'],
                        'nim' => $d['nim_mhs'],
                        'nama_mahasiswa' => $d['nama_mahasiswa'],
                        'label' => $d['nim_mhs'] . ' - ' . $d['nama_mahasiswa'] . ' - ' . $d['nama_prodi'] . ' - ' . $d['nama_kampus'],
                        'items' => $d
                    ];
                }
            } else {
                $out[] = [
                    'id' => 0,
                    'label' => 'Data mahasiswa tidak ditemukan',

                ];
            }
        }


        echo \yii\helpers\Json::encode($out);
    }

    public function actionFoto($id)
    {
        $model = SimakMastermahasiswa::findOne($id);
        if (!empty($model->foto_path)) {
            try {
                $image = imagecreatefromstring($this->getImage($model->foto_path));

                header('Content-Type: image/jpeg');
                // imagejpeg($image, $image_output, 50);
                imagejpeg($image);
                // imagejpeg($dest);
            } catch (\Exception $e) {
                print_r($e->getMessage());
            }
        }


        die();
    }

    function getImage($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        $resource = curl_exec($ch);
        curl_close($ch);

        return $resource;
    }

    /**
     * Lists all SimakMastermahasiswa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MahasiswaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $listKampus = ArrayHelper::map(\app\models\SimakKampus::find()->all(), 'kode_kampus', 'nama_kampus');
        $prodis = ArrayHelper::map(\app\models\SimakMasterprogramstudi::find()->all(), 'kode_prodi', 'nama_prodi');
        $fakultas = ArrayHelper::map(\app\models\SimakMasterfakultas::find()->all(), 'kode_fakultas', 'nama_fakultas');

        $status_aktif = ArrayHelper::map(\app\models\SimakPilihan::find()->where(['kode' => '05'])->all(), 'value', 'label');

        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $id = Yii::$app->request->post('editableKey');
            $model = SimakMastermahasiswa::findOne($id);

            // store a default json response as desired by editable
            $out = json_encode(['output' => '', 'message' => '']);


            $posted = current($_POST['SimakMastermahasiswa']);
            $post = ['SimakMastermahasiswa' => $posted];

            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model
                if ($model->save()) {
                    $out = json_encode(['output' => '', 'message' => '']);
                } else {
                    $error = \app\helpers\MyHelper::logError($model);
                    $out = json_encode(['output' => '', 'message' => 'Oops, ' . $error]);
                }
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

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
    public function actionView($nim)
    {

        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/logout']);
        }

        if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
            return $this->redirect(['skpi']);
        }
        $mhs =  SimakMastermahasiswa::findOne(['nim_mhs' => $nim]);

        $model = SkpiPermohonan::findOne(['nim' => $nim]);

        return $this->render('skpi', [
            'model' => $model,
            'mhs' => $mhs
        ]);
    }

    public function actionViewKompetensi($nim)
    {

        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/logout']);
        }
        
        if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
            return $this->redirect(['skpi']);
        }
        $mhs =  SimakMastermahasiswa::findOne(['nim_mhs' => $nim]);

        $model = SkpiPermohonan::findOne(['nim' => $nim]);

        return $this->render('kompetensi', [
            'model' => $model,
            'mhs' => $mhs
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
            if (!$model->save()) {
                print_r($model->getErrors());
                exit;
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
