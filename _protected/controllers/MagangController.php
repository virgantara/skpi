<?php

namespace app\controllers;

use Yii;
use app\helpers\MyHelper;
use app\models\SimakMagang;
use app\models\SimakMagangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\httpclient\Client;
/**
 * MagangController implements the CRUD actions for SimakMagang model.
 */
class MagangController extends Controller
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
                'only' => ['create','update','delete','ajax-get'],
                'rules' => [
                    [
                        'actions' => [
                            'ajax-get'
                        ],
                        'allow' => true,
                        'roles' => ['Mahasiswa'],
                    ],

                    [
                        'actions' => ['create','update','delete','ajax-get'],
                        'allow' => true,
                        'roles' => ['akpamPusat','admin', 'sekretearis','fakultas'],
                    ],
                    [
                        'actions' => [
                            'create','update','delete','index','view','ajax-get'
                        ],
                        'allow' => true,
                        'roles' => ['theCreator'],
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

    public function actionAjaxGet()
    {

        $results = [
            'code' => 406,
            'message' => 'Bad Request'
        ];

        if (Yii::$app->request->isPost && !empty($_POST['dataPost']) && !empty($_POST['dataPost']['nim'])) 
        {


            $nim = $_POST['dataPost']['nim'];
            $api_baseurl = Yii::$app->params['api_baseurl'];
            $client = new Client(['baseUrl' => $api_baseurl]);
            $client_token = Yii::$app->params['client_token'];
            $headers = ['x-access-token' => $client_token];

            $params = [
                'nim' => $nim,
                'status_magang' => 4 // Lulus
            ];

            // print_r($params);exit;
            $response = $client->get('/siakad/mahasiswa/magang/get', $params, $headers)->send();

            $out = [];


            if ($response->isOk) {
                $result = $response->data['values'];
                $items = [];
                foreach($result as $res){
                    
                    $durasi = 0;
                    if(!empty($res['tanggal_mulai_magang']) && !empty($res['tanggal_selesai_magang'])){
                        $selisih_hari = \app\helpers\MyHelper::hitungSelisihHari(
                            $res['tanggal_selesai_magang'], $res['tanggal_mulai_magang']
                        );

                        $durasi = $selisih_hari->days * 8;
                    }

                    $items[] = [
                        'instansi' => $res['nama_instansi'],
                        'jenis' => $res['jenis_magang'],
                        'pembina' => $res['nama_pembina_instansi'],
                        'durasi' => $durasi.' jam',
                        'durasi_en' => $durasi.' hours',
                        'pembimbing' => $res['pembimbing']
                    ];
                }
                $results = [
                    'code' => 200,
                    'message' => 'Success',
                    'items' => $items
                ];
            }
        }

        echo json_encode($results);
        exit;
    }

    /**
     * Lists all SimakMagang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SimakMagangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimakMagang model.
     * @param string $id ID
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
     * Creates a new SimakMagang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SimakMagang();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SimakMagang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SimakMagang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SimakMagang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return SimakMagang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakMagang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
