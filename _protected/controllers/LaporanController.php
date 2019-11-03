<?php

namespace app\controllers;

use Yii;
use app\models\Cart;
use app\models\PenjualanItem;
use app\models\Penjualan;
use app\models\PenjualanSearch;
use app\models\SalesFaktur;
use app\models\SalesFakturSearch;
use app\models\RequestOrder;
use app\models\RequestOrderSearch;
use app\models\Pasien;
use app\models\SalesMasterBarang;
use app\models\SalesStokGudang;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\helpers\MyHelper;
use yii\httpclient\Client;


/**
 * PenjualanController implements the CRUD actions for Penjualan model.
 */
class LaporanController extends Controller
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

    public function actionEkdDetil($tahun, $semester, $prodi, $kode){
        
        $ta = $tahun.$semester;
        return $this->render('ekd_detil', [
            'ta' => $ta,
            'kode' => $kode,
            'prodi' => $prodi
        ]);
    }

    public function actionEkd(){

        $results = [];
        $out = [];
        $api_baseurl = Yii::$app->params['api_baseurl'];
        try {
            $client = new Client(['baseUrl' => $api_baseurl]);
            $response = $client->get('/p/list', ['tahun' => date("Y")])->send();
            
            
            
            if ($response->isOk) {
                $result = $response->data['values'];
                foreach ($result as $d) {
                    $out[] = [
                        'kode' => $d['kode_prodi'],
                        'nama'=> $d['nama_prodi'],
                        'singkatan'=> $d['singkatan'],
                       
                    ];
                }
            }
        } catch (\Exception $e) {
            $out = [
                'kode' => 500,
                'nama' =>  'Data Tidak Ditemukan'
            ];
        }

        $out = \yii\helpers\ArrayHelper::map($out,'kode','nama');

        if(!empty($_POST['tahun']) && !empty($_POST['semester']) && !empty($_POST['prodi']))
        {
            $tahun = $_POST['tahun'];
            $semester = $_POST['semester'];
            $prodi = $_POST['prodi'];
            $ta = $tahun.$semester;
            
            // $list = Pasien::find()->addFilterWhere(['like',])
            $api_baseurl = Yii::$app->params['api_baseurl'];
            $client = new Client(['baseUrl' => $api_baseurl]);
            $response = $client->get('/d/ekd', ['tahun' => $ta,'prodi'=>$prodi,'dosen'=>''])->send();
            
            // $out = [];
            if ($response->isOk) {

                $result = $response->data['values'];
                $results['pedagogik'] = $result[0];
                $results['profesional'] = $result[1];
                $results['kepribadian'] = $result[2];
                $results['sosial'] = $result[3];    
              
            }

            
        }

        return $this->render('ekd', [
            'results' => $results,
            'model' => $model,
            'listProdi' => $out
        ]);
    }

    
    public function actionEdTahunan(){

        $results = [];
        if(!empty($_POST['tanggal_awal']) && !empty($_POST['tanggal_akhir']) && !empty($_POST['gudang_id']))
        {


            $tanggal_awal = $_POST['tanggal_awal'];
            $tanggal_akhir = $_POST['tanggal_akhir'];
            $a = $tanggal_awal;
            $b = $tanggal_akhir;

            $i = date("Ym", strtotime($a));
            $list_bulan = [];
            while($i <= date("Ym", strtotime($b))){
                $list_bulan[] = $i;
                if(substr($i, 4, 2) == "12")
                    $i = (date("Y", strtotime($i."01")) + 1)."01";
                else
                    $i++;
            }


            foreach($list_bulan as $bln)
            {
                $y = substr($bln, 0,4);
                $mm = substr($bln,4,2);
                $ds = $y.'-'.$mm.'-01';
                $de = $y.'-'.$mm.'-31';
                $query = SalesStokGudang::find();
                $query->joinWith(['barang as barang']);
                $query->where(['id_gudang'=>$_POST['gudang_id']]);
                $query->andWhere(['barang.is_hapus'=>0]);
                // $query->andWhere(['id_barang'=>$obat->id_barang]);
                $query->andWhere(['between','exp_date',$ds,$de]);
                $query->orderBy(['exp_date'=>SORT_ASC]);
                $list = $query->all();
                
                $total = 0;
                foreach($list as $q => $m)
                {
                    
                    if($m->jumlah > 0)
                    {
                        $subtotal = $m->jumlah * $m->barang->harga_beli;
                        $total += $subtotal;
                        $results[] = [
                            'bulan' => date('M',strtotime($m->exp_date)),
                            'tahun' => $y, 
                            'stok_id' => $m->id_stok,
                            'kode' => $m->barang->kode_barang,
                            'nama' => $m->barang->nama_barang,
                            'satuan' => $obat->id_satuan,
                            'ed' => $m->exp_date,
                            'jumlah' => $m->jumlah,
                            'hb' => \app\helpers\MyHelper::formatRupiah($m->barang->harga_beli,2),
                            'hj' => \app\helpers\MyHelper::formatRupiah($m->barang->harga_jual,2),
                            'subtotal' => \app\helpers\MyHelper::formatRupiah($subtotal,2),
                        ];
                    }
                    
                }
            }

            $results['total'] = $total;

        }

        return $this->render('ed_tahunan', [
            'list' => $results,
            'model' => $model,

        ]);
    }

    

    /**
     * Lists all Penjualan models.
     * @return mixed
     */
    public function actionPenjualan()
    {
        $searchModel = new PenjualanSearch();
        $dataProvider = $searchModel->searchTanggal(Yii::$app->request->queryParams);

        $results = [];



        foreach($dataProvider->getModels() as $row)
        {
            
            foreach($row->penjualanItems as $item)
            {
                $results[] = $item;
            }

            
        }

        if(!empty($_GET['search']))
        {
            $model = new Penjualan;
            return $this->render('penjualan', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                'results' => $results
            ]); 
        }   

        else if(!empty($_GET['export']))
        {
             
            $query = Penjualan::find();

            $tanggal_awal = date('Y-m-d',strtotime($_GET['Penjualan']['tanggal_awal']));
            $tanggal_akhir = date('Y-m-d',strtotime($_GET['Penjualan']['tanggal_akhir']));
                
            $query->where(['departemen_id'=>Yii::$app->user->identity->departemen]);
            $query->andFilterWhere(['between', 'tanggal', $tanggal_awal, $tanggal_akhir]);
            $query->orderBy(['tanggal'=>SORT_ASC]);
            $hasil = $query->all();        


            foreach($hasil as $row)
            {
                
                foreach($row->penjualanItems as $item)
                {
                    $results[] = $item;
                }

                
            }
            
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = new \PHPExcel();

            //prepare the records to be added on the excel file in an array
           
            // Set document properties
            // $objPHPExcel->getProperties()->setCreator("Me")->setLastModifiedBy("Me")->setTitle("My Excel Sheet")->setSubject("My Excel Sheet")->setDescription("Excel Sheet")->setKeywords("Excel Sheet")->setCategory("Me");

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);

            // Add column headers
            $objPHPExcel->getActiveSheet()
                        ->setCellValue('A1', 'No')
                        ->setCellValue('B1', 'Tgl')
                        ->setCellValue('C1', 'Kode')
                        ->setCellValue('D1', 'Nama')
                        ->setCellValue('E1', 'Qty')
                        ->setCellValue('F1', 'HB')
                        ->setCellValue('G1', 'HJ')
                        ->setCellValue('H1', 'Laba');

            //Put each record in a new cell

            $i= 0;
            $ii = 0;

            $total = 0;
            $total_laba = 0;
            foreach($results as $row)
            {
                  $laba = ($row->stok->barang->harga_jual - $row->stok->barang->harga_beli) * $row->qty;
                $total += $laba;
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, date('d/m/Y',strtotime($row->penjualan->tanggal)));
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $row->stok->barang->kode_barang);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$ii, $row->stok->barang->nama_barang);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$ii, $row->qty);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$ii, $row->stok->barang->harga_beli);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$ii, $row->stok->barang->harga_jual);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$ii, $laba);
                // $objPHPExcel->getActiveSheet()->setCellValue('H'.$ii, $row->subtotal);
                $i++;
                $ii = $i+2;
                

                
            }       

            // Set worksheet title
            $objPHPExcel->getActiveSheet()->setTitle('Laporan Penjualan');
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="laporan_penjualan.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $objWriter->save('php://output');
            exit;
        }

        else{
             $model = new Penjualan;
            return $this->render('penjualan', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                'results' => $results
            ]); 
        }

        // print_r($results);exit;

        
    }

    /**
     * Displays a single Penjualan model.
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
     * Creates a new Penjualan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Penjualan();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Penjualan model.
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
     * Deletes an existing Penjualan model.
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
     * Finds the Penjualan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Penjualan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Penjualan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
