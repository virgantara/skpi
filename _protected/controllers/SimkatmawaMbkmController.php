<?php

namespace app\controllers;

use app\models\SimkatmawaMahasiswa;
use app\models\SimkatmawaMbkm;
use app\models\SimkatmawaMbkmSearch;
use DateTime;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SimkatmawaMbkmController implements the CRUD actions for SimkatmawaMbkm model.
 */
class SimkatmawaMbkmController extends Controller
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
     * Lists all SimkatmawaMbkm models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SimkatmawaMbkmSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPertukaranPelajar()
    {
        $searchModel = new SimkatmawaMbkmSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, 'pertukaran-pelajar');

        return $this->render('pertukaran_pelajar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMengajarDiSekolah()
    {
        $searchModel = new SimkatmawaMbkmSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, 'mengajar-di-sekolah');

        return $this->render('mengajar_di_sekolah', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPenelitian()
    {
        $searchModel = new SimkatmawaMbkmSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, 'penelitian');

        return $this->render('penelitian', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProyekKemanusiaan()
    {
        $searchModel = new SimkatmawaMbkmSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, 'proyek-kemanusiaan');

        return $this->render('proyek_kemanusiaan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProyekDesa()
    {
        $searchModel = new SimkatmawaMbkmSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, 'proyek-desa');

        return $this->render('proyek_desa', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWirausaha()
    {
        $searchModel = new SimkatmawaMbkmSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, 'wirausaha');

        return $this->render('wirausaha', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStudi()
    {
        $searchModel = new SimkatmawaMbkmSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, 'studi');

        return $this->render('studi', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPengabdianMasyarakat()
    {
        $searchModel = new SimkatmawaMbkmSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, 'pengabdian-masyarakat');

        return $this->render('pengabdian_masyarakat', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimkatmawaMbkm model.
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

    /**
     * Creates a new SimkatmawaMbkm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SimkatmawaMbkm();

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

    public function actionCreatePertukaranPelajar()
    {
        $model = new SimkatmawaMbkm();

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $insert = $this->insertSimkatmawa($dataPost, 'pertukaran-pelajar');

            if (isset($insert->id)) {
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['pertukaran-pelajar']);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect(['pertukaran-pelajar']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'form' => "pertukaran-pelajar"
        ]);
    }

    public function actionCreateMengajarDiSekolah()
    {
        $model = new SimkatmawaMbkm();

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $insert = $this->insertSimkatmawa($dataPost, 'mengajar-di-sekolah');

            if (isset($insert->id)) {
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['mengajar-di-sekolah']);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect(['mengajar-di-sekolah']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'form' => "mengajar-di-sekolah"
        ]);
    }

    public function actionCreatePenelitian()
    {
        $model = new SimkatmawaMbkm();

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $insert = $this->insertSimkatmawa($dataPost, 'penelitian');

            if (isset($insert->id)) {
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['penelitian']);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect(['penelitian']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'form' => "penelitian"
        ]);
    }

    public function actionCreateProyekKemanusiaan()
    {
        $model = new SimkatmawaMbkm();

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $insert = $this->insertSimkatmawa($dataPost, 'proyek-kemanusiaan');

            if (isset($insert->id)) {
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['proyek-kemanusiaan']);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect(['proyek-kemanusiaan']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'form' => "proyek-kemanusiaan"
        ]);
    }

    public function actionCreateProyekDesa()
    {
        $model = new SimkatmawaMbkm();

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $insert = $this->insertSimkatmawa($dataPost, 'proyek-desa');

            if (isset($insert->id)) {
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['proyek-desa']);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect(['proyek-desa']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'form' => "proyek-desa"
        ]);
    }

    public function actionCreateWirausaha()
    {
        $model = new SimkatmawaMbkm();

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $insert = $this->insertSimkatmawa($dataPost, 'wirausaha');

            if (isset($insert->id)) {
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['wirausaha']);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect(['wirausaha']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'form' => "wirausaha"
        ]);
    }

    public function actionCreateStudi()
    {
        $model = new SimkatmawaMbkm();

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $insert = $this->insertSimkatmawa($dataPost, 'studi');

            if (isset($insert->id)) {
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['studi']);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect(['studi']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'form' => "studi"
        ]);
    }

    public function actionCreatePengabdianMasyarakat()
    {
        $model = new SimkatmawaMbkm();

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $insert = $this->insertSimkatmawa($dataPost, 'pengabdian-masyarakat');

            if (isset($insert->id)) {
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['pengabdian-masyarakat']);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect(['pengabdian-masyarakat']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'form' => "pengabdian-masyarakat"
        ]);
    }
    /**
     * Updates an existing SimkatmawaMbkm model.
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
            $dataPost['SimkatmawaMbkm']['id'] = $id;
            $insert = $this->insertSimkatmawa($dataPost, $model->jenis_simkatmawa, false);

            if (isset($insert->id)) {
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect([$model->jenis_simkatmawa]);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect([$model->jenis_simkatmawa]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'form' => $model->jenis_simkatmawa,
        ]);
    }


    public function actionDownload($id, $file)
    {
        $model = SimkatmawaMbkm::findOne($id);
        $file_path = $model->$file;
        $file = file_get_contents($file_path);
        $nama = basename($file_path);
        $parts = explode('-', $nama);
        $jenisData = $parts[0];
        $curdate = date('d-m-y');
        $filename = $jenisData . '-' . $model->nama_program . '-' .  $curdate;
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($file));
        header('Accept-Ranges: bytes');
        echo $file;
        exit;
    }

    /**
     * Deletes an existing SimkatmawaMbkm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionDelete($id, $jenisSimkatmawa)
    {
        if ($this->findModel($id)->delete() && SimkatmawaMahasiswa::deleteAll(['simkatmawa_mbkm_id' => $id])) {
        }
        Yii::$app->session->setFlash('success', "Data Berhasil Dihapus");
        return $this->redirect([$jenisSimkatmawa]);
    }

    /**
     * Finds the SimkatmawaMbkm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SimkatmawaMbkm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimkatmawaMbkm::findOne(['id' => $id])) !== null) {
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


    protected function insertSimkatmawa($dataPost, $jenisSimkatmawa, $isCreate = true)
    {
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        $s3config = Yii::$app->params['s3'];

        $s3new = new \Aws\S3\S3Client($s3config);
        $errors = '';

        try {

            if (Yii::$app->request->post()) {

                if (isset($dataPost['SimkatmawaMbkm']['id'])) {
                    $model = $this->findModel($dataPost['SimkatmawaMbkm']['id']);
                } else {
                    $model = new SimkatmawaMbkm;
                }

                $model->attributes = $dataPost['SimkatmawaMbkm'];
                $model->user_id = Yii::$app->user->identity->id;
                $model->jenis_simkatmawa = $jenisSimkatmawa;

                $skPenerimaanPath = UploadedFile::getInstance($model, 'sk_penerimaan_path');
                $suratTugasPath = UploadedFile::getInstance($model, 'surat_tugas_path');
                $rekomendasiPath = UploadedFile::getInstance($model, 'rekomendasi_path');
                $khsPtPath = UploadedFile::getInstance($model, 'khs_pt_path');
                $sertifikatPath = UploadedFile::getInstance($model, 'sertifikat_path');
                $laporanPath = UploadedFile::getInstance($model, 'laporan_path');
                $hasilPath = UploadedFile::getInstance($model, 'hasil_path');

                $curdate    = date('d-m-y');
                $labelPath = ucwords(str_replace('-', ' ', $jenisSimkatmawa));

                if (isset($skPenerimaanPath)) {


                    $file_name  = $model->nama_program . '-' . $curdate;
                    $s3path     = $skPenerimaanPath->tempName;
                    $s3type     = $skPenerimaanPath->type;
                    $key        = 'SimkatmawaMbkm' . '/' . $labelPath . '/' . $model->nama_program . '/' . 'sk_penerimaan-' . $file_name . '.pdf';
                    $insert = $s3new->putObject([
                        'Bucket'        => 'sikap',
                        'Key'           => $key,
                        'Body'          => 'Body',
                        'SourceFile'    => $s3path,
                        'ContenType'    => $s3type,
                    ]);
                    $plainUrl = $s3new->getObjectUrl('sikap', $key);
                    $model->sk_penerimaan_path = $plainUrl;
                }

                if (isset($suratTugasPath)) {
                    $file_name  = $model->nama_program . '-' . $curdate;
                    $s3path     = $suratTugasPath->tempName;
                    $s3type     = $suratTugasPath->type;
                    $key        = 'SimkatmawaMbkm' . '/' . $labelPath . '/' . $model->nama_program . '/' . 'surat_tugas-' . $file_name . '.pdf';
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

                if (isset($rekomendasiPath)) {
                    $file_name  = $model->nama_program . '-' . $curdate;
                    $s3path     = $rekomendasiPath->tempName;
                    $s3type     = $rekomendasiPath->type;
                    $key        = 'SimkatmawaMbkm' . '/' . $labelPath . '/' . $model->nama_program . '/' . 'rekomendasi-' . $file_name . '.pdf';
                    $insert = $s3new->putObject([
                        'Bucket'        => 'sikap',
                        'Key'           => $key,
                        'Body'          => 'Body',
                        'SourceFile'    => $s3path,
                        'ContenType'    => $s3type,
                    ]);
                    $plainUrl = $s3new->getObjectUrl('sikap', $key);
                    $model->rekomendasi_path = $plainUrl;
                }

                if (isset($khsPtPath)) {
                    $file_name  = $model->nama_program . '-' . $curdate;
                    $s3path     = $khsPtPath->tempName;
                    $s3type     = $khsPtPath->type;
                    $key        = 'SimkatmawaMbkm' . '/' . $labelPath . '/' . $model->nama_program . '/' . 'khs_pt-' . $file_name . '.pdf';
                    $insert = $s3new->putObject([
                        'Bucket'        => 'sikap',
                        'Key'           => $key,
                        'Body'          => 'Body',
                        'SourceFile'    => $s3path,
                        'ContenType'    => $s3type,
                    ]);
                    $plainUrl = $s3new->getObjectUrl('sikap', $key);
                    $model->khs_pt_path = $plainUrl;
                }

                if (isset($sertifikatPath)) {
                    $file_name  = $model->nama_program . '-' . $curdate;
                    $s3path     = $sertifikatPath->tempName;
                    $s3type     = $sertifikatPath->type;
                    $key        = 'SimkatmawaMbkm' . '/' . $labelPath . '/' . $model->nama_program . '/' . 'sertifikat-' . $file_name . '.pdf';
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

                if (isset($laporanPath)) {
                    $file_name  = $model->nama_program . '-' . $curdate;
                    $s3path     = $laporanPath->tempName;
                    $s3type     = $laporanPath->type;
                    $key        = 'SimkatmawaMbkm' . '/' . $labelPath . '/' . $model->nama_program . '/' . 'laporan-' . $file_name . '.pdf';
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

                if (isset($hasilPath)) {
                    $file_name  = $model->nama_program . '-' . $curdate;
                    $s3path     = $hasilPath->tempName;
                    $s3type     = $hasilPath->type;
                    $key        = 'SimkatmawaMbkm' . '/' . $labelPath . '/' . $model->nama_program . '/' . 'hasil-' . $file_name . '.pdf';
                    $insert = $s3new->putObject([
                        'Bucket'        => 'sikap',
                        'Key'           => $key,
                        'Body'          => 'Body',
                        'SourceFile'    => $s3path,
                        'ContenType'    => $s3type,
                    ]);
                    $plainUrl = $s3new->getObjectUrl('sikap', $key);
                    $model->hasil_path = $plainUrl;
                }

                if ($model->save()) {

                    if (!empty($dataPost['hint'][0])) {

                        foreach ($dataPost['hint'] as $mhs) {
                            $data = explode(' - ', $mhs);

                            if (strlen($mhs) > 12) {
                                
                                $mahasiswa = SimkatmawaMahasiswa::findOne(['simkatmawa_mbkm_id' => $model->id, 'nim' => $data[0]]);

                                if (isset($mahasiswa))  $this->findMahasiswa($mahasiswa->id);
                                else $mahasiswa = new SimkatmawaMahasiswa();
    
                                $mahasiswa->simkatmawa_mbkm_id = $model->id;
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
