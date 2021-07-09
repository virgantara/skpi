<?php

namespace app\controllers;

use Yii;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\helpers\MyHelper;
use yii\httpclient\Client;

use app\models\HukumanSearch;


/**
 * PenjualanController implements the CRUD actions for Penjualan model.
 */
class ApiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCountProdiEventTop(){
        $dataPost = $_POST['dataPost'];
        
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $results = [];
        $params = [
            'tahun_id' => $dataPost['tahun_id'],
            'limit' => $dataPost['limit']
        ];
        $response = $client->get('/event/prodi/top', $params,['x-access-token'=>Yii::$app->params['client_token']])->send();
        if ($response->isOk) {
            $results = $response->data['values'];
        }

        echo json_encode($results);
        exit;
    }

    public function actionCountEventByTingkat(){
        $dataPost = $_POST['dataPost'];
        
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $results = [];
        $params = [
            'periode' => $dataPost['periode']
        ];
        $response = $client->get('/event/tingkat/count', $params,['x-access-token'=>Yii::$app->params['client_token']])->send();
        if ($response->isOk) {
            $results = $response->data['values'];
        }

        echo json_encode($results);
        exit;
    }

    public function actionGetProdiByFakultas(){
        $dataPost = $_POST['dataPost'];
        $kode_fakultas = $dataPost['kode_fakultas'];
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $results = [];
        $params = [
            'kode_fakultas' => $kode_fakultas
        ];
        $response = $client->get('/f/prodi/list', $params,['x-access-token'=>Yii::$app->params['client_token']])->send();
        if ($response->isOk) {
            $results = $response->data['values'];
            $results = $results[0]['items'];


        }

        echo json_encode($results);
        exit;
    }

    public function actionAjaxGetPelanggaranJumlahTerbanyakProdi()
    {

        $kategori = $_POST['kategori'];
        $pel_nama = $_POST['pel_nama'];
        $fakultas = $_POST['fakultas'];
        $query = new \yii\db\Query();
        $rows = $query->select(['pr.singkatan as nama', 'COUNT(*) as total'])
        ->from('erp_riwayat_pelanggaran rp')
        ->innerJoin('erp_pelanggaran p', 'rp.pelanggaran_id = p.id')
        ->innerJoin('erp_kategori_pelanggaran kp', 'p.kategori_id = kp.id')
        ->innerJoin('simak_mastermahasiswa m', 'm.nim_mhs = rp.nim')
        ->innerJoin('simak_masterprogramstudi pr', 'pr.kode_prodi = m.kode_prodi')
        ->innerJoin('simak_masterfakultas f', 'pr.kode_fakultas = f.kode_fakultas')
        ->where(['kp.nama' => $kategori,'p.kode'=>$pel_nama,'f.nama_fakultas'=>$fakultas])
        ->groupBy(['pr.singkatan'])
        ->orderBy('total DESC')
        // ->limit(10)
        ->all();

        echo \yii\helpers\Json::encode($rows, JSON_NUMERIC_CHECK);
    }

    public function actionAjaxGetPelanggaranJumlahTerbanyakFakultas(){
        $kategori = $_POST['kategori'];
        $pel_nama = $_POST['pel_nama'];
        $query = new \yii\db\Query();
        $rows = $query->select(['f.nama_fakultas as nama','f.kode_fakultas', 'COUNT(*) as total'])
                ->from('erp_riwayat_pelanggaran rp')
                ->innerJoin('erp_pelanggaran p', 'rp.pelanggaran_id = p.id')
                ->innerJoin('erp_kategori_pelanggaran kp', 'p.kategori_id = kp.id')
                ->innerJoin('simak_mastermahasiswa m', 'm.nim_mhs = rp.nim')
                ->innerJoin('simak_masterfakultas f', 'f.kode_fakultas = m.kode_fakultas')
                ->where(['kp.nama' => $kategori,'p.kode'=>$pel_nama])
                ->groupBy(['f.nama_fakultas','f.kode_fakultas'])
                ->orderBy('total DESC')
                // ->limit(10)
                ->all();

        echo \yii\helpers\Json::encode($rows, JSON_NUMERIC_CHECK);
        
    }

    public function actionAjaxGetPelanggaranJumlahTerbanyak(){
        $kategori = $_POST['kategori'];
        $query = new \yii\db\Query();
        $query->select(['a.nama','a.id', 'a.kode', 'COUNT(*) as total'])
            ->from('erp_riwayat_pelanggaran b')
            ->innerJoin('erp_pelanggaran a', 'b.pelanggaran_id = a.id')
            ->innerJoin('erp_kategori_pelanggaran c', 'a.kategori_id = c.id');
            if(Yii::$app->user->identity->access_role == 'operatorCabang')
            {
                $query->innerJoin('simak_mastermahasiswa m', 'm.nim_mhs = b.nim');
                $query->where(['m.kampus'=>Yii::$app->user->identity->kampus]);    
                $query->andWhere(['c.nama' => $kategori]);
            }

            else
            {
                $query->where(['c.nama' => $kategori]);
            }
            $query->groupBy(['a.nama','a.id'])
            ->orderBy('total DESC')
            ->limit(10);
        $rows = $query->all();

     

        echo \yii\helpers\Json::encode($rows, JSON_NUMERIC_CHECK);
        
    }

    public function actionAjaxGetKapasitasAsrama() {

        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $client_token = Yii::$app->params['client_token'];
        $headers = ['x-access-token'=>$client_token];
        
        $params = [
            'kampus' => Yii::$app->user->identity->kampus
        ];
        $response = $client->get('/simpel/asrama/kapasitas', $params,$headers)->send();
        
        $results = [];
        
        if ($response->isOk) {
            $results = $response->data['values'];
            // print_r($result);exit;
            
        }
        

        echo \yii\helpers\Json::encode($results);


    }


    public function actionAjaxGetJumlahPelanggaranByKategori() {

        // $tahun = 2019;

        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $client_token = Yii::$app->params['client_token'];
        $headers = ['x-access-token'=>$client_token];
        $tahun = !empty($_POST['tahun']) ? $_POST['tahun'] : date('Y');
        $kampus = !empty($_POST['kampus']) ? $_POST['kampus'] : '';
        $results = [];
        for ($m=1; $m<=12; $m++) {
            $month = date('m', mktime(0,0,0,$m, 1, $tahun));
            $label = date('F', mktime(0,0,0,$m, 1, $tahun));
            
            $sd = date('Y-m-d',strtotime($tahun.'-'.$m.'-01'));
            $ed = date('Y-m-t',strtotime($sd));

            $response = $client->get('/simpel/rekap/pelanggaran/tahunan', [
                'sd' => $sd,
                'ed' => $ed,
                'kampus' => $kampus
            ],$headers)->send();

            
            if ($response->isOk) {
                $ringan = $response->data['values'][0];
                
                $sedang = $response->data['values'][1];
                $berat = $response->data['values'][2];
                $results['ringan'][] = [
                    'bulan' => $label,
                    'jumlah' => round(!empty($ringan) ? $ringan['total'] : 0,2)
                ];   

                $results['sedang'][] = [
                    'bulan' => $label,
                    'jumlah' => round(!empty($sedang) ? $sedang['total'] : 0,2)
                ];   

                $results['berat'][] = [
                    'bulan' => $label,
                    'jumlah' => round(!empty($berat) ? $berat['total'] : 0,2)
                ];   
            }


            
        }
        // exit;
        

        echo \yii\helpers\Json::encode($results);


    }

     public function actionAjaxCariNegara() {

        $q = $_GET['term'];
        
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $client_token = Yii::$app->params['client_token'];
        $headers = ['x-access-token'=>$client_token];
        $response = $client->get('/negara/search', ['key' => $q],$headers)->send();
        
        $out = [];

        
        if ($response->isOk) {
            $result = $response->data['values'];
            // print_r($result);exit;
            if(!empty($result))
            {
                foreach ($result as $d) {
                    $out[] = [
                        'id' => $d['id'],
                        'label'=> $d['kode'].' - '.$d['nama'],

                    ];
                }
            }

            else
            {
                $out[] = [
                    'id' => 0,
                    'label'=> 'Data negara tidak ditemukan',

                ];
            }
        }
        

        echo \yii\helpers\Json::encode($out);


    }

    public function actionAjaxCariKota() {

        $q = $_GET['term'];
        
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $client_token = Yii::$app->params['client_token'];
        $headers = ['x-access-token'=>$client_token];
        $response = $client->get('/kota/search', ['key' => $q],$headers)->send();
        
        $out = [];

        
        if ($response->isOk) {
            $result = $response->data['values'];
            // print_r($result);exit;
            if(!empty($result))
            {
                foreach ($result as $d) {
                    $out[] = [
                        'id' => $d['id'],
                        'label'=> $d['kab'].' - '.$d['prov'],

                    ];
                }
            }

            else
            {
                $out[] = [
                    'id' => 0,
                    'label'=> 'Data kota tidak ditemukan',

                ];
            }
        }
        

        echo \yii\helpers\Json::encode($out);


    }

    public function actionAjaxCariMahasiswa() {

        $q = $_GET['term'];
        
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $client_token = Yii::$app->params['client_token'];
        $headers = ['x-access-token'=>$client_token];
        $response = $client->get('/m/cari', ['key' => $q],$headers)->send();
        
        $out = [];

        
        if ($response->isOk) {
            $result = $response->data['values'];
            // print_r($result);exit;
            if(!empty($result))
            {
                foreach ($result as $d) {
                    $out[] = [
                        'nm' => $d['nama_mahasiswa'],
                        'jk' => $d['jenis_kelamin'],
                        'smt' => $d['semester'],
                        'nmp' => $d['nama_prodi'],
                        'k' => $d['nama_kampus'],
                        'id' => $d['nim_mhs'],
                        'label'=> $d['nim_mhs'].' - '.$d['nama_mahasiswa'].' - '.$d['nama_prodi'],

                    ];
                }
            }

            else
            {
                $out[] = [
                    'id' => 0,
                    'label'=> 'Data mahasiswa tidak ditemukan',

                ];
            }
        }
        

        echo \yii\helpers\Json::encode($out);


    }

    public function actionGetHukuman()
    {
        $result = [];
        // if(Yii::app()->request->isAjaxRequest)
        // {
        $q = $_GET['term'];
        $model = HukumanSearch::searchByNama($q);

        
        foreach($model as $m)
        {
            $result[] = array(
                'id' => $m->id,
                'value' => $m->nama.' - '.$m->kategori->nama,

            );
        }
        // }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; 
        \Yii::$app->response->data  =  $result;
        // echo CJSON::encode($result);
    }

}
