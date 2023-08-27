<?php

namespace app\controllers;
use Yii;
use app\models\SimakMagang;
use app\models\SimakMagangSearch;
use app\models\SimakMagangCatatan;
use app\models\SimakMagangCatatanSearch;

use app\models\SimakMagangNilai;
use app\models\SimakMagangNilaiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * SimakMagangController implements the CRUD actions for SimakMagang model.
 */
class SimakMagangController extends Controller
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
                'only' => ['create','update','delete'],
                'rules' => [
                    
                    [
                        'actions' => [
                            'index','view'
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

    public function actionDownloadSuratTugas($id)
    {
        $model = $this->findModel($id);
        if(empty($model->file_surat_tugas)){
            Yii::$app->session->setFlash('danger', 'Mohon maaf, file ini tidak ada');
            return $this->redirect(['view','id'=>$id]);
        }

        $file = $model->file_surat_tugas;

        $filename = 'Surat Tugas Magang '.$model->nim.'.pdf';

        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
          
        // Read the file
        @readfile($file);
        exit;
    }

    public function actionDownloadSkMagang($id)
    {
        $model = $this->findModel($id);
        if(empty($model->file_sk_penerimaan_magang)){
            Yii::$app->session->setFlash('danger', 'Mohon maaf, file ini tidak ada');
            return $this->redirect(['view','id'=>$id]);
        }

        $file = $model->file_sk_penerimaan_magang;

        $filename = 'SK Penerimaan Magang '.$model->nim.'.pdf';

        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
          
        // Read the file
        @readfile($file);
        exit;
    }

    public function actionDownload($id)
    {
        $model = $this->findModel($id);
        if(empty($model->file_laporan)){
            Yii::$app->session->setFlash('danger', 'Mohon maaf, file ini tidak ada');
            return $this->redirect(['view','id'=>$id]);
        }

        $file = $model->file_laporan;

        $filename = 'Laporan Magang '.$model->nim.'.pdf';

        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
          
        // Read the file
        @readfile($file);
        exit;
    }

    /**
     * Lists all SimakMagang models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SimakMagangSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimakMagang model.
     * @param string $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new SimakMagangCatatanSearch();
        $searchModel->magang_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new SimakMagang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SimakMagang();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SimakMagang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
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
     * @return \yii\web\Response
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
        if (($model = SimakMagang::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
