<?php

namespace app\controllers;

use app\models\SimakMagangCatatan;
use app\models\SimakMagangCatatanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SimakMagangCatatanController implements the CRUD actions for SimakMagangCatatan model.
 */
class SimakMagangCatatanController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'denyCallback' => function ($rule, $action) {
            //         throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page');
            //     },
            //     'only' => ['index','view'],
            //     'rules' => [
                    
            //         [
            //             'actions' => [
            //                 'index','view'
            //             ],
            //             'allow' => true,
            //             'roles' => ['theCreator'],
            //         ],
                    
            //     ],
            // ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Lists all SimakMagangCatatan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SimakMagangCatatanSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimakMagangCatatan model.
     * @param string $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = null;
        return $this->renderPartial('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SimakMagangCatatan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    

    /**
     * Finds the SimakMagangCatatan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return SimakMagangCatatan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakMagangCatatan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
