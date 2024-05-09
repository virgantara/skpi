<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use app\helpers\MyHelper;
use app\models\ProgramStudi;
use app\models\ProgramStudiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\httpclient\Client;

/**
 * ProgramStudiController implements the CRUD actions for ProgramStudi model.
 */
class ProgramStudiController extends Controller
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
                'only' => ['create','update','delete'],
                'rules' => [
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['akpamPusat','admin'],
                    ],
                    [
                        'actions' => [
                            'update','index','view'
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
        ] ;
        if (Yii::$app->request->isPost && !empty($_POST['dataPost']) && !empty($_POST['dataPost']['kode_prodi'])) 
        {
            $kode_prodi = $_POST['dataPost']['kode_prodi'];
            $model = ProgramStudi::findOne(['kode_prodi' => $kode_prodi]);
            $item = null;
            if(!empty($model)){

                $list_akreditasi = MyHelper::listAkreditasi();

                $api_baseurl = Yii::$app->params['api_baseurl'];
                $client = new Client(['baseUrl' => $api_baseurl]);
                $client_token = Yii::$app->params['client_token'];
                $headers = ['x-access-token'=>$client_token];

                $params = [
                    'kode_prodi' => $model->kode_prodi
                ];

                $response = $client->get('/spmi/prodi/akreditasi/get', $params,$headers)->send();

                $akreditasi = [];
                if ($response->isOk) {
                    $values = $response->data['values'];

                    $akreditasi = count($values) == 1 ? $values[0] : [];
                }

                $results = [
                    'code' => 200,
                    'message' => 'Success',
                    'prodi' => [
                        'nama_prodi' => $model->nama_prodi,
                        'nama_prodi_en' => $model->nama_prodi_en,
                        'gelar_lulusan' => $model->gelar_lulusan,
                        'gelar_lulusan_en' => $model->gelar_lulusan_en,
                        'jenjang' => (!empty($model->jenjang) ? $model->jenjang->label : '-'),
                        'jenjang_en' => (!empty($model->jenjang) ? $model->jenjang->label_en : '-'),
                        'bahasa_pengantar' => '-',
                        'bahasa_pengantar_en' => '-',
                        'kualifikasi_kkni' => '-',
                        'kualifikasi_kkni_en' => '-',
                        'persyaratan' => '-',
                        'persyaratan_en' => '-',
                    ],
                    'fakultas' => [
                        'nama_fakultas' => $model->kodeFakultas->nama_fakultas,
                        'nama_fakultas_en' => $model->kodeFakultas->nama_fakultas_en
                    ],
                    'kaprodi' => [
                        'niy' => (!empty($model->kaprodi) ? $model->kaprodi->niy : '-'),
                        'nama_dosen' => (!empty($model->kaprodi) ? $model->kaprodi->nama_dosen : '-'),
                    ],
                    'dekan' => [
                        'niy' => (!empty($model->kodeFakultas->pejabat0) ? $model->kodeFakultas->pejabat0->niy : '-'),
                        'nama_dosen' => (!empty($model->kodeFakultas->pejabat0) ? $model->kodeFakultas->pejabat0->nama_dosen : '-'),
                    ],
                    'akreditasi' => [
                        'status' => $list_akreditasi[$akreditasi['akreditasi']],
                        'nomor_sk' => $akreditasi['nomor_sk'],
                        'lembaga' => ''
                    ]

                ];
            }
              
            
        }

        echo json_encode($results);
        die();
    }


    public function actionSubprodi() {
        // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $query = ProgramStudi::find();
                $query->select(['kode_prodi as id','nama_prodi as name']);
                $query->where(['kode_fakultas'=>$cat_id]);

                if(Yii::$app->user->identity->access_role =='sekretearis'){
                    $query->andWhere(['kode_prodi'=>Yii::$app->user->identity->prodi]);                    
                }
                
                $query->orderBy(['nama_prodi'=>SORT_ASC]);

                $out = $query->asArray()->all(); 
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                exit;
            }
        }
        // return ['output'=>'', 'selected'=>''];
    }

    /**
     * Lists all ProgramStudi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProgramStudiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProgramStudi model.
     * @param int $id ID
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
     * Creates a new ProgramStudi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProgramStudi();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProgramStudi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
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
     * Deletes an existing ProgramStudi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProgramStudi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ProgramStudi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProgramStudi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
