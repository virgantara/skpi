<?php

namespace app\controllers;

use Yii;
use app\models\SimakTes;
use app\models\SimakTesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\helpers\MyHelper;
/**
 * TesController implements the CRUD actions for SimakTes model.
 */
class TesController extends Controller
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
                'only' => ['create','update','delete','index','view','ajax-get','download'],
                'rules' => [
                    [
                        'actions' => ['create','update','delete','ajax-get','download'],
                        'allow' => true,
                        'roles' => ['akpamPusat','admin'],
                    ],
                    [
                        'actions' => [
                            'create','update','delete','index','view','ajax-get','download'
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

    public function actionDownload($id) 
    { 
        $model = $this->findModel($id);
        $file = $model->file_path;
        if(empty($model->file_path)){
            Yii::$app->session->setFlash('danger', 'Mohon maaf, file ini tidak ada');
            return $this->redirect(['view','id'=>$id]);
        }
        $filename = 'Tes_'.$model->nim.' - '.$model->nim0->nama_mahasiswa.'.pdf';

        // Header content type
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
          
        // Read the file
        @readfile($file);
        exit;
    
    }

    public function actionAjaxGet()
    {
        $results = [
            'code' => 406,
            'message' => 'Bad Request'
        ] ;
        if (Yii::$app->request->isPost && !empty($_POST['dataPost']) && !empty($_POST['dataPost']['nim'])) 
        {
            $nim = $_POST['dataPost']['nim'];
            
            $list = SimakTes::find()->where(['nim'=> $nim,'status_validasi' => '1'])->all();
            $list_jenis_tes = MyHelper::getJenisTes();
            $items = [];
            foreach($list as $item){
                $items[] = [
                    'jenis_tes' => $list_jenis_tes[$item->jenis_tes],
                    'nama_tes' => $item->nama_tes.' dengan skor '.$item->skor_tes,
                    'penyelenggara' => $item->penyelenggara,
                    'id' => $item->id
                ]; 
            }

            $results = [
                'code' => 200,
                'message' => 'Success',
                'items' => $items
            ];
            
        }

        echo json_encode($results);
        die();
            
    }

    /**
     * Lists all SimakTes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SimakTesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimakTes model.
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
     * Creates a new SimakTes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SimakTes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SimakTes model.
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
     * Deletes an existing SimakTes model.
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
     * Finds the SimakTes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return SimakTes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakTes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
