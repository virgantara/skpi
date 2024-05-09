<?php

namespace app\controllers;

use Yii;
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
                'only' => ['create','update','delete'],
                'rules' => [
                    [
                        'actions' => ['create','update','delete'],
                        'allow' => true,
                        'roles' => ['akpamPusat','admin'],
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

    /**
     * Lists all SkpiPermohonan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SkpiPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        return $this->render('view', [
            'model' => $this->findModel($id),
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['view', 'id' => $model->id]);
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
