<?php

namespace app\controllers;
use Yii;

use app\models\SimakKegiatanHarianKategori;
use app\models\SimakKegiatanHarianMahasiswa;
use app\models\SimakTahunakademik;
use app\models\SimakMastermahasiswa;
use app\models\SimakKegiatanHarian;
use app\models\SimakMasterprogramstudi;
use app\models\SimakKegiatanHarianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SimakKegiatanHarianController implements the CRUD actions for SimakKegiatanHarian model.
 */
class SimakKegiatanHarianController extends Controller
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
                    'only' => ['create','update','index','view','delete','rekap'],
                    'rules' => [
                        
                        [
                            'actions' => [
                                'index','view','rekap'
                            ],
                            'allow' => true,
                            'roles' => ['operatorCabang','event'],
                        ],
                        [
                            'actions' => [
                                'index','view','update','delete','create',
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
            ]
        );
    }

    public function actionAjaxListKegiatanHarian()
    {
        $dataPost = $_POST['dataPost'];
        $query = SimakKegiatanHarian::find();
        // $query->select(['kode']);
        $query->where(['kategori' => $dataPost]);
        $list = $query->all();
        $results = [];
        foreach($list as $item){
            $results[] = [
                'kode' => $item->kode,
                'nama' => $item->kegiatan->sub_kegiatan
            ];
        }

        
        echo json_encode($results);
        exit;

    }

    public function actionAjaxPerkembangan()
    {   

        setlocale(LC_TIME, 'id_ID.utf8');
        $query = SimakKegiatanHarian::find();
        $query->alias('t');
        $query->joinWith(['kegiatan as keg']);
        $query->andWhere(['t.kategori' => 'SHOLAT']);
        $query->orderBy(['keg.updated_at' => SORT_ASC]);
        $list_sholat = $query->all();

        $query = new \yii\db\Query();
        $query->select(['DATE(created_at) as tgl'])
        ->from('simak_kegiatan_harian_mahasiswa')
        ->where('created_at <= (SELECT created_at FROM simak_kegiatan_harian_mahasiswa ORDER BY created_at DESC LIMIT 1)')
        ->groupBy(['DATE(created_at)'])
        ->orderBy(['tgl' => SORT_ASC]);
        $listJadwal = $query->all();

        foreach($listJadwal as $t)
        {
            $hariIni = new \DateTime(date('Y-m-d',strtotime($t['tgl'])));
            $today = strftime('%A, %d %B', $hariIni->getTimestamp());
            $list_tanggal[] = $today;//date('Y-m-d',strtotime($t['tgl']));
        }

        $results['tanggal'] = $list_tanggal;
        foreach($list_sholat as $s)
        {

            $tmp = [];
            
            foreach($listJadwal as $t)
            {
                $sd = $t['tgl'].' 00:00:00';
                $ed = $t['tgl'].' 23:59:59';
                
                $query = new \yii\db\Query();
                $query->select(['DATE(km.created_at) as tgl','k.sub_kegiatan', 'COUNT(*) as total'])
                ->from('simak_kegiatan_harian_mahasiswa km')
                ->innerJoin('simak_kegiatan_harian h', 'h.kode = km.kode_kegiatan')
                ->innerJoin('simak_kegiatan k', 'k.id = h.kegiatan_id')
                ->where(['h.kode'=> 'SHOLAT', 'h.kode' => $s->kode])
                ->andWhere(['BETWEEN','km.created_at',$sd, $ed])
                ->groupBy(['date(km.created_at)','k.sub_kegiatan'])
                ->orderBy(['tgl'=>SORT_ASC]);
                $temps = $query->all();
                $total = 0;
                foreach($temps as $t)
                {
                    $c = (int)$t['total'] == 0 || empty($t['total']) ? 0 : (int)$t['total'];
                    $total += $c;
                }

                $tmp[] = $total;
            }
            
            

            $results['items'][] = [
                'kategori' => $s->kegiatan->sub_kegiatan,
                'data' => $tmp
            ];
        }


        echo json_encode($results);
        exit;

    }

    public function actionRekapBulanan()
    {

        $results = [];

        $list_kategori = SimakKegiatanHarianKategori::find()->all();
        $list_sholat = [];
        $list_prodi = [];
        $sd = date('Y-m-16 00:00:00');
        $ed = date('Y-m-d 23:59:59');
        if(!empty($_GET['btn-search']))
        {
            
            if(!empty($_GET['bulan']))
            {
                $bulan = $_GET['bulan'];
                $sd = date('Y-'.$bulan.'-16 00:00:00');
                $ed = date('Y-'.$bulan.'-d 23:59:59');
            }
            
            $interval = \app\helpers\MyHelper::hitungSelisihHari($sd,$ed);
            $jumlah_hari = $interval->d + 1;
            // print_r($jumlah_hari);exit;
            $query = new \yii\db\Query();
            $tmp = $query->select(['p.nama_prodi','p.kode_prodi', 'COUNT(*) as total'])
            ->from('simak_mastermahasiswa mas')
            ->innerJoin('simak_masterprogramstudi p', 'p.kode_prodi = mas.kode_prodi')
            ->where(['mas.status_aktivitas' => 'A','mas.kampus' => $_GET['kampus']]) # siman
            ->groupBy(['p.nama_prodi','p.kode_prodi'])
            ->orderBy(['p.kode_fakultas'=>SORT_ASC, 'p.nama_prodi'=>SORT_ASC]);

            $list_prodi = $tmp->all();

            // $query = SimakKegiatanHarian::find();
            // $query->alias('t');
            // $query->joinWith(['kegiatan as keg']);
            // $query->andWhere(['t.kategori' => $_GET['jenis_kegiatan']]);
            // $query->orderBy(['keg.updated_at' => SORT_ASC]);
            // $list_sholat = $query->all();
                

            
            foreach($list_prodi as $prodi)
            {
                // foreach($list_sholat as $keg)
                // {

                    $query = new \yii\db\Query();
                    $query->select(['count(*) as total', 'date(km.created_at) as hari', 'p.nama_prodi'])
                    ->from('simak_kegiatan_harian_kategori kk')
                    ->innerJoin('simak_kegiatan_harian kh', 'kh.kategori = kk.kode')
                    ->innerJoin('simak_kegiatan_harian_mahasiswa km', 'km.kode_kegiatan = kh.kode')
                    ->innerJoin('simak_mastermahasiswa m', 'm.nim_mhs = km.nim')
                    ->innerJoin('simak_masterprogramstudi p', 'p.kode_prodi = m.kode_prodi')
                    ->innerJoin('simak_kegiatan keg', 'keg.id = kh.kegiatan_id')
                    ->where([
                        'kk.kode'=> $_GET['jenis_kegiatan'],
                        'p.kode_prodi' => $prodi['kode_prodi'],
                        // 'kh.kode'=>$keg->kode
                    ])
                    ->andWhere(['m.kampus' => $_GET['kampus']])
                    ->andWhere(['BETWEEN','km.created_at',$sd, $ed])
                    ->groupBy(['p.nama_prodi','date(km.created_at)'])
                    ->orderBy(['hari'=>SORT_ASC,'p.nama_prodi'=>SORT_ASC]);
                    $temps = $query->all();
                    
                    $sum = 0;
                    $jml_mhs = $prodi['total'];
                    $divider = $jml_mhs * $jumlah_hari;
                    foreach($temps as $tmp)
                    {
                        $sum += $tmp['total'];
                    }
                    
                    $persentase = $sum / $divider * 100;
              
                    $results[$prodi['kode_prodi']] = round($persentase,2);
                // }
            }

        }

        return $this->render('rekap_bulanan',[
            'results' => $results,
            'list_kategori' => $list_kategori,
            'list_prodi' => $list_prodi,
            'list_sholat' => $list_sholat,
            'sd' => $sd,
            'ed' => $ed
        ]);
    }

    public function actionRekap()
    {

        $results = [];

        $list_kategori = SimakKegiatanHarianKategori::find()->all();
        $list_prodi = [];
        if(!empty($_GET['btn-search']))
        {
            $kat = $_GET['jenis_kegiatan'];
            $kampus = $_GET['kampus'];
            $kegiatan = $_GET['kegiatan'];

            $sd = date('Y-m-d 00:00:00');
            $ed = date('Y-m-d 23:59:59');
            if(!empty($_GET['tanggal']))
            {
                $tgl = explode(" hingga ",$_GET['tanggal']);
                $sd = $tgl[0].' 00:00:00';
                $ed = $tgl[1].' 23:59:59';    
            }
            
            $list = SimakMasterprogramstudi::find()->orderBy(['kode_fakultas'=>SORT_ASC,'nama_prodi'=>SORT_ASC])->all();

            foreach($list as $p)
            {
                $m = SimakMastermahasiswa::find()->where([
                    'kode_prodi' => $p->kode_prodi,
                    'status_aktivitas' => 'A',
                    'kampus' => $kampus
                ])->count();

                $list_prodi[$p->kode_prodi] = $m;
            }

            

            $query = new \yii\db\Query();
            $query->select(['COUNT(*) as total','kk.nama_kegiatan','p.nama_prodi','kk.sub_kegiatan','p.kode_prodi','DATE(m.created_at) as tgl'])
            ->from('simak_kegiatan_harian_mahasiswa m')
            ->innerJoin('simak_kegiatan_harian h', 'm.kode_kegiatan = h.kode')
            ->innerJoin('simak_mastermahasiswa mas', 'mas.nim_mhs = m.nim')
            ->innerJoin('simak_masterprogramstudi p', 'p.kode_prodi = mas.kode_prodi')
            ->innerJoin('simak_kegiatan_harian_kategori k', 'k.kode = h.kategori')
            ->innerJoin('simak_kegiatan kk', 'kk.id = h.kegiatan_id')
            ->where(['k.kode' => $kat,'mas.kampus' => $kampus]);
            
            if(!empty($kegiatan)){
                $query->andWhere(['h.kode'=>$kegiatan]);
            }

            $query->andWhere(['BETWEEN','m.created_at',$sd, $ed])
            ->groupBy(['kk.nama_kegiatan','kk.sub_kegiatan','p.nama_prodi','p.kode_prodi','DATE(m.created_at)'])
            ->orderBy(['tgl' => SORT_ASC,'total' => SORT_DESC]);
          
            $results = $query->all();
        }

        return $this->render('rekap',[
            'results' => $results,
            'list_kategori' => $list_kategori,
            'list_prodi' => $list_prodi
        ]);
    }


    /**
     * Lists all SimakKegiatanHarian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SimakKegiatanHarianSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $listTahun = SimakTahunakademik::find()->select(['tahun_id','nama_tahun'])->orderBy(['tahun_id' => SORT_DESC])->limit(14)->all();
        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $id = Yii::$app->request->post('editableKey');
            $model = SimakKegiatanHarian::findOne($id);

            // store a default json response as desired by editable
            $out = json_encode(['output'=>'', 'message'=>'']);

            
            $posted = current($_POST['SimakKegiatanHarian']);
            $post = ['SimakKegiatanHarian' => $posted];

            // load model like any single model validation
            if ($model->load($post)) {
            // can save model or do something before saving model
                if($model->save())
                {
                    $out = json_encode(['output'=>'', 'message'=>'']);
                }

                else
                {
                    $error = \app\helpers\MyHelper::logError($model);
                    $out = json_encode(['output'=>'', 'message'=>'Oops, '.$error]);   
                }

                
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'listTahun' => $listTahun
        ]);
    }

    /**
     * Displays a single SimakKegiatanHarian model.
     * @param string $id
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
     * Creates a new SimakKegiatanHarian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $listTahun = SimakTahunakademik::find()->select(['tahun_id','nama_tahun'])->orderBy(['tahun_id' => SORT_DESC])->limit(14)->all();
        $model = new SimakKegiatanHarian();
        $model->id = \app\helpers\MyHelper::gen_uuid();
        $model->kode = 'HR'.date('YmdHis').rand(0, 100);

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'listTahun' => $listTahun
        ]);
    }

    /**
     * Updates an existing SimakKegiatanHarian model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $listTahun = SimakTahunakademik::find()->select(['tahun_id','nama_tahun'])->orderBy(['tahun_id' => SORT_DESC])->limit(14)->all();
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'listTahun'=>$listTahun
        ]);
    }

    /**
     * Deletes an existing SimakKegiatanHarian model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SimakKegiatanHarian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SimakKegiatanHarian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakKegiatanHarian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
