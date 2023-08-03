<?php

namespace app\controllers;

use app\models\SimkatmawaKegiatan;
use app\models\SimkatmawaNonLomba;
use app\models\SimkatmawaNonLombaSearch;
use DateTime;
use Yii;
use yii\debug\panels\DumpPanel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SimkatmawaNonLombaController implements the CRUD actions for SimkatmawaNonLomba model.
 */
class SimkatmawaNonLombaController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all SimkatmawaNonLomba models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SimkatmawaNonLombaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDownload($id, $file)
    {
        $model = SimkatmawaNonLomba::findOne($id);
        $file_path = $model->$file;
        $file = file_get_contents($file_path);
        $nama = basename($file_path);
        $parts = explode('-', $nama);
        $jenisData = $parts[0];
        $curdate = date('d-m-y');
        $filename = $jenisData . '-' . $model->nama_kegiatan . '-' .  $curdate;
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($file));
        header('Accept-Ranges: bytes');
        echo $file;
        exit;
    }

    public function actionPembinaanMentalKebangsaan()
    {
        $searchModel = new SimkatmawaNonLombaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('pembinaan-mental-kebangsaan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimkatmawaNonLomba model.
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
     * Creates a new SimkatmawaNonLomba model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {

        $model = new SimkatmawaNonLomba;
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        $s3config = Yii::$app->params['s3'];

        $s3new = new \Aws\S3\S3Client($s3config);
        $errors = '';

        try {

            $dataPost   = $_POST;
            if (Yii::$app->request->post()) {

                $update = false;
                if (isset($dataPost['SimkatmawaNonLomba']['id'])) {
                    $model = $this->findModel($dataPost['SimkatmawaNonLomba']['id']);
                    $update = true;
                } else {
                    $model = new SimkatmawaNonLomba;
                }

                $model->attributes = $dataPost['SimkatmawaNonLomba'];
                $model->user_id = Yii::$app->user->identity->id;

                $dateTime = DateTime::createFromFormat('d-m-Y', $dataPost['SimkatmawaNonLomba']['tanggal_mulai']);
                $formattedDateMulai = $dateTime->format('Y-m-d');
                $model->tanggal_mulai = $formattedDateMulai;

                $dateTime = DateTime::createFromFormat('d-m-Y', $dataPost['SimkatmawaNonLomba']['tanggal_selesai']);
                $formattedDateSelesai = $dateTime->format('Y-m-d');
                $model->tanggal_selesai = $formattedDateSelesai;

                $model->laporan_path = UploadedFile::getInstance($model, 'laporan_path');
                $model->foto_kegiatan_path = UploadedFile::getInstance($model, 'foto_kegiatan_path');

                $jenisKegiatan = SimkatmawaKegiatan::findOne($model->simkatmawa_kegiatan_id);

                if ($model->laporan_path && $model->foto_kegiatan_path) {
                    $curdate    = date('d-m-y');

                    $file_name1  = $model->nama_kegiatan . '-' . $curdate;
                    $s3path1     = $model->laporan_path->tempName;
                    $s3type1     = $model->laporan_path->type;
                    $key1        = 'SimkatmawaNonLomba' . '/' . $jenisKegiatan->nama . '/' . $model->nama_kegiatan . '/' . 'laporan-' . $file_name1 . '.pdf';

                    $insert = $s3new->putObject([
                        'Bucket'        => 'sikap',
                        'Key'           => $key1,
                        'Body'          => 'Body',
                        'SourceFile'    => $s3path1,
                        'ContenType'    => $s3type1,
                    ]);

                    $file_name2  = $model->nama_kegiatan . '-' . $curdate;
                    $s3path2     = $model->foto_kegiatan_path->tempName;
                    $s3type2     = $model->foto_kegiatan_path->type;
                    $key2        = 'SimkatmawaNonLomba' . '/' . $jenisKegiatan->nama . '/' . $model->nama_kegiatan . '/' . 'foto_kegiatan-' . $file_name2 . '.pdf';

                    $insert = $s3new->putObject([
                        'Bucket'        => 'sikap',
                        'Key'           => $key2,
                        'Body'          => 'Body',
                        'SourceFile'    => $s3path2,
                        'ContenType'    => $s3type2,
                    ]);

                    $plainUrl1 = $s3new->getObjectUrl('sikap', $key1);
                    $plainUrl2 = $s3new->getObjectUrl('sikap', $key2);
                    $model->laporan_path = $plainUrl1;
                    $model->foto_kegiatan_path = $plainUrl2;

                    if ($model->save()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', "Data tersimpan");
                        return $this->redirect(['pembinaan-mental-kebangsaan']);
                    }
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

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SimkatmawaNonLomba model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
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
     * Deletes an existing SimkatmawaNonLomba model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['pembinaan-mental-kebangsaan']);
    }

    /**
     * Finds the SimkatmawaNonLomba model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SimkatmawaNonLomba the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimkatmawaNonLomba::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
