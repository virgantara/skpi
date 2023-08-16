<?php

namespace app\controllers;

use app\models\SimkatmawaMahasiswa;
use app\models\SimkatmawaMandiri;
use app\models\SimkatmawaMandiriSearch;
use app\models\SimkatmawaRekognisi;
use DateTime;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SimkatmawaMandiriController implements the CRUD actions for SimkatmawaMandiri model.
 */
class SimkatmawaMandiriController extends Controller
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
     * Lists all SimkatmawaMandiri models.
     *
     * @return string
     */

    public function actionIndex()
    {
        return $this->render('index', [
            // 'model' => $this->findModel($id),
        ]);
    }

    public function actionRekognisi()
    {
        $searchModel = new SimkatmawaMandiriSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, 'rekognisi');

        return $this->render('rekognisi', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionKegiatanMandiri()
    {
        $searchModel = new SimkatmawaMandiriSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, 'kegiatan-mandiri');

        return $this->render('kegiatan_mandiri', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimkatmawaMandiri model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $path = str_replace("-", "_", $model->jenis_simkatmawa) . '_view';
        return $this->render($path, [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDetailMahasiswa($id)
    {
        return $this->render('detail-mahasiswa', [
            'model' => $this->findModel($id),
            'dataMahasiswa' => SimkatmawaMahasiswa::findAll(['simkatmawa_mandiri_id' => $id])
        ]);
    }

    /**
     * Creates a new SimkatmawaMandiri model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreateRekognisi()
    {
        $model = new SimkatmawaMandiri();

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $insert = $this->insertSimkatmawa($dataPost, 'rekognisi');

            if (isset($insert->id)) {
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['rekognisi']);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect(['rekognisi']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'form' => "rekognisi"
        ]);
    }


    public function actionCreateKegiatanMandiri()
    {
        $model = new SimkatmawaMandiri();

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $insert = $this->insertSimkatmawa($dataPost, 'kegiatan-mandiri');

            if (isset($insert->id)) {
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['kegiatan-mandiri']);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect(['kegiatan-mandiri']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'form' => "kegiatan-mandiri"
        ]);
    }

    public function actionDownload($id, $file)
    {
        $model = SimkatmawaMandiri::findOne($id);
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
     * Updates an existing SimkatmawaMandiri model.
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
            'form' => $model->jenis_simkatmawa
        ]);
    }

    /**
     * Deletes an existing SimkatmawaMandiri model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $jenisSimkatmawa)
    {
        if ($this->findModel($id)->delete() && SimkatmawaMahasiswa::deleteAll(['simkatmawa_mandiri_id' => $id])) {
        }
        Yii::$app->session->setFlash('success', "Data Berhasil Dihapus");
        return $this->redirect([$jenisSimkatmawa]);
    }

    /**
     * Finds the SimkatmawaMandiri model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SimkatmawaMandiri the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimkatmawaMandiri::findOne(['id' => $id])) !== null) {
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

            $dataPost   = $_POST;
            if (Yii::$app->request->post()) {

                if (isset($dataPost['SimkatmawaMandiri']['id'])) {
                    $model = $this->findModel($dataPost['SimkatmawaMandiri']['id']);
                } else {
                    $model = new SimkatmawaMandiri;
                }

                $model->attributes = $dataPost['SimkatmawaMandiri'];
                $model->user_id = Yii::$app->user->identity->id;
                $model->jenis_simkatmawa = $jenisSimkatmawa;

                $fotoKaryaPath = UploadedFile::getInstance($model, 'foto_karya_path');
                $fotoPenyerahanPath = UploadedFile::getInstance($model, 'foto_penyerahan_path');
                $laporanPath = UploadedFile::getInstance($model, 'laporan_path');
                $fotoKegiatanPath = UploadedFile::getInstance($model, 'foto_kegiatan_path');
                $sertifikatPath = UploadedFile::getInstance($model, 'sertifikat_path');
                $suratTugasPath = UploadedFile::getInstance($model, 'surat_tugas_path');

                
                $curdate    = date('d-m-y');
                $labelPath = ucwords(str_replace('-', ' ', $jenisSimkatmawa));
                
                if (isset($fotoKaryaPath)) {
                    $file_name  = $model->nama_kegiatan . '-' . $curdate;
                    $s3path     = $fotoKaryaPath->tempName;
                    $s3type     = $fotoKaryaPath->type;
                    $key        = 'SimkatmawaMandiri' . '/' . $labelPath . '/' . $model->nama_kegiatan . '/' . 'foto_karya-' . $file_name . '.pdf';
                    $insert = $s3new->putObject([
                        'Bucket'        => 'sikap',
                        'Key'           => $key,
                        'Body'          => 'Body',
                        'SourceFile'    => $s3path,
                        'ContenType'    => $s3type,
                    ]);
                    $plainUrl = $s3new->getObjectUrl('sikap', $key);
                    $model->foto_karya_path = $plainUrl;
                }
                
                if (isset($fotoPenyerahanPath)) {
                    $file_name  = $model->nama_kegiatan . '-' . $curdate;
                    $s3path     = $fotoPenyerahanPath->tempName;
                    $s3type     = $fotoPenyerahanPath->type;
                    $key        = 'SimkatmawaMandiri' . '/' . $labelPath . '/' . $model->nama_kegiatan . '/' . 'foto_penyerahan-' . $file_name . '.pdf';
                    $insert = $s3new->putObject([
                        'Bucket'        => 'sikap',
                        'Key'           => $key,
                        'Body'          => 'Body',
                        'SourceFile'    => $s3path,
                        'ContenType'    => $s3type,
                    ]);
                    $plainUrl = $s3new->getObjectUrl('sikap', $key);
                    $model->foto_penyerahan_path = $plainUrl;
                }
                
                if (isset($laporanPath)) {
                    $file_name  = $model->nama_kegiatan . '-' . $curdate;
                    $s3path     = $laporanPath->tempName;
                    $s3type     = $laporanPath->type;
                    $key        = 'SimkatmawaMandiri' . '/' . $labelPath . '/' . $model->nama_kegiatan . '/' . 'laporan-' . $file_name . '.pdf';
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

                if (isset($fotoKegiatanPath)) {
                    $file_name  = $model->nama_kegiatan . '-' . $curdate;
                    $s3path     = $fotoKegiatanPath->tempName;
                    $s3type     = $fotoKegiatanPath->type;
                    $key        = 'SimkatmawaMandiri' . '/' . $labelPath . '/' . $model->nama_kegiatan . '/' . 'foto_kegiatan-' . $file_name . '.pdf';
                    $insert = $s3new->putObject([
                        'Bucket'        => 'sikap',
                        'Key'           => $key,
                        'Body'          => 'Body',
                        'SourceFile'    => $s3path,
                        'ContenType'    => $s3type,
                    ]);
                    $plainUrl = $s3new->getObjectUrl('sikap', $key);
                    $model->foto_kegiatan_path = $plainUrl;
                }

                if (isset($sertifikatPath)) {
                    $file_name  = $model->nama_kegiatan . '-' . $curdate;
                    $s3path     = $sertifikatPath->tempName;
                    $s3type     = $sertifikatPath->type;
                    $key        = 'SimkatmawaMandiri' . '/' . $labelPath . '/' . $model->nama_kegiatan . '/' . 'sertifikat-' . $file_name . '.pdf';
                    $insert = $s3new->putObject([
                        'Bucket'        => 'sikap',
                        'Key'           => $key,
                        'Body'          => 'Body',
                        'SourceFile'    => $s3path,
                        'ContenType'    => $s3type,
                    ]);
                    $plainUrl = $s3new->getObjectUrl('sikap', $key);
                    $model->sertifikat_path = $plainUrl;
                }

                if (isset($suratTugasPath)) {
                    $file_name  = $model->nama_kegiatan . '-' . $curdate;
                    $s3path     = $suratTugasPath->tempName;
                    $s3type     = $suratTugasPath->type;
                    $key        = 'SimkatmawaMandiri' . '/' . $labelPath . '/' . $model->nama_kegiatan . '/' . 'surat_tugas-' . $file_name . '.pdf';
                    $insert = $s3new->putObject([
                        'Bucket'        => 'sikap',
                        'Key'           => $key,
                        'Body'          => 'Body',
                        'SourceFile'    => $s3path,
                        'ContenType'    => $s3type,
                    ]);
                    $plainUrl = $s3new->getObjectUrl('sikap', $key);
                    $model->surat_tugas_path = $plainUrl;
                }
                
                if ($model->save()) {

                    if (!empty($dataPost['hint'][0])) {

                        foreach ($dataPost['hint'] as $mhs) {
                            $data = explode(' - ', $mhs);
                            
                            if (strlen($mhs) > 12) {

                                $mahasiswa = SimkatmawaMahasiswa::findOne(['simkatmawa_mandiri_id' => $model->id, 'nim' => $data[0]]);
                                
                                if (isset($mahasiswa))  $this->findMahasiswa($mahasiswa->id);
                                else $mahasiswa = new SimkatmawaMahasiswa();
                                
                                $mahasiswa->simkatmawa_mandiri_id = $model->id;
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
