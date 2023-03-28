<?php

namespace app\controllers;

use Yii;

use app\models\SimakJenisKegiatan;
use app\models\SimakPilihan;
use app\models\SimakMastermahasiswa;
use app\models\SimakTahunakademik;
use app\models\SimakKegiatanMahasiswa;
use app\models\SimakIndukKegiatan;
use app\models\SimakIndukKegiatanKompetensi;
use app\models\SimakKegiatanKompetensi;
use app\models\SimakKegiatanKompetensiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SimakKegiatanKompetensiController implements the CRUD actions for SimakKegiatanKompetensi model.
 */
class SimakKegiatanKompetensiController extends Controller
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

    public function actions()
    {
        return [
    
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ],
        ];
    }

    public function actionKartuKompetensi()
    {
        $model = new SimakKegiatanKompetensi;

        $listTahun = SimakTahunakademik::find()->orderBy(['tahun_id' => SORT_DESC])->all();
        
        $nim = '';
        $tahun = !empty($_GET['tahun_id']) ? $_GET['tahun_id'] : null;
        // $nim = 412020611019;//Yii::$app->user->identity->nim;
        $mhs = null;
        $listMahasiswa = [];
        
        $results = [];
        $resultsInduk = [];
        $tahun_akademik = SimakTahunakademik::find()->where(['tahun_id' => $tahun])->one();
        if (empty($tahun_akademik)) {
            $tahun_akademik = SimakTahunakademik::find()->where(['buka' => 'Y'])->one();
        }
        if (!empty($_GET['btn-cari'])) {
            
            $nim = (!empty($_GET['nim'])? $_GET['nim']: null);
            $mhs = SimakMastermahasiswa::find()->where(['nim_mhs' => $nim])->one();
            $hasil_kompetensi = \app\models\SimakKegiatanMahasiswa::getHasilKompetensi($tahun_akademik->tahun_id, $nim);

            $list_induk = \app\models\SimakIndukKegiatan::find()->cache(60 * 10)->all();
            // $list_induk = \app\models\SimakIndukKegiatan::find()->all();


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

            
        }


        return $this->render('kartu_kompetensi', [
            // 'tahun_id' => $tahun_id,
            'listTahun' => $listTahun,
            'results' => $results,
            'mhs' => $mhs,
            'nim' => $nim,
            'model' => $model,
            'resultsInduk' => $resultsInduk,
            'listMahasiswa' => $listMahasiswa,
            'tahun_akademik' => $tahun_akademik
        ]);
    }

    /**
     * Lists all SimakKegiatanKompetensi models.
     *
     * @return string
     */
    public function actionIndex($nim, $tahun_akademik, $id)
    {
        $results = \app\models\SimakKegiatanMahasiswa::getListHasilKompetensi($tahun_akademik, $nim, $id);

        
        // echo '<pre>';
        // print_r($results);
        // $nim = 412020611019;
        // $tahun_akademik = 20222;
        // $list_kompetensi = SimakPilihan::find()->where(['kode' => 'kompetensi','aktif' => 1])->orderBy(['value' => SORT_ASC])->all();
        
        // $listJenisKegiatan = SimakJenisKegiatan::find()->all();

        // $list_induk = SimakIndukKegiatan::find()->cache(60 * 10)->all();

        // foreach ($listJenisKegiatan as $jk) {
        //     if (!empty($nim)) {
        //         $query = SimakKegiatanMahasiswa::find();
        //         $query->alias('t');
        //         $query->joinWith(['kegiatan as k']);
        //         $query->where([
        //             'nim' => $nim,
        //             'tahun_akademik' => $tahun_akademik,
        //             't.id_jenis_kegiatan' => $jk->id
        //         ]);

        //         $query->orderBy(['k.nama_kegiatan' => SORT_ASC]);

        //         $list_kegiatan_mhs = $query->all();
        //         $results[$jk->id] = $list_kegiatan_mhs;

        //     }
        // }

        // exit;

        return $this->render('index', [
            // 'list_kegiatan_mhs' => $list_kegiatan_mhs,
            // 'list_kompetensi' => $list_kompetensi,
            // 'listJenisKegiatan' => $listJenisKegiatan,
            'hasil' => $results
        ]);
    }

    /**
     * Displays a single SimakKegiatanKompetensi model.
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
     * Creates a new SimakKegiatanKompetensi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SimakKegiatanKompetensi();

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

    /**
     * Updates an existing SimakKegiatanKompetensi model.
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
     * Deletes an existing SimakKegiatanKompetensi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SimakKegiatanKompetensi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SimakKegiatanKompetensi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakKegiatanKompetensi::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
