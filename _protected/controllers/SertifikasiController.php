<?php

namespace app\controllers;

use Yii;
use app\models\SimakSertifikasi;
use app\models\SimakSertifikasiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\helpers\MyHelper;

use yii\web\UploadedFile;
/**
 * SertifikasiController implements the CRUD actions for SimakSertifikasi model.
 */
class SertifikasiController extends Controller
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
                        'roles' => ['akpamPusat','admin','sekretearis','fakultas'],
                    ],
                    [
                        'actions' => ['ajax-get','download','create','update','delete','index','view'],
                        'allow' => true,
                        'roles' => ['Mahasiswa'],
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
        $filename = 'Sertifikasi_'.$model->nim.' - '.$model->nim0->nama_mahasiswa.'.pdf';

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
            
            $list = SimakSertifikasi::find()->where(['nim'=> $nim,'status_validasi' => '1'])->all();
            $list_jenis_sertifikasi = MyHelper::getJenisSertifikasi();
            $items = [];
            foreach($list as $item){
                $items[] = [
                    'jenis_sertifikasi' => $list_jenis_sertifikasi[$item->jenis_sertifikasi],
                    'lembaga_sertifikasi' => $item->lembaga_sertifikasi,
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
     * Lists all SimakSertifikasi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SimakSertifikasiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimakSertifikasi model.
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
     * Creates a new SimakSertifikasi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/logout']);
        }

        $model = new SimakSertifikasi();
        $model->id = MyHelper::gen_uuid();

        if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
            $model->nim = Yii::$app->user->identity->nim;
        }

        if ($model->load(Yii::$app->request->post())) {

            $s3config = Yii::$app->params['s3'];

            $s3 = new \Aws\S3\S3Client($s3config);
            $errors = '';
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();

            $model->file_path = UploadedFile::getInstance($model, 'file_path');
            
            try {
                if ($model->file_path) {
                    $file_name = $model->id.'.'.$model->file_path->extension;
                    $s3_path = $model->file_path->tempName;
                    $mime_type = $model->file_path->type;
                                    
                    $key = 'sertifikasi/'.$model->nim.'/'.$file_name;
                     
                    $insert = $s3->putObject([
                         'Bucket' => 'siakad',
                         'Key'    => $key,
                         'Body'   => 'This is the Body',
                         'SourceFile' => $s3_path,
                         'ContentType' => $mime_type
                    ]);

                    
                    $plainUrl = $s3->getObjectUrl('siakad', $key);
                    $model->file_path = $plainUrl;
                   
                }

                if($model->validate()){
                    $model->save();
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Data tersimpan");
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            catch (\Exception $e) {
                $transaction->rollBack();
                $errors .= $e->getMessage();
                Yii::$app->session->setFlash('danger', $errors);
            } 
            catch (\Throwable $e) {
                $transaction->rollBack();
                $errors .= $e->getMessage();
                Yii::$app->session->setFlash('danger', $errors);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SimakSertifikasi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if($model->status_validasi == '1'){
            return $this->redirect(['view','id' => $id]);
        }
        $s3config = Yii::$app->params['s3'];

        $s3 = new \Aws\S3\S3Client($s3config);
        $errors = '';
        $file_path = $model->file_path;
        if ($model->load(Yii::$app->request->post())) {
            
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            $model->file_path = UploadedFile::getInstance($model, 'file_path');
            try {
                
                if ($model->file_path) {
                    $file_name = $model->id.'.'.$model->file_path->extension;
                    $s3_path = $model->file_path->tempName;
                    $mime_type = $model->file_path->type;
                                    
                    $key = 'sertifikasi/'.$model->nim.'/'.$file_name;
                     
                    $insert = $s3->putObject([
                         'Bucket' => 'siakad',
                         'Key'    => $key,
                         'Body'   => 'This is the Body',
                         'SourceFile' => $s3_path,
                         'ContentType' => $mime_type
                    ]);

                    
                    $plainUrl = $s3->getObjectUrl('siakad', $key);
                    $model->file_path = $plainUrl;
                   
                }

                
                if (empty($model->file_path)){
                     $model->file_path = $file_path;
                }

                if($model->save())
                {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Data updated");
                    return $this->redirect(['view', 'id' => $model->id]);    
                        
                }
            }
            catch (\Exception $e) {
                $transaction->rollBack();
                $errors .= $e->getMessage();
                Yii::$app->session->setFlash('danger', $errors);
            } 
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SimakSertifikasi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->status_validasi == '1'){
            Yii::$app->session->setFlash('danger', 'This item cannot be deleted');
            return $this->redirect(['view','id' => $id]);
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SimakSertifikasi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return SimakSertifikasi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakSertifikasi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
