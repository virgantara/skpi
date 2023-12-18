<?php

namespace app\controllers;

use Yii;
use app\models\SimakSyaratBebasAsramaMahasiswa;
use app\models\SimakSyaratBebasAsramaMahasiswaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\helpers\MyHelper;
use app\models\SimakSyaratBebasAsrama;
use yii\web\UploadedFile;
/**
 * SimakSyaratBebasAsramaMahasiswaController implements the CRUD actions for SimakSyaratBebasAsramaMahasiswa model.
 */
class SimakSyaratBebasAsramaMahasiswaController extends Controller
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
                'only' => ['create','update','view','index','delete','download','approve'],
                'rules' => [
                    [
                        'actions' => [
                            'create','view','index','download','delete'
                        ],
                        'allow' => true,
                        'roles' => ['Mahasiswa'],
                    ],
                    [
                        'actions' => [
                            'update','view','index','download','approve'
                        ],
                        'allow' => true,
                        'roles' => ['sekretearis'],
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

    public function actionDownload($id)
    {
        $model = $this->findModel($id);
        $file = $model->file_path;
        if (empty($model->file_path)) {
            Yii::$app->session->setFlash('danger', 'Mohon maaf, file ini tidak ada');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $filename = $model->mhs_id. $model->syarat_id . '.pdf';

        // Header content type
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');

        // Read the file
        @readfile($file);
        exit;
    }


    /**
     * Lists all SimakSyaratBebasAsramaMahasiswa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SimakSyaratBebasAsramaMahasiswaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimakSyaratBebasAsramaMahasiswa model.
     * @param string $id
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
     * Creates a new SimakSyaratBebasAsramaMahasiswa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/logout']);
        }
        $model = new SimakSyaratBebasAsramaMahasiswa();
        $model->id = MyHelper::gen_uuid();

        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();

        $s3config = Yii::$app->params['s3'];

        $s3 = new \Aws\S3\S3Client($s3config);
        $errors = '';


        try {

            if ($model->load(Yii::$app->request->post())) {
                $model->file_path = UploadedFile::getInstance($model, 'file_path');
                $mhs = \app\models\SimakMastermahasiswa::findOne(['nim_mhs' => Yii::$app->user->identity->nim]);
                if ($model->file_path) {
                    $file_name = $model->syarat_id. '_' . $mhs->nim_mhs . '.' . $model->file_path->extension;
                    $s3_path = $model->file_path->tempName;
                    $mime_type = $model->file_path->type;
                    $key = 'Bebas Asrama/'.$model->syarat_id . '/' . $mhs->nim_mhs . '/' . $file_name;

                    $insert = $s3->putObject([
                        'Bucket' => 'sikap',
                        'Key'    => $key,
                        'Body'   => 'This is the Body',
                        'SourceFile' => $s3_path,
                        'ContentType' => $mime_type
                    ]);


                    $plainUrl = $s3->getObjectUrl('sikap', $key);
                    $model->file_path = $plainUrl;

                    $model->mhs_id = $mhs->id;
                    if($model->save()){
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', "Data tersimpan");
                        return $this->redirect(['simak-layanan-surat/view', 'id' => $id]);
                    }
                }
                
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            $errors .= $e->getMessage();
            Yii::$app->session->setFlash('danger', $errors);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SimakSyaratBebasAsramaMahasiswa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/logout']);
        }
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
     * Deletes an existing SimakSyaratBebasAsramaMahasiswa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', "Data berhasil dihapus");
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the SimakSyaratBebasAsramaMahasiswa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SimakSyaratBebasAsramaMahasiswa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakSyaratBebasAsramaMahasiswa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
