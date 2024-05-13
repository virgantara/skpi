<?php

namespace app\controllers;

use Yii;
use app\models\SimakMastermahasiswa;
use app\models\SkpiPermohonan;
use app\models\SkpiPermohonanSearch;
use yii\web\Controller;
use app\helpers\MyHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SkpiPermohonanController implements the CRUD actions for SkpiPermohonan model.
 */
class SkpiPermohonanController extends Controller
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
                'only' => ['create','update','delete','index','ajax-apply'],
                'rules' => [
                    [
                        'actions' => ['update','delete','index'],
                        'allow' => true,
                        'roles' => ['akpamPusat','admin','sekretearis','fakultas'],
                    ],
                    [
                        'actions' => ['create','ajax-apply'],
                        'allow' => true,
                        'roles' => ['Mahasiswa'],
                    ],
                    [
                        'actions' => [
                            'create','update','delete','index','view'
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

    public function actionAjaxApply()
    {
        $results = [
            'code' => 406,
            'message' => 'Bad Request'
        ] ;
        if (!Yii::$app->user->isGuest && Yii::$app->request->isPost) {
            if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
                $model = SkpiPermohonan::findOne(['nim' => Yii::$app->user->identity->nim]);

                if(!empty($model)){
                    $results = [
                        'code' => 500,
                        'message' => 'Anda saat ini sudah memiliki permohonan SKPI'
                    ] ;         
                }

                else{
                    $model = new SkpiPermohonan;
                    $model->id = MyHelper::gen_uuid();
                    $model->tanggal_pengajuan = date('YmdHis');
                    $model->status_pengajuan = '1';
                    $model->nim = Yii::$app->user->identity->nim;
                    if($model->save()){
                        $results = [
                            'code' => 200,
                            'message' => 'Data permohonan SKPI berhasil diajukan'
                        ] ;  
                    }

                    else{
                        $error = MyHelper::logError($model);
                        $results = [
                            'code' => 500,
                            'message' => $error
                        ] ; 
                    }
                }    
            }
            
        }

        echo json_encode($results);
        exit;
    }

    /**
     * Lists all SkpiPermohonan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SkpiPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $kode_prodi = '';
        $list_prodi = [];
        if (!Yii::$app->user->isGuest) {
            if(Yii::$app->user->identity->access_role == 'sekretearis'){
                $kode_prodi = Yii::$app->user->identity->prodi;
                $listProdi = \app\models\SimakMasterprogramstudi::find()->where(['kode_prodi' => $kode_prodi])->all();

                foreach ($listProdi as $item_name) {
                    $list_prodi[$item_name->kode_prodi] = $item_name->nama_prodi;
                } 
            }
            else if(Yii::$app->user->identity->access_role == 'fakultas'){
                $kode_fakultas = Yii::$app->user->identity->fakultas;
                $listProdi = \app\models\SimakMasterprogramstudi::find()->where(['kode_fakultas' => $kode_fakultas])->all();

                foreach ($listProdi as $item_name) {
                    $list_prodi[$item_name->kode_prodi] = $item_name->nama_prodi;
                } 
            }
            else{
                $list_fakultas = \app\models\SimakMasterfakultas::find()->orderBy(['nama_fakultas'=>SORT_ASC])->all();
            }
        }
        if (Yii::$app->request->post('hasEditable')) {

            // instantiate your book model for saving
            $id = Yii::$app->request->post('editableKey');
            $model = SkpiPermohonan::findOne($id);

            // store a default json response as desired by editable
            $out = json_encode(['output' => '', 'message' => '']);

            $posted = current($_POST['SkpiPermohonan']);
            $post = ['SkpiPermohonan' => $posted];

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
            exit;
        }


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'kode_prodi' => $kode_prodi,
            'list_prodi' => $list_prodi
        ]);
    }

    /**
     * Displays a single SkpiPermohonan model.
     * @param string $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $mhs = $model->nim0;
        return $this->render('view', [
            'model' => $model,
            'mhs' => $mhs
        ]);
    }

    /**
     * Creates a new SkpiPermohonan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SkpiPermohonan();
        $model->id = MyHelper::gen_uuid();
        $model->tanggal_pengajuan = date('Y-m-d H:i:s');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SkpiPermohonan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->approved_by = Yii::$app->user->identity->id;
            if($model->save()){
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SkpiPermohonan model.
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
     * Finds the SkpiPermohonan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return SkpiPermohonan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SkpiPermohonan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
