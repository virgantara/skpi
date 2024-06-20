<?php

namespace app\controllers;

use Yii;
use app\models\SimakRekapKompetensi;
use app\models\SimakPilihan;
use app\models\SimakIndukKegiatanKompetensi;
use app\models\SimakMastermahasiswa;
use app\models\SimakKegiatanMahasiswa;
use app\models\SimakKegiatanMahasiswaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\httpclient\Client;
use app\helpers\MyHelper;

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
                'only' => ['create','update','delete','ajax-get-rekap-akpam','ajax-get-kompetensi','ajax-get-induk-kompetensi'],
                'rules' => [
                    [
                        'actions' => ['create','update','delete','ajax-get-rekap-akpam','ajax-get-kompetensi','ajax-get-induk-kompetensi'],
                        'allow' => true,
                        'roles' => ['akpamPusat','admin','sekretearis','fakultas'],
                    ],
                    [
                        'actions' => ['ajax-get-rekap-akpam','ajax-get-kompetensi','ajax-get-induk-kompetensi'],
                        'allow' => true,
                        'roles' => ['Mahasiswa'],
                    ],
                    [
                        'actions' => [
                            'create','update','delete','index','view','ajax-get-rekap-akpam','ajax-get-kompetensi','ajax-get-induk-kompetensi'
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

    public function actionAjaxGetRekapAkpam()
    {
        $results = [];
        $list_akpam = [];
        $params = [];
        $listJenisKegiatan = \app\models\SimakJenisKegiatan::find()->all();
        if (Yii::$app->request->isPost && !empty($_POST['dataPost'])) {
            $obj = $_POST['dataPost'];
            // $obj['tahun_akademik'] = 20211;
            // $obj['nim'] = 3920186110295;
            
            $nim = $obj['nim'];
            
            $api_baseurl = Yii::$app->params['api_baseurl'];
            $client = new Client(['baseUrl' => $api_baseurl]);
            $client_token = Yii::$app->params['client_token'];
            $headers = ['x-access-token' => $client_token];
            $params = [
                'nim' => $nim
            ];

            $response = $client->get('/report/akpam/get', $params, $headers)->send();


            if ($response->isOk) {
                $temp = $response->data['values'];
                
                foreach ($temp as $tmp) {
                    foreach ($tmp as $t) {

                        $list_akpam[$t['semester']][$t['id_jenis_kegiatan']][$t['nim']] = $t['akpam'];
                    }
                }

                
            }
        } 

        $subakpam = 0;
        $limit_semester = 8;
        $items = [];
        foreach($listJenisKegiatan as $jk){
            $sum = 0;
            for($i=1;$i<=$limit_semester;$i++)
            {
                $formated_akpam = '';
                if(!empty($list_akpam[$i][$jk->id][$nim]))
                {
                    $akpam = $list_akpam[$i][$jk->id][$nim];
                    $akpam = $akpam >= $jk->nilai_maximal ? $jk->nilai_maximal : $akpam;
                    $formated_akpam = round($akpam);
                    $sum += $akpam;
                }

                else
                {
                    $formated_akpam = '-';
                }

                // echo '<td class="text-center">'.$formated_akpam.'</td>';  

            }

            $subakpam += $sum;
            $avg = $sum / $limit_semester;
            $nilai = round($avg,2);
            $items[] = [
                'id' => $jk->id,
                'nama' => $jk->nama_jenis_kegiatan,
                'nilai' => $nilai
            ];
        }

        $pembagi = $limit_semester;
        $subakpam = $subakpam / $pembagi;

        $ipks = $subakpam / 100;
        $results['total'] = $subakpam;
        $results['ipks'] = $ipks;
        $results['items'] = $items;
        echo json_encode($results);

        die();
    }

    

    public function actionAjaxGetKompetensi()
    {

        if (Yii::$app->request->isPost && !empty($_POST['dataPost'])) {
            $obj = $_POST['dataPost'];
            // $obj['tahun_akademik'] = 20211;
            // $obj['nim'] = 3920186110295;
            
            $nim = $obj['nim'];
            
            $results = [];
            $list_kompetensi = \app\models\SimakPilihan::find()->select(['id', 'label_en','label'])->where(['kode' => 'kompetensi'])->all();

            $mhs = SimakMastermahasiswa::findOne(['nim_mhs' => $nim]);
            $tahun_awal = $mhs->tahun_masuk . '1';
            $tahun_lulus = (!empty($mhs->tgl_lulus) ? date('Y',strtotime($mhs->tgl_lulus)) : null);

            $query = \app\models\SimakTahunakademik::find();
            $query->where(['>=', 'tahun_id', $tahun_awal]);

            if(!empty($tahun_lulus))
                $query->andWhere(['<=', 'tahun_id', $tahun_lulus.'2']);

            $list_tahun = $query->orderBy(['tahun_id' => SORT_DESC])->cache(60 * 10)->all();


            $pembagi = count($list_tahun);

            $unsorted = [];
            foreach($list_kompetensi as $kompetensi){

                $total_bobot = 0;
                $induk = SimakIndukKegiatanKompetensi::findOne(['pilihan_id' => $kompetensi->id]);
                foreach($list_tahun as $tahun){


                    $query = (new \yii\db\Query())
                        ->select(['SUM(kk.bobot) as bobot', 'ik.id'])
                        ->from('simak_pilihan p')
                        ->join('JOIN', 'simak_kegiatan_kompetensi kk','kk.pilihan_id = p.id')
                        ->join('JOIN', 'simak_kegiatan k','k.id = kk.kegiatan_id')
                        ->join('JOIN', 'simak_kegiatan_mahasiswa km','km.id_kegiatan = kk.kegiatan_id')
                        ->join('JOIN', 'simak_jenis_kegiatan jk','k.id_jenis_kegiatan = jk.id')
                        ->join('JOIN', 'simak_induk_kegiatan ik','jk.induk_id = ik.id')
                        ->where([
                            'p.id' => $kompetensi->id,
                            'km.nim' => $nim,
                            'km.tahun_akademik' => $tahun->tahun_id,
                            'km.is_approved' => 1,
                        ])
                        ->groupBy(['ik.id']);

                    $bobot = $query->one();
                    if(!empty($bobot))
                        $total_bobot += $bobot['bobot'];
                }

                $avg_bobot = 0;
                if($pembagi > 0)
                    $avg_bobot = $total_bobot / $pembagi;

                
                $predikat = [];
                $label = '';
                $color = '';
                $nilai_akhir = 0;
                $normalized = 0;
                if(!empty($induk))
                {
                    $max_range = \app\models\SimakKompetensiRangeNilai::getMaxKompetensi($induk->id);
                    $nilai_kumulatif = $avg_bobot;
                    if(!empty($max_range))
                    {
                        $nilai_akhir = $nilai_kumulatif > $max_range->nilai_maksimal ? $max_range->nilai_maksimal : $nilai_kumulatif;
                        $nilai_kumulatif = $nilai_akhir;

                        $normalized = MyHelper::normalize($nilai_akhir,$max_range->nilai_minimal, $max_range->nilai_maksimal);
                    }

                    $range = \app\models\SimakKompetensiRangeNilai::getRangeNilai($nilai_kumulatif, $induk->id);


                    if(!empty($range))
                    {
                        $label = $range->label;
                        $color = $range->color;
                        
                    }
                }

                $results[] = [
                    'total' => round($nilai_akhir,2),
                    'induk' => '',
                    'induk_id' => '',
                    'komponen_indonesia' => $kompetensi->label,
                    'komponen' => $kompetensi->label_en,
                    'limit' => 5,
                    'label' => $label,
                    'color' => $color,
                    'normalized' => $normalized,
                    'nilai_akhir' => round($nilai_akhir,2)
                ];

                $unsorted[] = [
                    'normalized' => $normalized,
                    'komponen' => $kompetensi->label_en,
                    'komponen_indonesia' => $kompetensi->label,
                    'kompetensi_id' => $kompetensi->id,
                    'label' => $label,
                    
                ];
            }

            $topAndBottonSkills = MyHelper::getTopAndBottonSkills($unsorted);
            
            $sorted = $topAndBottonSkills['sorted'];
            $list_bottom_skills = $topAndBottonSkills['list_bottom_skills'];
            $list_top_skills = $topAndBottonSkills['list_top_skills'];
            $list_bottom_skills_en = $topAndBottonSkills['list_bottom_skills_en'];
            $list_top_skills_en = $topAndBottonSkills['list_top_skills_en'];
            $bottom3_evaluasi = $topAndBottonSkills['bottom3_evaluasi'];
            $top3_evaluasi = $topAndBottonSkills['top3_evaluasi'];

            
            echo json_encode([
                'items' => $results,
                'sorted' => $sorted,
                'list_bottom_skills' => '<b>'.$list_bottom_skills.'</b>',
                'list_top_skills' => '<b>'.$list_top_skills.'</b>',
                'list_bottom_skills_en' => '<b>'.$list_bottom_skills_en.'</b>',
                'list_top_skills_en' => '<b>'.$list_top_skills_en.'</b>',
                'bottom3_evaluasi' => $bottom3_evaluasi,
                'top3_evaluasi' => $top3_evaluasi,
            ]);
            
        }

        die();
    }

    public function actionAjaxGetIndukKompetensi()
    {
        if (Yii::$app->request->isPost && !empty($_POST['dataPost'])) {
            $obj = $_POST['dataPost'];
            $nim = $obj['nim'];
            

            $list_induk = \app\models\SimakIndukKegiatan::find()->cache(60 * 10)->all();

            $results = [];

           
            foreach ($list_induk as $induk) {
                $total = 0;
                $tmp = [];
                $max_kompetensi = 0;
                $akpam_total = 0;

                
                foreach ($induk->simakJenisKegiatans as $kom) {
                    // foreach($list_tahun as $tahun){
                    $akpam = \app\models\SimakRekapAkpam::find()->where([
                        // 'tahun_akademik' => $tahun->tahun_id,
                        'nim' => $nim,
                        'id_jenis_kegiatan' => $kom->id
                    ])->average('akpam');
                    // }
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
                    'akpam' => round($pembagi > 0 ? $akpam_total / $pembagi : $akpam_total,2),
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
