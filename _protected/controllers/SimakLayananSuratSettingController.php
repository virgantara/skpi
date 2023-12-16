<?php

namespace app\controllers;

use Yii;
use app\models\SimakLayananSuratSetting;
use app\models\SimakLayananSuratSettingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * SimakLayananSuratSettingController implements the CRUD actions for SimakLayananSuratSetting model.
 */
class SimakLayananSuratSettingController extends Controller
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
                'only' => ['create', 'update', 'view', 'index', 'delete', 'download', 'approve'],
                'rules' => [

                    [
                        'actions' => [
                            'update', 'view', 'index', 'download', 'approve'
                        ],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => [
                            'update', 'view', 'index', 'delete', 'download', 'approve'
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

    /**
     * Lists all SimakLayananSuratSetting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SimakLayananSuratSettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimakLayananSuratSetting model.
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

    public function actionUpdate()
    {

        if (!Yii::$app->user->isGuest && Yii::$app->user->can('admin')) {
            $model = SimakLayananSuratSetting::findOne(['kode_fakultas' => 'dkp']);

            if (empty($model)) {
                $model = new SimakLayananSuratSetting;
            }

            $model->kode_fakultas = 'dkp';

            $file_header_path = $model->file_header_path;
            $file_footer_path = $model->file_footer_path;
            $file_sign_path = $model->file_sign_path;


            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();

            $s3config = Yii::$app->params['s3'];

            $s3 = new \Aws\S3\S3Client($s3config);
            $errors = '';

            try {

                if ($model->load(Yii::$app->request->post())) {


                    $model->file_header_path = UploadedFile::getInstance($model, 'file_header_path');
                    $model->file_footer_path = UploadedFile::getInstance($model, 'file_footer_path');
                    $model->file_sign_path = UploadedFile::getInstance($model, 'file_sign_path');

                    if ($model->file_header_path) {
                        $file_name = 'kop_surat_dkp.' . $model->file_header_path->extension;
                        $s3_path = $model->file_header_path->tempName;
                        $mime_type = $model->file_header_path->type;
                        $key = 'dkp/' . $file_name;

                        $insert = $s3->putObject([
                            'Bucket' => 'siakad',
                            'Key'    => $key,
                            'Body'   => 'This is the Body',
                            'SourceFile' => $s3_path,
                            'ContentType' => $mime_type
                        ]);


                        $plainUrl = $s3->getObjectUrl('siakad', $key);
                        $model->file_header_path = $plainUrl;
                    }

                    if ($model->file_footer_path) {
                        $file_name = 'footer_dkp.' . $model->file_footer_path->extension;
                        $s3_path = $model->file_footer_path->tempName;
                        $mime_type = $model->file_footer_path->type;
                        $key = 'dkp/' . $file_name;

                        $insert = $s3->putObject([
                            'Bucket' => 'siakad',
                            'Key'    => $key,
                            'Body'   => 'This is the Body',
                            'SourceFile' => $s3_path,
                            'ContentType' => $mime_type
                        ]);


                        $plainUrl = $s3->getObjectUrl('siakad', $key);
                        $model->file_footer_path = $plainUrl;
                    }

                    if ($model->file_sign_path) {
                        $file_name = 'sign_direktur_dkp_.' . $model->file_sign_path->extension;
                        $s3_path = $model->file_sign_path->tempName;
                        $mime_type = $model->file_sign_path->type;
                        $key = 'dkp/' . $file_name;

                        $insert = $s3->putObject([
                            'Bucket' => 'siakad',
                            'Key'    => $key,
                            'Body'   => 'This is the Body',
                            'SourceFile' => $s3_path,
                            'ContentType' => $mime_type
                        ]);


                        $plainUrl = $s3->getObjectUrl('siakad', $key);
                        $model->file_sign_path = $plainUrl;
                    }

                    if (empty($model->file_header_path))
                        $model->file_header_path = $file_header_path;

                    if (empty($model->file_footer_path))
                        $model->file_footer_path = $file_footer_path;

                    if (empty($model->file_sign_path))
                        $model->file_sign_path = $file_sign_path;

                    if ($model->save()) {
                        $transaction->commit();

                        Yii::$app->session->setFlash('success', "Data tersimpan");
                        return $this->redirect(['update']);
                    }
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                $errors .= $e->getMessage();
                Yii::$app->session->setFlash('danger', $errors);
            } catch (\Throwable $e) {
                $transaction->rollBack();
                $errors .= $e->getMessage();
                Yii::$app->session->setFlash('danger', $errors);
            }


            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SimakLayananSuratSetting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SimakLayananSuratSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SimakLayananSuratSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakLayananSuratSetting::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
