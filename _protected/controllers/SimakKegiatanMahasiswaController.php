<?php

namespace app\controllers;

use Yii;
use app\models\SimakMastermahasiswa;
use app\models\SimakKegiatanMahasiswa;
use app\models\SimakKegiatanMahasiswaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SimakKegiatanMahasiswaController implements the CRUD actions for SimakKegiatanMahasiswa model.
 */
class SimakKegiatanMahasiswaController extends Controller
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
                'only' => ['create','update','delete'],
                'rules' => [
                    [
                        'actions' => ['create','update','delete'],
                        'allow' => true,
                        'roles' => ['akpamPusat','admin'],
                    ],
                    [
                        'actions' => [
                            'create','update','delete','index','view'
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

    public function actionAjaxGetKompetensi()
    {

        if (Yii::$app->request->isPost && !empty($_POST['dataPost'])) {
            $obj = $_POST['dataPost'];
            // $obj['tahun_akademik'] = 20211;
            // $obj['nim'] = 3920186110295;
            
            $nim = $obj['nim'];
            

            $list_kompetensi = \app\models\SimakPilihan::find()->select(['id', 'label_en'])->where(['kode' => 'kompetensi'])->cache(60 * 5)->all();

            $mhs = SimakMastermahasiswa::findOne(['nim_mhs' => $nim]);
            $tahun_awal = $mhs->tahun_masuk . '1';
            $tahun_lulus = (!empty($mhs->tgl_lulus) ? date('Y',strtotime($mhs->tgl_lulus)) : null);

            $query = \app\models\SimakTahunakademik::find();
            $query->where(['>=', 'tahun_id', $tahun_awal]);

            if(!empty($tahun_lulus))
                $query->andWhere(['<=', 'tahun_id', $tahun_lulus.'2']);

            $list_tahun = $query->orderBy(['tahun_id' => SORT_DESC])->cache(60 * 10)->all();

            $list_induk = \app\models\SimakIndukKegiatan::find()->cache(60 * 10)->all();

            $all_results = [];
            foreach($list_tahun as $tahun){

                $results = [];
                $hasil_kompetensi = \app\models\SimakKegiatanMahasiswa::getHasilKompetensi($list_kompetensi, $obj['tahun_akademik'], $nim);

                foreach ($list_induk as $induk) {
                    $total = 0;
                    $tmp = [];
                    foreach ($induk->simakIndukKegiatanKompetensis as $kom) {

                        if (!empty($hasil_kompetensi[$kom->pilihan_id])) {
                            $h = $hasil_kompetensi[$kom->pilihan_id];
                            if (!empty($h)) {
                                $total += $h['nilai_akhir'];
                                $tmp[$kom->pilihan_id] = $h;
                            }
                        }
                    }

                    $max_kompetensi = $induk->maxKompetensi != 0 ? $induk->maxKompetensi : 1;
                    $total = round($total / $max_kompetensi * 100, 2);
                    $range = $induk->getRangeNilai($total);
                    $label = !empty($range) ? $range->label : '';
                    $color = !empty($range) ? $range->color : '';
                    $results[$induk->id] = [
                        'total' => $total,
                        'induk' => $induk->nama,
                        'induk_id' => $induk->id,
                        'komponen' => $tmp,
                        'limit' => $induk->maxKompetensi,
                        'label' => $label,
                        'color' => $color
                    ];
                }

                $all_results[$tahun->tahun_id] = $results;
            }

            echo '<pre>';
            print_r($all_results);
            exit;
            // header('Content-Type: application/json');
            echo json_encode($results);
            // echo '</pre>';
        }

        die();
    }

    public function actionAjaxGetIndukKompetensi()
    {
        if (Yii::$app->request->isPost && !empty($_POST['dataPost'])) {
            $obj = $_POST['dataPost'];
            if (Yii::$app->user->identity->access_role == 'Mahasiswa') {
                $nim = Yii::$app->user->identity->nim;
            } else {
                $nim = $obj['nim'];
            }

            $list_induk = \app\models\SimakIndukKegiatan::find()->cache(60 * 10)->all();
            // $list_induk = \app\models\SimakIndukKegiatan::find()->all();

            $results = [];
            foreach ($list_induk as $induk) {
                $total = 0;
                $tmp = [];
                $max_kompetensi = 0;
                $akpam_total = 0;


                foreach ($induk->simakJenisKegiatans as $kom) {

                    $akpam = \app\models\SimakRekapAkpam::find()->where([
                        'tahun_akademik' => $obj['tahun_akademik'],
                        'nim' => $nim,
                        'id_jenis_kegiatan' => $kom->id
                    ])->sum('akpam');
                    $akpam_total += $akpam;
                    $akpam = $akpam >= $kom->nilai_maximal ? $kom->nilai_maximal : $akpam;
                    $max_kompetensi += $kom->nilai_maximal;
                    $total += $akpam;
                }

                $pembagi = count($induk->simakIndukKegiatanKompetensis);

                $persentase = round($total / $max_kompetensi * 100, 2);
                $range = $induk->getRangeNilai($persentase);
                $label = !empty($range) ? $range->label : '';
                $color = !empty($range) ? $range->color : '';
                $results[$induk->id] = [
                    'persentase' => $persentase,
                    'akpam' => ($pembagi > 0 ? $akpam_total / $pembagi : $akpam_total),
                    'induk' => $induk->nama,
                    'induk_id' => $induk->id,
                    'label' => $label,
                    'color' => $color
                ];
            }
            echo json_encode($results);
        }

        die();
    }

    /**
     * Lists all SimakKegiatanMahasiswa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SimakKegiatanMahasiswaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimakKegiatanMahasiswa model.
     * @param int $id ID
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
     * Creates a new SimakKegiatanMahasiswa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SimakKegiatanMahasiswa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SimakKegiatanMahasiswa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SimakKegiatanMahasiswa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SimakKegiatanMahasiswa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SimakKegiatanMahasiswa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakKegiatanMahasiswa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
