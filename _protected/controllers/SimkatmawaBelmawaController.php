<?php

namespace app\controllers;

use app\models\SimkatmawaBelmawa;
use app\models\SimkatmawaBelmawaKategori;
use app\models\SimkatmawaBelmawaSearch;
use app\models\SimkatmawaMahasiswa;
use DateTime;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SimkatmawaBelmawaController implements the CRUD actions for SimkatmawaBelmawa model.
 */
class SimkatmawaBelmawaController extends Controller
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
     * Lists all SimkatmawaBelmawa models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SimkatmawaBelmawaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimkatmawaBelmawa model.
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
     * Creates a new SimkatmawaBelmawa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SimkatmawaBelmawa();

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $insert = $this->insertSimkatmawa($dataPost, 'belmawa');

            if (isset($insert->id)) {
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDownload($id, $file)
    {
        $model = SimkatmawaBelmawa::findOne($id);
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

    /**
     * Updates an existing SimkatmawaBelmawa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $dataPost['SimkatmawaBelmawa']['id'] = $id;
            echo '<pre>';print_r($dataPost);die;
            $insert = $this->insertSimkatmawa($dataPost, $model->jenis_simkatmawa, false);

            if (isset($insert->id)) {
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SimkatmawaBelmawa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete() && SimkatmawaMahasiswa::deleteAll(['simkatmawa_belmawa_id' => $id])) {
            Yii::$app->session->setFlash('success', "Data Berhasil Dihapus");
            return $this->redirect(['index']);
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the SimkatmawaBelmawa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SimkatmawaBelmawa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimkatmawaBelmawa::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findMahasiswa($id)
    {
        if (($model = SimkatmawaMahasiswa::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function insertSimkatmawa($dataPost, $jenisSimkatmawa)
    {
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        $s3config = Yii::$app->params['s3'];

        $s3new = new \Aws\S3\S3Client($s3config);
        $errors = '';

        try {

            if (Yii::$app->request->post()) {

                if (isset($dataPost['SimkatmawaBelmawa']['id'])) {
                    $model = $this->findModel($dataPost['SimkatmawaBelmawa']['id']);
                } else {
                    $model = new SimkatmawaBelmawa;
                }

                $model->attributes = $dataPost['SimkatmawaBelmawa'];
                $model->user_id = Yii::$app->user->identity->id;
                $simkatmawaKategori = SimkatmawaBelmawaKategori::findOne($model->simkatmawa_belmawa_kategori_id);

                $laporanPath = UploadedFile::getInstance($model, 'laporan_path');

                $curdate    = date('d-m-y');
                $labelPath = ucwords(str_replace('-', ' ', $jenisSimkatmawa));

                if (isset($laporanPath)) {
                    $file_name  = $model->nama_kegiatan . '-' . $curdate;
                    $s3path     = $laporanPath->tempName;
                    $s3type     = $laporanPath->type;
                    $key        = 'SimkatmawaBelmawa' . '/' . $simkatmawaKategori->nama . '/' . $model->nama_kegiatan . '/' . 'laporan-' . $file_name . '.pdf';
                    $insert = $s3new->putObject([
                        'Bucket'        => 'sikap',
                        'Key'           => $key,
                        'Body'          => 'Body',
                        'SourceFile'    => $s3path,
                        'ContenType'    => $s3type,
                    ]);
                    $plainUrl = $s3new->getObjectUrl('sikap', $key);
                    $model->laporan_path = $plainUrl;
                }

                if ($model->save()) {

                    if (!empty($dataPost['hint'][0])) {

                        foreach ($dataPost['hint'] as $mhs) {
                            $data = explode(' - ', $mhs);

                            if (strlen($mhs) > 12) {
                                
                                $mahasiswa = SimkatmawaMahasiswa::findOne(['simkatmawa_belmawa_id' => $model->id, 'nim' => $data[0]]);
                                
                                if (isset($mahasiswa))  $this->findMahasiswa($mahasiswa->id);
                                else $mahasiswa = new SimkatmawaMahasiswa();
    
                                $mahasiswa->simkatmawa_belmawa_id = $model->id;
                                $mahasiswa->nim = $data[0];
                                $mahasiswa->nama = $data[1];
                                $mahasiswa->prodi = $data[2];
                                $mahasiswa->kampus = $data[3];
                                $mahasiswa->save();
                            }

                        }
                    }
                    
                    $transaction->commit();
                    return $model;
                }
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            $errors .= $e->getMessage();
            return $errors;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            $errors .= $e->getMessage();
            return $errors;
        }

        die();
    }
}
