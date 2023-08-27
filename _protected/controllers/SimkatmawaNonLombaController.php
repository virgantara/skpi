<?php

namespace app\controllers;

use app\helpers\MyHelper;
use app\models\SimkatmawaKegiatan;
use app\models\SimkatmawaMahasiswa;
use app\models\SimkatmawaNonLomba;
use app\models\SimkatmawaNonLombaSearch;
use app\models\UserProdi;
use DateTime;
use Yii;
use yii\debug\panels\DumpPanel;
use yii\filters\AccessControl;
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
                'access' => [
                    'class' => AccessControl::className(),
                    'denyCallback' => function ($rule, $action) {
                        throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page');
                    },
                    'only' => ['create', 'update', 'delete'],
                    'rules' => [

                        [
                            'actions' => ['create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['operatorUnit', 'theCreator'],
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

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreate()
    {
        $model = new SimkatmawaNonLomba();

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $insert = $this->insertSimkatmawa($dataPost);

            if (isset($insert->id)) {
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['pembinaan-mental-kebangsaan']);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect(['pembinaan-mental-kebangsaan']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'form' => "studi"
        ]);
    }

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

    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete() && SimkatmawaMahasiswa::deleteAll(['simkatmawa_non_lomba_id' => $id])) {
        }
        Yii::$app->session->setFlash('success', "Data Berhasil Dihapus");
        return $this->redirect(['pembinaan-mental-kebangsaan']);
    }

    protected function findModel($id)
    {
        if (($model = SimkatmawaNonLomba::findOne(['id' => $id])) !== null) {
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

    protected function insertSimkatmawa($dataPost)
    {
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        $s3config = Yii::$app->params['s3'];

        $s3new = new \Aws\S3\S3Client($s3config);
        $errors = '';

        try {

            $dataPost   = $_POST;
            if (Yii::$app->request->post()) {

                if (isset($dataPost['SimkatmawaNonLomba']['id'])) $model = $this->findModel($dataPost['SimkatmawaNonLomba']['id']);
                else $model = new SimkatmawaNonLomba;

                $attributesToExclude = ['laporan_path', 'foto_kegiatan_path'];
                foreach ($dataPost['SimkatmawaNonLomba'] as $attribute => $value) {
                    if (!in_array($attribute, $attributesToExclude)) {
                        $model->$attribute = $value;
                    }
                }
                
                $model->user_id = Yii::$app->user->identity->id;
                $userProdi = UserProdi::findOne(['user_id' => Yii::$app->user->identity->id]);
                $model->prodi_id = $userProdi->prodi_id ?? null;

                $laporanPath = UploadedFile::getInstance($model, 'laporan_path');
                $fotoKegiatanPath = UploadedFile::getInstance($model, 'foto_kegiatan_path');

                $jenisKegiatan = SimkatmawaKegiatan::findOne($model->simkatmawa_kegiatan_id)->nama;

                $curdate    = date('d-m-y');

                if (isset($laporanPath)) {
                    $file_name  = str_replace('-', ' ', pathinfo($laporanPath->name, PATHINFO_FILENAME)) .  '-' .MyHelper::getRandomString(3, 3)  . '-' . $curdate;
                    $s3path     = $laporanPath->tempName;
                    $s3type     = $laporanPath->type;
                    $key        = 'SimkatmawaNonLomba' . '/' . $jenisKegiatan . '/' . $model->nama_kegiatan . '/' . 'laporan-' . $file_name . '.pdf';
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
                    $key        = 'SimkatmawaNonLomba' . '/' . $jenisKegiatan . '/' . $model->nama_kegiatan . '/' . 'foto_kegiatan-' . $file_name . '.pdf';
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

                if ($model->save()) {
                    
                    if (!empty($dataPost['hint'][0])) {
                        $dataMhs = [];
                        SimkatmawaMahasiswa::deleteAll(['simkatmawa_non_lomba_id' => $model->id]);

                        foreach ($dataPost['hint'] as $mhs) {
                            $data = explode(' - ', $mhs);

                            if (strlen($mhs) > 12) {


                                $dataMhs[] = [
                                    'simkatmawa_non_lomba_id' => $model->id,
                                    'nim' => $data[0],
                                    'nama' => $data[1],
                                    'prodi' => $data[2],
                                    'kampus' => $data[3],
                                ];
                            }
                        }

                        $batchMhs = Yii::$app->db->createCommand()->batchInsert('{{%simkatmawa_mahasiswa}}', [
                            'simkatmawa_non_lomba_id',
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
