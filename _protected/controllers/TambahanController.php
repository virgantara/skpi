<?php

namespace app\controllers;

use Yii;
use app\models\SimakMagang;
use app\models\SimakMagangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TambahanController implements the CRUD actions for SimakMagang model.
 */
class TambahanController extends Controller
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
     * Lists all SimakMagang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SimakMagangSearch();
        $dataProvider = $searchModel->searchTambahan(Yii::$app->request->queryParams);
        $list_prodi = [];
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
            $listProdi = \app\models\SimakMasterprogramstudi::find()->all();

            foreach ($listProdi as $item_name) {
                $list_prodi[$item_name->kode_prodi] = $item_name->nama_prodi;
            } 
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
             'list_prodi' => $list_prodi,
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
