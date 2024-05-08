<?php

namespace app\controllers;

use Yii;

use app\helpers\MyHelper;
use app\models\SimakUniv;
use app\models\SimakUnivSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * SimakUnivController implements the CRUD actions for SimakUniv model.
 */
class SimakUnivController extends Controller
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
                'only' => ['create','update','delete','index','view','up','down'],
                'rules' => [
                    [
                        'actions' => ['create','update','delete','index','view','up','down'],
                        'allow' => true,
                        'roles' => ['akpam','admin'],
                    ],
                    [
                        'actions' => [
                            'create','update','delete','index','view','up','down'
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

    public function actionUp()
    {
        $results = [
            'code' => 406,
            'message' => 'Bad Request'
        ];
        if(Yii::$app->request->isPost && !empty($_POST['dataPost'])){

            $id = $_POST['dataPost']['model_id'];
            $model = $this->findModel($id);

            if(!empty($model)){
                // if($model->urutan >= 1){
                $previousItem = SimakUniv::find()
                    ->where(['<', 'urutan', $model->urutan])
                    ->andWhere(['kode'=>'KKNI1'])
                    ->orderBy(['urutan' => SORT_DESC])
                    ->one();

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    // Retrieve the two models based on ID
                    $item1 = $model;
                    $item2 = $previousItem;

                    if ($item1 === null || $item2 === null) {
                        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
                    }

                    // Swap their sort_order values
                    $tempOrder = $item1->urutan;
                    $item1->urutan = $item2->urutan;
                    $item2->urutan = $tempOrder;

                    // Save both models
                    if ($item1->save(true, ['urutan']) && $item2->save(true, ['urutan'])) {
                        // Commit the transaction
                        $transaction->commit();
                        // Yii::$app->session->setFlash('success', 'Items swapped successfully.');
                    } else {
                        throw new Exception('Failed to save items');
                    }

                    $results = [
                        'code' => 200,
                        'message' => 'Data successfully swapped'
                    ];
                    // return $this->redirect(['index']); // Redirect to a suitable page
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    $results = [
                        'code' => 500,
                        'message' => $e->getMessage()
                    ];
                    // Yii::$app->session->setFlash('error', 'Error swapping items: ' . $e->getMessage());
                    // return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
                }

                // return $this->redirect(['index']);
            }

            else{
                $results = [
                    'code' => 404,
                    'message' => 'Model not found'
                ];
            }
        }

        else{
            $results = [
                'message' => json_encode($_POST)
            ];
        }

        echo json_encode($results);
        die();
        
    }

    public function actionDown()
    {
        $results = [
            'code' => 406,
            'message' => 'Bad Request'
        ];
        if(Yii::$app->request->isPost && !empty($_POST['dataPost'])){
            $id = $_POST['dataPost']['model_id'];
            $model = $this->findModel($id);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $currentItem = $model;
                if (!$currentItem) {
                    throw new \Exception("Current item not found.");
                }

                $nextItem = SimakUniv::find()
                    ->where(['>', 'urutan', $currentItem->urutan])
                    ->andWhere(['kode'=>'KKNI1'])
                    ->orderBy(['urutan' => SORT_ASC])
                    ->one();

                if (!$nextItem) {
                    throw new \Exception("Next item not found.");
                }

                // Swap sort_order values
                $tempOrder = $currentItem->urutan;
                $currentItem->urutan = $nextItem->urutan;
                $nextItem->urutan = $tempOrder;

                if (!$currentItem->save(false,['urutan']) || !$nextItem->save(false,['urutan'])) {
                    throw new \Exception("Failed to save items. Current: ".MyHelper::logError($currentItem)." Next: ".MyHelper::logError($nextItem));
                }

                $transaction->commit();
                $results = [
                        'code' => 200,
                        'message' => 'Data successfully swapped'
                    ];
            } catch (\Exception $e) {
                $transaction->rollBack();
                $results = [
                        'code' => 500,
                        'message' => $e->getMessage()
                    ];
            }

        }
        
        echo json_encode($results);
        die();
    }

    /**
     * Lists all SimakUniv models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SimakUnivSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimakUniv model.
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
     * Creates a new SimakUniv model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SimakUniv();
        $model->kode = 'KKNI1';

        if ($this->request->isPost) {
            $total = SimakUniv::find()->where(['kode'=>'KKNI1'])->count();
            $model->urutan = $total + 1;
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success','Data saved');
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
     * Updates an existing SimakUniv model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success','Data saved');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SimakUniv model.
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
     * Finds the SimakUniv model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SimakUniv the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakUniv::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
