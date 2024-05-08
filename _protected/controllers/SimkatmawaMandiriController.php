<?php

namespace app\controllers;

use app\helpers\MyHelper;
use app\models\SimkatmawaMahasiswa;
use app\models\SimkatmawaMandiri;
use app\models\SimkatmawaMandiriSearch;
use app\models\SimkatmawaRekognisi;
use app\models\UserProdi;
use DateTime;
use Yii;
use yii\filters\AccessControl;
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
                'access' => [
                    'class' => AccessControl::className(),
                    'denyCallback' => function ($rule, $action) {
                        throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page');
                    },
                    'only' => ['create-rekognisi', 'create-kegiatan-mandiri', 'update', 'delete'],
                    'rules' => [

                        [
                            'actions' => ['create-rekognisi', 'create-kegiatan-mandiri', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['operatorUnit', 'admin'],
                        ],

                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

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

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $dataPost['SimkatmawaMandiri']['id'] = $id;
            $insert = $this->insertSimkatmawa($dataPost, $model->jenis_simkatmawa, false);

            if (isset($insert->id)) {
                Yii::$app->session->setFlash('success', "Data berhasil diupdate");
                return $this->redirect([$model->jenis_simkatmawa]);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect([$model->jenis_simkatmawa]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'form' => $model->jenis_simkatmawa
        ]);
    }

    public function actionDelete($id, $jenisSimkatmawa)
    {
        if ($this->findModel($id)->delete() && SimkatmawaMahasiswa::deleteAll(['simkatmawa_mandiri_id' => $id])) {
        }
        Yii::$app->session->setFlash('success', "Data Berhasil Dihapus");
        return $this->redirect([$jenisSimkatmawa]);
    }

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

            if (Yii::$app->request->post()) {
                
                if (!empty($dataPost['SimkatmawaMandiri']['id'])) {
                    $model = $this->findModel($dataPost['SimkatmawaMandiri']['id']);
                } else {
                    $model = new SimkatmawaMandiri;
                }
                
                $attributesToExclude = ['foto_karya_path', 'foto_penyerahan_path', 'laporan_path', 'foto_kegiatan_path', 'sertifikat_path', 'surat_tugas_path'];
                foreach ($dataPost['SimkatmawaMandiri'] as $attribute => $value) {
                    if (!in_array($attribute, $attributesToExclude)) {
                        $model->$attribute = $value;
                    }
                }

                $model->user_id = Yii::$app->user->identity->id;

                if (!Yii::$app->user->can('admin')) {
                    $userProdi = UserProdi::findOne(['user_id' => Yii::$app->user->identity->id]);
                    $model->prodi_id = $userProdi->prodi_id ?? null;
                }

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
                    $file_name  = str_replace('-', ' ', pathinfo($fotoKaryaPath->name, PATHINFO_FILENAME)) .  '-' .MyHelper::getRandomString(3, 3)  . '-' . $curdate;
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
                    $file_name  = str_replace('-', ' ', pathinfo($fotoPenyerahanPath->name, PATHINFO_FILENAME)) .  '-' .MyHelper::getRandomString(3, 3)  . '-' . $curdate;
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
                    $file_name  = str_replace('-', ' ', pathinfo($laporanPath->name, PATHINFO_FILENAME)) .  '-' .MyHelper::getRandomString(3, 3)  . '-' . $curdate;
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
                    $file_name  = str_replace('-', ' ', pathinfo($fotoKegiatanPath->name, PATHINFO_FILENAME)) .  '-' .MyHelper::getRandomString(3, 3)  . '-' . $curdate;
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
                    $file_name  = str_replace('-', ' ', pathinfo($sertifikatPath->name, PATHINFO_FILENAME)) .  '-' .MyHelper::getRandomString(3, 3)  . '-' . $curdate;
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
                    $file_name  = str_replace('-', ' ', pathinfo($suratTugasPath->name, PATHINFO_FILENAME)) .  '-' .MyHelper::getRandomString(3, 3)  . '-' . $curdate;
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
                        $dataMhs = [];
                        SimkatmawaMahasiswa::deleteAll(['simkatmawa_mandiri_id' => $model->id]);

                        foreach ($dataPost['hint'] as $mhs) {
                            $data = explode(' - ', $mhs);

                            if (strlen($mhs) > 12) {


                                $dataMhs[] = [
                                    'simkatmawa_mandiri_id' => $model->id,
                                    'nim' => $data[0],
                                    'nama' => $data[1],
                                    'prodi' => $data[2],
                                    'kampus' => $data[3],
                                ];
                            }
                        }

                        $batchMhs = Yii::$app->db->createCommand()->batchInsert('{{%simkatmawa_mahasiswa}}', [
                            'simkatmawa_mandiri_id',
                            'nim',
                            'nama',
                            'prodi',
                            'kampus',
                        ], $dataMhs);

                        $batchMhs->execute();
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