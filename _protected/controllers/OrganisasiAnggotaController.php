<?php

namespace app\controllers;

use Yii;
use app\models\OrganisasiAnggota;
use app\models\OrganisasiAnggotaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * OrganisasiAnggotaController implements the CRUD actions for OrganisasiAnggota model.
 */
class OrganisasiAnggotaController extends Controller
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
                'only' => ['create','update','delete','index','view','ajax-create'],
                'rules' => [
                    [
                        'actions' => ['ajax-create','create','update','delete','index','view'],
                        'allow' => true,
                        'roles' => ['stafBAPAK','admin','operatorCabang'],
                    ],
                    [
                        'actions' => ['index','view'],
                        'allow' => true,
                        'roles' => ['asesor'],
                    ],
                    [
                        'actions' => [
                            'create','update','delete','index','view','ajax-create'
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

    public function actionAjaxCreate()
    {   
        $results = [];
        if(Yii::$app->request->isPost)
        {
            $dataPost = $_POST['dataPost'];

            $model = new OrganisasiAnggota;
            $model->attributes = $dataPost;
            if($model->save())
            {
                $results = [
                    'code' => 200,
                    'message' => 'Data Added'
                ];
            }

            else
            {
                $results = [
                    'code' => 500,
                    'message' => \app\helpers\MyHelper::logError($model)
                ];
            }
        }

        echo json_encode($results);
        die();
    }

    /**
     * Lists all OrganisasiAnggota models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrganisasiAnggotaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrganisasiAnggota model.
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
     * Creates a new OrganisasiAnggota model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrganisasiAnggota();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OrganisasiAnggota model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing OrganisasiAnggota model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $parent = $model->organisasi;

        $model->delete();

        return $this->redirect(['organisasi-mahasiswa/view','id'=>$parent->id]);
    }

    /**
     * Finds the OrganisasiAnggota model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrganisasiAnggota the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrganisasiAnggota::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
