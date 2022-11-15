<?php

namespace app\controllers;

use Yii;
use app\models\SimakTahunakademik;
use app\models\SimakKegiatanMahasiswa;
use app\models\Organisasi;
use app\models\OrganisasiMahasiswa;
use app\models\OrganisasiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * OrganisasiController implements the CRUD actions for Organisasi model.
 */
class OrganisasiController extends Controller
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
                'only' => ['update','index','create','delete','sync','ajax-sync'],
                'rules' => [
                    [
                        'actions' => [
                            'update','delete','create','index','ajax-sync'
                        ],
                        'allow' => true,
                        'roles' => ['theCreator','admin','operatorCabang','akpam', 'operatorUnit'],
                    ],
                    [
                        'actions' => [
                            'sync','ajax-sync'
                        ],
                        'allow' => true,
                        'roles' => ['theCreator','admin'],
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

    public function actionAjaxSync()
    {
            
        $results = [];
        $errors = '';
        $counter_added = 0;
        $counter_updated = 0;
        if(Yii::$app->request->isPost)
        {   
            if(!empty($_POST['dataPost']))
            {
                $dataPost = $_POST['dataPost'];
                $connection = \Yii::$app->db;
                $transaction = $connection->beginTransaction();
                try 
                {

                    foreach($dataPost['organisasi_id'] as $oid)
                    {
                        $model = OrganisasiMahasiswa::findOne($oid);

                        if(!empty($model))    
                        {
                            $query = \app\models\OrganisasiAnggota::find();
                            $query->alias('t');
                            $query->joinWith(['organisasi as org','nim0 as mhs']);

                            $query->andWhere([
                                't.organisasi_id' => $model->id,

                                'org.tahun_akademik' => $model->tahun_akademik,
                                'mhs.tahun_masuk' => $dataPost['tahun_masuk']
                            ]);

                            $anggotas = $query->all();
                            foreach($anggotas as $anggota)
                            {
                                if(empty($anggota->jabatan)) continue;

                                if(empty($anggota->nim0)) continue;

                                $event_id = 'ORG'.$model->id.$anggota->id;
                                $keg = SimakKegiatanMahasiswa::find()->where([
                                    'nim' => $anggota->nim,
                                    'tahun_akademik' => $model->tahun_akademik,
                                    'nama_kegiatan_mahasiswa' => $event_id
                                ])->one();

                                if(empty($keg))
                                {
                                    $keg = new SimakKegiatanMahasiswa;
                                    $keg->nim =  $anggota->nim;
                                    $keg->nama_kegiatan_mahasiswa = $event_id;
                                    $keg->tahun_akademik = (string)$model->tahun_akademik;
                                    $keg->id_kegiatan = $anggota->jabatan_id;
                                    $keg->id_jenis_kegiatan = !empty($anggota->jabatan) ? $anggota->jabatan->id_jenis_kegiatan : 'Jenis Kegiatan tidak ada';
                                    $keg->nilai = !empty($anggota->jabatan) ? $anggota->jabatan->nilai : 'Jabatan belum diisi';
                                    $keg->semester = (string)$anggota->nim0->semester;
                                    $keg->waktu = date('Y-m-d');
                                    $keg->instansi = !empty($model->organisasi) ? $model->organisasi->nama : 'Nama organisasi kosong';
                                    $keg->tema = !empty($model->organisasi) ? $model->organisasi->nama.' Tahun '.$model->tahun_akademik : 'Tema juga kosong';
                                    $keg->is_approved = 1;
                                    if($keg->save())
                                    {
                                        $counter_added++;
                                    }

                                    else
                                    {
                                        $errors .= \app\helpers\MyHelper::logError($keg);
                                        throw new \Exception;
                                    }
                                }

                                else
                                {
                                    $keg->nilai = $anggota->jabatan->nilai;
                                    if($keg->save(false,['nilai']))
                                    {
                                        $counter_updated++;
                                        
                                    }
                                }
                            }   
                        }
                    }

                    $results = [
                        'code' => 200,
                        'message' => 'Student AKPAM '.$counter_added.' added and '.$counter_updated.' updated'
                    ];
                    $transaction->commit();
                }

                catch (\Exception $e) 
                {
                    $transaction->rollBack();
                    $errors .= $e->getMessage();
                    $results = [
                        'code' => 500,
                        'message' => $errors
                    ];
                } 
                catch (\Throwable $e) {
                    $transaction->rollBack();
                    $errors .= $e->getMessage();
                    $results = [
                        'code' => 500,
                        'message' => $errors
                    ];
                }
            }
        }
        
        echo json_encode($results);
        die();
    }   

    public function actionSync()
    {
        $model = new OrganisasiMahasiswa;

        $tahun_aktif = null;
        if(!empty($_GET['tahun_akademik']))
            $tahun_aktif = SimakTahunakademik::find()->where(['tahun_id' => $_GET['tahun_akademik']])->one();
        else
            $tahun_aktif = SimakTahunakademik::getTahunAktif();


        $kampus = null;
        $list = [];
        if(!empty($_GET['kampus']) && !empty($_GET['tahun_masuk']))
        {
            $kampus = $_GET['kampus'];
            $query = OrganisasiMahasiswa::find();
            $query->alias('t');
            $query->joinWith(['organisasiAnggotas as oa','organisasiAnggotas.nim0 as mhs']);

            $query->andWhere([
                't.tahun_akademik'=>$tahun_aktif->tahun_id,
                't.kampus' => $kampus,
                'mhs.tahun_masuk' => $_GET['tahun_masuk']
            ]);

            $list = $query->all();    
        }
        

        return $this->render('sync', [
            'model' => $model,
            'list' => $list,
            'tahun_aktif' => $tahun_aktif
        ]);
    }

    /**
     * Lists all Organisasi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrganisasiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Organisasi model.
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

    /**
     * Creates a new Organisasi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Organisasi();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Organisasi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Organisasi model.
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
     * Finds the Organisasi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Organisasi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Organisasi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
