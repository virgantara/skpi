<?php

namespace app\controllers;
use Yii;
use app\models\SimakKampusKoordinator;
use app\models\SimakKampusKoordinatorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * SimakKampusKoordinatorController implements the CRUD actions for SimakKampusKoordinator model.
 */
class SimakKampusKoordinatorController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page');
                },
                'only' => ['create','update','view','index','delete','download','approve'],
                'rules' => [
                    [
                        'actions' => [
                            'create','view','index','delete','update'
                        ],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    
                    [
                        'actions' => [
                            'create','update','view','index','delete','download','approve'
                        ],
                        'allow' => true,
                        'roles' => ['theCreator'],
                    ],
                    
                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionList()
    {
        $kampus_id = $_POST['kampus_id'];
        $results = [];
        if (!empty($kampus_id)) {
            $temp = SimakKampusKoordinator::find()->where(['kampus_id' => $kampus_id])->all();
            foreach ($temp as $t) {
                $results[] = [
                    'id' => $t->id,
                    'nama' => $t->nama_koordinator
                ];
            }
            echo json_encode($results);
        }
        die();
    }

    /**
     * Lists all SimakKampusKoordinator models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SimakKampusKoordinatorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $id = Yii::$app->request->post('editableKey');
            $model = SimakKampusKoordinator::findOne($id);

            // store a default json response as desired by editable
            $out = json_encode(['output'=>'', 'message'=>'']);

            
            $posted = current($_POST['SimakKampusKoordinator']);
            $post = ['SimakKampusKoordinator' => $posted];

            // load model like any single model validation
            if ($model->load($post)) {
            // can save model or do something before saving model
                if($model->save())
                {
                    $out = json_encode(['output'=>'', 'message'=>'']);
                }

                else
                {
                    $error = \app\helpers\MyHelper::logError($model);
                    $out = json_encode(['output'=>'', 'message'=>'Oops, '.$error]);   
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
     * Displays a single SimakKampusKoordinator model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SimakKampusKoordinator model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SimakKampusKoordinator();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SimakKampusKoordinator model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();

        $s3config = Yii::$app->params['s3'];

        $s3 = new \Aws\S3\S3Client($s3config);
        $errors = '';
        $ttd_path = $model->ttd_path;


        try {
            if ($model->load(Yii::$app->request->post())) {
                $model->ttd_path = UploadedFile::getInstance($model, 'ttd_path');
                
                if ($model->ttd_path) {
                    $file_name = $model->nama_koordinator. '.' . $model->ttd_path->extension;
                    $s3_path = $model->ttd_path->tempName;
                    $mime_type = $model->ttd_path->type;
                    $key = 'TTD Koordinator/'.$model->nama_koordinator. '/' . $file_name;

                    $insert = $s3->putObject([
                        'Bucket' => 'sikap',
                        'Key'    => $key,
                        'Body'   => 'This is the Body',
                        'SourceFile' => $s3_path,
                        'ContentType' => $mime_type
                    ]);


                    $plainUrl = $s3->getObjectUrl('sikap', $key);
                    $model->ttd_path = $plainUrl;

                }

                if(empty($model->ttd_path)){
                    $model->ttd_path = $ttd_path;
                }

                if($model->save()){
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Data tersimpan");
                    return $this->redirect(['index']);
                }
                
            }
        }

        catch (\Exception $e) {
            $transaction->rollBack();
            $errors .= $e->getMessage();
            Yii::$app->session->setFlash('danger', $errors);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SimakKampusKoordinator model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SimakKampusKoordinator model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SimakKampusKoordinator the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakKampusKoordinator::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
