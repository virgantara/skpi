<?php

namespace app\controllers;

use app\helpers\MyHelper;
use app\models\SimkatmawaBelmawa;
use app\models\SimkatmawaBelmawaKategori;
use app\models\SimkatmawaBelmawaSearch;
use app\models\SimkatmawaMahasiswa;
use app\models\UserProdi;
use DateTime;
use Yii;
use yii\filters\AccessControl;
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
        $searchModel = new SimkatmawaBelmawaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
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

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $dataPost['SimkatmawaBelmawa']['id'] = $id;
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

    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete() && SimkatmawaMahasiswa::deleteAll(['simkatmawa_belmawa_id' => $id])) {
            Yii::$app->session->setFlash('success', "Data Berhasil Dihapus");
            return $this->redirect(['index']);
        } else {
            return $this->redirect(['index']);
        }
    }

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

                $attributesToExclude = ['laporan_path'];
                
                foreach ($dataPost['SimkatmawaBelmawa'] as $attribute => $value) {
                    if (!in_array($attribute, $attributesToExclude)) {
                        $model->$attribute = $value;
                    }
                }

                $model->user_id = Yii::$app->user->identity->id;

                if (!Yii::$app->user->can('admin')) {
                    $userProdi = UserProdi::findOne(['user_id' => Yii::$app->user->identity->id]);
                    $model->prodi_id = $userProdi->prodi_id ?? null;
                }

                $simkatmawaKategori = SimkatmawaBelmawaKategori::findOne($model->simkatmawa_belmawa_kategori_id);

                $laporanPath = UploadedFile::getInstance($model, 'laporan_path');

                $curdate    = date('d-m-y');
                $labelPath = ucwords(str_replace('-', ' ', $jenisSimkatmawa));

                if (isset($laporanPath)) {
                    $file_name  = str_replace('-', ' ', pathinfo($laporanPath->name, PATHINFO_FILENAME)) .  '-' . MyHelper::getRandomString(3, 3)  . '-' . $curdate;
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
                        $dataMhs = [];
                        SimkatmawaMahasiswa::deleteAll(['simkatmawa_belmawa_id' => $model->id]);

                        foreach ($dataPost['hint'] as $mhs) {
                            $data = explode(' - ', $mhs);

                            if (strlen($mhs) > 12) {


                                $dataMhs[] = [
                                    'simkatmawa_belmawa_id' => $model->id,
                                    'nim' => $data[0],
                                    'nama' => $data[1],
                                    'prodi' => $data[2],
                                    'kampus' => $data[3],
                                ];
                            }
                        }

                        $batchMhs = Yii::$app->db->createCommand()->batchInsert('{{%simkatmawa_mahasiswa}}', [
                            'simkatmawa_belmawa_id',
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
