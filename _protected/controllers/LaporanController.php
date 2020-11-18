<?php

namespace app\controllers;

use Yii;
use app\models\IzinMahasiswa;
use app\models\RiwayatPelanggaran;
use app\models\RiwayatPelanggaranSearch;
use app\models\SimakMastermahasiswa;
use app\models\SimakMasterfakultas;

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

    public function actionRekapPerizinan()
    {
        
        $model = new IzinMahasiswa;
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $list_prodi = [];
        $response = $client->get('/f/prodi/list', [],['x-access-token'=>Yii::$app->params['client_token']])->send();
        if ($response->isOk) {
            $list_prodi = $response->data['values'];
            // print_r($result);exit;
            

        }

        $results = [];
        $resultsBelumPulang = [];
        $resultsSemua = [];
        
        if(!empty($_POST['btn-search'])) 
        {
            if(!empty($_POST['IzinMahasiswa']['tanggal_awal']) && !empty($_POST['IzinMahasiswa']['tanggal_akhir']))
            {
                $tanggal_awal = \app\helpers\MyHelper::dmYtoYmd($_POST['IzinMahasiswa']['tanggal_awal'],true);
                $tanggal_akhir = \app\helpers\MyHelper::dmYtoYmd($_POST['IzinMahasiswa']['tanggal_akhir'],true);
                // $prodi = $_POST['prodi'];
                foreach($list_prodi as $q=> $item)
                {

                    for($smt = 1;$smt <=9; $smt++)
                    {
                        // total jml mhs
                        $p = $item['items'][0]['kode_prodi'];
                        $params = [
                            'prodi' => $p,
                            'semua' => 'semua',
                            'semester' => $smt
                        ];

                        $hsl = $client->get('/m/izin/count', $params,['x-access-token'=>Yii::$app->params['client_token']])->send();
                        if ($hsl->isOk) {
                            $total = $hsl->data['values'];
                            // print_r($result);exit;
                            $resultsSemua[$item['kode_fakultas']][$p][$smt] = $total;                

                        }

                        for($j=1;$j<count($item['items']);$j++)
                        {
                            $p = $item['items'][$j]['kode_prodi'];

                            $params = [
                                'prodi' => $p,
                                'semua' => 'semua',
                                'semester' => $smt
                            ];

                            $hsl = $client->get('/m/izin/count', $params,['x-access-token'=>Yii::$app->params['client_token']])->send();
                            if ($hsl->isOk) {
                                $total = $hsl->data['values'];
                                // print_r($result);exit;
                                $resultsSemua[$item['kode_fakultas']][$p][$smt] = $total; 
                            }
                        }

                        // total izin
                        $p = $item['items'][0]['kode_prodi'];
                        $params = [
                            'prodi' => $p,
                            'sd' => $tanggal_awal,
                            'ed' => $tanggal_akhir,
                            'semester' => $smt
                        ];

                        $hsl = $client->get('/m/izin/count', $params,['x-access-token'=>Yii::$app->params['client_token']])->send();
                        if ($hsl->isOk) {
                            $total = $hsl->data['values'];
                            // print_r($result);exit;
                            $results[$item['kode_fakultas']][$p][$smt] = $total;                

                        }

                        for($j=1;$j<count($item['items']);$j++)
                        {
                            $p = $item['items'][$j]['kode_prodi'];

                            $params = [
                                'prodi' => $p,
                                'sd' => $tanggal_awal,
                                'ed' => $tanggal_akhir,
                                'semester' => $smt
                            ];

                            $hsl = $client->get('/m/izin/count', $params,['x-access-token'=>Yii::$app->params['client_token']])->send();
                            if ($hsl->isOk) {
                                $total = $hsl->data['values'];
                                // print_r($result);exit;
                                $results[$item['kode_fakultas']][$p][$smt] = $total; 
                            }
                        }


                        // total belum pulang
                        $p = $item['items'][0]['kode_prodi'];
                        $params = [
                            'prodi' => $p,
                            'sd' => $tanggal_awal,
                            'ed' => $tanggal_akhir,
                            'semester' => $smt,
                            'status' => 1
                        ];

                        $hsl = $client->get('/m/izin/count', $params,['x-access-token'=>Yii::$app->params['client_token']])->send();
                        if ($hsl->isOk) {
                            $total = $hsl->data['values'];
                            // print_r($result);exit;
                            $resultsBelumPulang[$item['kode_fakultas']][$p][$smt] = $total;                

                        }

                        for($j=1;$j<count($item['items']);$j++)
                        {
                            $p = $item['items'][$j]['kode_prodi'];

                            $params = [
                                'prodi' => $p,
                                'sd' => $tanggal_awal,
                                'ed' => $tanggal_akhir,
                                'semester' => $smt,
                                'status' => 1
                            ];

                            $hsl = $client->get('/m/izin/count', $params,['x-access-token'=>Yii::$app->params['client_token']])->send();
                            if ($hsl->isOk) {
                                $total = $hsl->data['values'];
                                // print_r($result);exit;
                                $resultsBelumPulang[$item['kode_fakultas']][$p][$smt] = $total; 
                            }
                        }
                    }
                }
            }
        }
            
        else if(!empty($_POST['btn-export'])){
            if(!empty($_POST['RiwayatPelanggaran']['tanggal_awal']) && !empty($_POST['RiwayatPelanggaran']['tanggal_akhir']))
            {
                $tanggal_awal = \app\helpers\MyHelper::dmYtoYmd($_POST['RiwayatPelanggaran']['tanggal_awal'].' 00:00:00');
                $tanggal_akhir = \app\helpers\MyHelper::dmYtoYmd($_POST['RiwayatPelanggaran']['tanggal_akhir'].' 23:59:59');
                // $prodi = $_POST['prodi'];
                
                $query = RiwayatPelanggaran::find();

                $query->where(['between','tanggal',$tanggal_awal,$tanggal_akhir]);
                $results = $query->all();
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
                        ->setCellValue('C1', 'NIM')
                        ->setCellValue('D1', 'Nama')
                        ->setCellValue('E1', 'Semester')
                        ->setCellValue('F1', 'Asrama-Kamar')
                        ->setCellValue('G1', 'Kelas')
                        ->setCellValue('H1', 'Prodi')
                        ->setCellValue('I1', 'Kategori')
                        ->setCellValue('J1', 'Pelanggaran')
                        ->setCellValue('K1', 'Hukuman')
                        ->setCellValue('L1', 'Status Mhs');

            //Put each record in a new cell

            $i= 1;
            $ii = 2;
            
            foreach($results as $row)
            {
                $skuy = '';
                foreach ($row->riwayatHukumen as $h) {
                    $skuy .= $h->hukuman->nama.', ';
                }

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, date('d/m/Y',strtotime($row->tanggal)));
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $row->nim0->nim_mhs);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$ii, $row->nim0->nama_mahasiswa);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$ii, $row->nim0->semester);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$ii, $row->nim0->kamar->asrama->nama.' - '.$row->nim0->kamar->nama);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$ii, $row->nim0->kampus0->nama_kampus);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$ii, $row->nim0->kodeProdi->singkatan);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$ii, $row->pelanggaran->kategori->nama);
               
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$ii, $row->pelanggaran->nama);
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$ii, $skuy);
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$ii, $row->nim0->status_aktivitas);
                // $objPHPExcel->getActiveSheet()->setCellValue('H'.$ii, $row->subtotal);
                $i++;
                $ii++;
                

                
            }       

            foreach(range('A','L') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }

            // Set worksheet title
            $objPHPExcel->getActiveSheet()->setTitle('Rincian Pelanggaran');
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Rincian_Pelanggaran.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $objWriter->save('php://output');
            exit();           

        }
        


        return $this->render('rekap_perizinan', [
            'results' => $results,
            'model' => $model,
            'list_prodi' => $list_prodi,
            'results' => $results,
            'resultsBelumPulang' => $resultsBelumPulang,
            'resultsSemua' => $resultsSemua
        ]);
    }


    public function actionRincianPelanggaran(){
        
        $model = new RiwayatPelanggaran;
       
        $results = [];
        
        if(!empty($_POST['btn-search'])) {
            if(!empty($_POST['RiwayatPelanggaran']['tanggal_awal']) && !empty($_POST['RiwayatPelanggaran']['tanggal_akhir']))
            {
                $tanggal_awal = \app\helpers\MyHelper::dmYtoYmd($_POST['RiwayatPelanggaran']['tanggal_awal'].' 00:00:00');
                $tanggal_akhir = \app\helpers\MyHelper::dmYtoYmd($_POST['RiwayatPelanggaran']['tanggal_akhir'].' 23:59:59');
                // $prodi = $_POST['prodi'];
                
                $query = RiwayatPelanggaran::find();
                $query->joinWith(['nim0 as mhs']);
                $query->where(['between','tanggal',$tanggal_awal,$tanggal_akhir]);
                if(Yii::$app->user->identity->access_role == 'operatorCabang')
                {
                    $query->andWhere(['mhs.kampus'=>Yii::$app->user->identity->kampus]);    
                }
                
                $results = $query->all();
            }
        }
            
        else if(!empty($_POST['btn-export'])){
            if(!empty($_POST['RiwayatPelanggaran']['tanggal_awal']) && !empty($_POST['RiwayatPelanggaran']['tanggal_akhir']))
            {
                $tanggal_awal = \app\helpers\MyHelper::dmYtoYmd($_POST['RiwayatPelanggaran']['tanggal_awal'].' 00:00:00');
                $tanggal_akhir = \app\helpers\MyHelper::dmYtoYmd($_POST['RiwayatPelanggaran']['tanggal_akhir'].' 23:59:59');
                // $prodi = $_POST['prodi'];
                
                $query = RiwayatPelanggaran::find();
                $query->joinWith(['nim0 as mhs']);
                $query->where(['between','tanggal',$tanggal_awal,$tanggal_akhir]);
                if(Yii::$app->user->identity->access_role == 'operatorCabang')
                {
                    $query->andWhere(['mhs.kampus'=>Yii::$app->user->identity->kampus]);    
                }
                
                $results = $query->all();
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
                        ->setCellValue('C1', 'NIM')
                        ->setCellValue('D1', 'Nama')
                        ->setCellValue('E1', 'Semester')
                        ->setCellValue('F1', 'Asrama-Kamar')
                        ->setCellValue('G1', 'Kelas')
                        ->setCellValue('H1', 'Prodi')
                        ->setCellValue('I1', 'Kategori')
                        ->setCellValue('J1', 'Pelanggaran')
                        ->setCellValue('K1', 'Hukuman')
                        ->setCellValue('L1', 'Status Mhs');

            //Put each record in a new cell

            $i= 1;
            $ii = 2;
            
            foreach($results as $row)
            {
                $skuy = '';
                foreach ($row->riwayatHukumen as $h) {
                    $skuy .= $h->hukuman->nama.', ';
                }

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, date('d/m/Y',strtotime($row->tanggal)));
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $row->nim0->nim_mhs);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$ii, $row->nim0->nama_mahasiswa);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$ii, $row->nim0->semester);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$ii, $row->nim0->kamar->asrama->nama.' - '.$row->nim0->kamar->nama);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$ii, $row->nim0->kampus0->nama_kampus);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$ii, $row->nim0->kodeProdi->singkatan);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$ii, $row->pelanggaran->kategori->nama);
               
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$ii, $row->pelanggaran->nama);
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$ii, $skuy);
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$ii, $row->nim0->status_aktivitas);
                // $objPHPExcel->getActiveSheet()->setCellValue('H'.$ii, $row->subtotal);
                $i++;
                $ii++;
                

                
            }       

            foreach(range('A','L') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }

            // Set worksheet title
            $objPHPExcel->getActiveSheet()->setTitle('Rincian Pelanggaran');
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Rincian_Pelanggaran.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $objWriter->save('php://output');
            exit();           

        }
        

        return $this->render('rincian_pelanggaran', [
            'results' => $results,
            'model' => $model,
            // 'listProdi' => $out
        ]);
    }

    public function actionRekapSemester()
    {
        $model = new RiwayatPelanggaran;
        $results = [];
        // $resultsProdi = [];
        // $out = [];


        if (!empty($_POST['search'])) {
            if(!empty($_POST['RiwayatPelanggaran']['tanggal_awal']) && !empty($_POST['RiwayatPelanggaran']['tanggal_akhir']))
            {
                $sd = $_POST['RiwayatPelanggaran']['tanggal_awal'];
                $ed = $_POST['RiwayatPelanggaran']['tanggal_akhir'];
                
                // $list = Pasien::find()->addFilterWhere(['like',])
                // $out = [];
                $api_baseurl = Yii::$app->params['api_baseurl'];
                try {
                    $client = new Client(['baseUrl' => $api_baseurl]);
                    $response = $client->get('/simpel/rekap/semester', [
                        'sd' => MyHelper::dmYtoYmd($sd),
                        'ed' => MyHelper::dmYtoYmd($ed),
                        'kampus' => Yii::$app->user->identity->kampus
                    ],['x-access-token'=>Yii::$app->params['client_token']])->send();
                    if ($response->isOk) {
                        $result = $response->data['values'];
                        // print_r($result);exit;
                        foreach ($result as $d) {
                            $results[] = [
                                'smt' => $d['semester'],
                                'total'=> $d['total'],
                                // 'singkatan'=> $d['singkatan'],
                               
                            ];
                        }


                    }

                } catch (\Exception $e) {
                    $results = [
                        'kode' => 500,
                        'nama' =>  'Data Tidak Ditemukan'
                    ];
                }          

            }
        }
        
        

        else if (!empty($_POST['export'])) {

            if(!empty($_POST['RiwayatPelanggaran']['tanggal_awal']) && !empty($_POST['RiwayatPelanggaran']['tanggal_akhir']))
            {
                $sd = $_POST['RiwayatPelanggaran']['tanggal_awal'];
                $ed = $_POST['RiwayatPelanggaran']['tanggal_akhir'];
                
                // $list = Pasien::find()->addFilterWhere(['like',])
                // $out = [];
                $api_baseurl = Yii::$app->params['api_baseurl'];
                try {
                    $client = new Client(['baseUrl' => $api_baseurl]);
                    $response = $client->get('/simpel/rekap/semester', [
                        'sd' => MyHelper::dmYtoYmd($sd),
                        'ed' => MyHelper::dmYtoYmd($ed),
                        'kampus' => Yii::$app->user->identity->kampus
                    ],['x-access-token'=>Yii::$app->params['client_token']])->send();
                    if ($response->isOk) {
                        $result = $response->data['values'];
                        // print_r($result);exit;
                        foreach ($result as $d) {
                            $results[] = [
                                'smt' => $d['semester'],
                                'total'=> $d['total'],
                                // 'singkatan'=> $d['singkatan'],
                               
                            ];
                        }


                    }

                } catch (\Exception $e) {
                    $results = [
                        'kode' => 500,
                        'nama' =>  'Data Tidak Ditemukan'
                    ];
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
                        ->setCellValue('B1', 'Semester')
                        ->setCellValue('C1', 'Total');

            //Put each record in a new cell

            $i= 1;
            $ii = 2;
            
            foreach($results as $row)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, $row['smt']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $row['total']);
                $i++;
                $ii++;              
            }       

            foreach(range('A','C') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }

            // Set worksheet title
            $objPHPExcel->getActiveSheet()->setTitle('Pelanggaran Per Semester');
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Rincian_Pelanggaran_Per_Semester.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $objWriter->save('php://output');
            exit();
        }

        return $this->render('rekap_semester', [
            'results' => $results,
            // 'resultsProdi' => $resultsProdi,
            'model' => $model,
            // 'listProdi' => $out
        ]);
    }

    public function actionRekapKategori()
    {
        

        $model = new RiwayatPelanggaran;
        $results = [];


        if(!empty($_POST['btn-search']))
        {
            if(!empty($_POST['RiwayatPelanggaran']['tanggal_awal']) && !empty($_POST['RiwayatPelanggaran']['tanggal_akhir']))
            {
                $tanggal_awal = \app\helpers\MyHelper::dmYtoYmd($_POST['RiwayatPelanggaran']['tanggal_awal'].' 00:00:00');
                $tanggal_akhir = \app\helpers\MyHelper::dmYtoYmd($_POST['RiwayatPelanggaran']['tanggal_akhir'].' 23:59:59');
                
                $query = new \yii\db\Query();
                $results = $query->select(['a.nama', 'COUNT(*) as total'])
                ->from('erp_kategori_pelanggaran a')
                ->innerJoin('erp_pelanggaran b', 'a.id = b.kategori_id')
                ->innerJoin('erp_riwayat_pelanggaran c', 'b.id = c.pelanggaran_id')
                ->where(['between','c.tanggal', $tanggal_awal,$tanggal_akhir])
                ->groupBy('a.nama')
                ->all();
                
            }
        }

        else if(!empty($_POST['btn-export']))
        {
            if(!empty($_POST['RiwayatPelanggaran']['tanggal_awal']) && !empty($_POST['RiwayatPelanggaran']['tanggal_akhir']))
            {
                $tanggal_awal = \app\helpers\MyHelper::dmYtoYmd($_POST['RiwayatPelanggaran']['tanggal_awal'].' 00:00:00');
                $tanggal_akhir = \app\helpers\MyHelper::dmYtoYmd($_POST['RiwayatPelanggaran']['tanggal_akhir'].' 23:59:59');
                
                $query = new \yii\db\Query();
                $results = $query->select(['a.nama', 'COUNT(*) as total'])
                ->from('erp_kategori_pelanggaran a')
                ->innerJoin('erp_pelanggaran b', 'a.id = b.kategori_id')
                ->innerJoin('erp_riwayat_pelanggaran c', 'b.id = c.pelanggaran_id')
                ->where(['between','c.tanggal', $tanggal_awal,$tanggal_akhir])
                ->groupBy('a.nama')
                ->all();
                
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
                        ->setCellValue('B1', 'Kategori')
                        ->setCellValue('C1', 'Total');

            //Put each record in a new cell

            $i= 1;
            $ii = 2;
            
            foreach($results as $row)
            {

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, $row['nama']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $row['total']);
                $i++;
                $ii++;
                  
            }       

            foreach(range('A','C') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }

            // Set worksheet title
            $objPHPExcel->getActiveSheet()->setTitle('Rekap Pelanggaran Per Kategori');
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Rekap_Pelanggaran_PerKategori.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $objWriter->save('php://output');
            exit();           

        }

        return $this->render('rekap_kategori', [
            'results' => $results,
            'model' => $model,
        ]);
    }
    
    public function actionRekapAsrama()
    {
        

        $model = new RiwayatPelanggaran;
        $results = [];


        if(!empty($_POST['btn-search']))
        {
            if(!empty($_POST['RiwayatPelanggaran']['tanggal_awal']) && !empty($_POST['RiwayatPelanggaran']['tanggal_akhir']))
            {
                $tanggal_awal = \app\helpers\MyHelper::dmYtoYmd($_POST['RiwayatPelanggaran']['tanggal_awal'].' 00:00:00');
                $tanggal_akhir = \app\helpers\MyHelper::dmYtoYmd($_POST['RiwayatPelanggaran']['tanggal_akhir'].' 23:59:59');
                
                $query = new \yii\db\Query();
                $results = $query->select(['a.nama', 'COUNT(*) as total'])
                ->from('erp_asrama a')
                ->innerJoin('erp_kamar b', 'a.id = b.asrama_id')
                ->innerJoin('simak_mastermahasiswa c', 'b.id = c.kamar_id')
                ->innerJoin('erp_riwayat_pelanggaran d', 'c.nim_mhs = d.nim')
                ->where(['between','d.tanggal', $tanggal_awal,$tanggal_akhir])
                ->groupBy('a.nama')
                ->all();
                
            }
        }

        else if(!empty($_POST['btn-export']))
        {
            if(!empty($_POST['RiwayatPelanggaran']['tanggal_awal']) && !empty($_POST['RiwayatPelanggaran']['tanggal_akhir']))
            {
                $tanggal_awal = \app\helpers\MyHelper::dmYtoYmd($_POST['RiwayatPelanggaran']['tanggal_awal'].' 00:00:00');
                $tanggal_akhir = \app\helpers\MyHelper::dmYtoYmd($_POST['RiwayatPelanggaran']['tanggal_akhir'].' 23:59:59');
                
                $query = new \yii\db\Query();
                $results = $query->select(['a.nama', 'COUNT(*) as total'])
                ->from('erp_asrama a')
                ->innerJoin('erp_kamar b', 'a.id = b.asrama_id')
                ->innerJoin('simak_mastermahasiswa c', 'b.id = c.kamar_id')
                ->innerJoin('erp_riwayat_pelanggaran d', 'c.nim_mhs = d.nim')
                ->where(['between','d.tanggal', $tanggal_awal,$tanggal_akhir])
                ->groupBy('a.nama')
                ->all();
                
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
                        ->setCellValue('B1', 'Asrama')
                        ->setCellValue('C1', 'Total');

            //Put each record in a new cell

            $i= 1;
            $ii = 2;
            
            foreach($results as $row)
            {

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, $row['nama']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $row['total']);
                $i++;
                $ii++;
                  
            }       

            foreach(range('A','C') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }

            // Set worksheet title
            $objPHPExcel->getActiveSheet()->setTitle('Rekap Pelanggaran Per Asrama');
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Rekap_Pelanggaran_PerAsrama.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $objWriter->save('php://output');
            exit();           

        }

        return $this->render('rekap_asrama', [
            'results' => $results,
            'model' => $model,
        ]);
    }

    public function actionRekapPenghuniAsrama()
    {
        

        $results = [];


        $query = new \yii\db\Query();
        $results = $query->select(['a.nama', 'COUNT(*) as total'])
        ->from('erp_asrama a')
        ->innerJoin('erp_kamar b', 'a.id = b.asrama_id')
        ->innerJoin('simak_mastermahasiswa c', 'b.id = c.kamar_id')
        ->groupBy('a.nama')
        ->all();
                

        if(!empty($_POST['btn-export']))
        {
 
                $query = new \yii\db\Query();
                $results = $query->select(['a.nama', 'COUNT(*) as total'])
                ->from('erp_asrama a')
                ->innerJoin('erp_kamar b', 'a.id = b.asrama_id')
                ->innerJoin('simak_mastermahasiswa c', 'b.id = c.kamar_id')
                ->groupBy('a.nama')
                ->all();
                
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
                        ->setCellValue('B1', 'Asrama')
                        ->setCellValue('C1', 'Total');

            //Put each record in a new cell

            $i= 1;
            $ii = 2;
            
            foreach($results as $row)
            {

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, $row['nama']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $row['total']);
                $i++;
                $ii++;
                  
            }       

            foreach(range('A','C') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }

            // Set worksheet title
            $objPHPExcel->getActiveSheet()->setTitle('Rekap Penghuni Per Asrama');
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Rekap_Penghuni_PerAsrama.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $objWriter->save('php://output');
            exit();           

        }

        return $this->render('rekap_penghuni_asrama', [
            'results' => $results,

        ]);
    }

    public function actionRekapFakultas()
    {
        

        $model = new RiwayatPelanggaran;
        $results = [];

        if(!empty($_POST['btn-search']))
        {
            if(!empty($_POST['RiwayatPelanggaran']['tanggal_awal']) && !empty($_POST['RiwayatPelanggaran']['tanggal_akhir']))
            {
                $sd = $_POST['RiwayatPelanggaran']['tanggal_awal'];
                $ed = $_POST['RiwayatPelanggaran']['tanggal_akhir'];
                
                $api_baseurl = Yii::$app->params['api_baseurl'];
                try {
                    $client = new Client(['baseUrl' => $api_baseurl]);
            
                    $response = $client->get('/simpel/rekap/fakultas', [
                        'sd' => MyHelper::dmYtoYmd($sd),
                        'ed' => MyHelper::dmYtoYmd($ed),
                        'kampus' => Yii::$app->user->identity->kampus
                    ],['x-access-token'=>Yii::$app->params['client_token']])->send();
    
                    if ($response->isOk) {
                        $result = $response->data['values'];
                        // print_r($result);exit;
                        foreach ($result as $d) {
                            $results[] = [
                                'nama' => $d['nama'],
                                'total'=> $d['total'],
                                // 'singkatan'=> $d['singkatan'],
                               
                            ];
                        }
    
    
                    }
                 
                } catch (\Exception $e) {
                    $results = [
                        'kode' => 500,
                        'nama' =>  'Data Tidak Ditemukan'
                    ];
                }
                
            }
        }

        else if(!empty($_POST['btn-export']))
        {
            if(!empty($_POST['RiwayatPelanggaran']['tanggal_awal']) && !empty($_POST['RiwayatPelanggaran']['tanggal_akhir']))
            {
                $sd = $_POST['RiwayatPelanggaran']['tanggal_awal'];
                $ed = $_POST['RiwayatPelanggaran']['tanggal_akhir'];
                
                $api_baseurl = Yii::$app->params['api_baseurl'];
                try {
                    $client = new Client(['baseUrl' => $api_baseurl]);
            
                    $response = $client->get('/simpel/rekap/fakultas', [
                        'sd' => MyHelper::dmYtoYmd($sd),
                        'ed' => MyHelper::dmYtoYmd($ed),
                        'kampus' => Yii::$app->user->identity->kampus
                    ],['x-access-token'=>Yii::$app->params['client_token']])->send();
    
                    if ($response->isOk) {
                        $result = $response->data['values'];
                        // print_r($result);exit;
                        foreach ($result as $d) {
                            $results[] = [
                                'nama' => $d['nama'],
                                'total'=> $d['total'],
                                // 'singkatan'=> $d['singkatan'],
                               
                            ];
                        }
    
    
                    }
                 
                } catch (\Exception $e) {
                    $results = [
                        'kode' => 500,
                        'nama' =>  'Data Tidak Ditemukan'
                    ];
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
                        ->setCellValue('B1', 'Fakultas')
                        ->setCellValue('C1', 'Total');

            //Put each record in a new cell

            $i= 1;
            $ii = 2;
            
            foreach($results as $row)
            {

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, $row['nama']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $row['total']);
                $i++;
                $ii++;
                

                
            }       

            foreach(range('A','C') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }

            // Set worksheet title
            $objPHPExcel->getActiveSheet()->setTitle('Rekap Pelanggaran Per Fakultas');
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Rekap_Pelanggaran_PerFakultas.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $objWriter->save('php://output');
            exit();           

        }

        return $this->render('rekap_fakultas', [
            'results' => $results,
            // 'resultsProdi' => $resultsProdi,
            'model' => $model,
            // 'listProdi' => $out
        ]);
    }

    public function actionRekapProdi(){
        $model = new RiwayatPelanggaran;
        $results = [];
        // $resultsProdi = [];
        // $out = [];

        if (!empty($_POST['search'])) {
            if(!empty($_POST['RiwayatPelanggaran']['tanggal_awal']) && !empty($_POST['RiwayatPelanggaran']['tanggal_akhir']))
            {
                $sd = $_POST['RiwayatPelanggaran']['tanggal_awal'];
                $ed = $_POST['RiwayatPelanggaran']['tanggal_akhir'];
                
                // $list = Pasien::find()->addFilterWhere(['like',])
                // $out = [];
                $api_baseurl = Yii::$app->params['api_baseurl'];
                try {
                    $client = new Client(['baseUrl' => $api_baseurl]);

                    $response = $client->get('/simpel/rekap/prodi', [
                        'sd' => MyHelper::dmYtoYmd($sd),
                        'ed' => MyHelper::dmYtoYmd($ed),
                        'kampus' => Yii::$app->user->identity->kampus
                    ],['x-access-token'=>Yii::$app->params['client_token']])->send();

                    if ($response->isOk) {
                        $results = $response->data['values'];
                        

                    }
                } catch (\Exception $e) {
                    $results = [
                        'kode' => 500,
                        'nama' =>  'Data Tidak Ditemukan'
                    ];
                }

                
            }

        }
        else if (!empty($_POST['export'])) {
            if(!empty($_POST['RiwayatPelanggaran']['tanggal_awal']) && !empty($_POST['RiwayatPelanggaran']['tanggal_akhir']))
            {
                $sd = $_POST['RiwayatPelanggaran']['tanggal_awal'];
                $ed = $_POST['RiwayatPelanggaran']['tanggal_akhir'];
                
                // $list = Pasien::find()->addFilterWhere(['like',])
                // $out = [];
                $api_baseurl = Yii::$app->params['api_baseurl'];
                try {
                    $client = new Client(['baseUrl' => $api_baseurl]);

                    $response = $client->get('/simpel/rekap/prodi', [
                        'sd' => MyHelper::dmYtoYmd($sd),
                        'ed' => MyHelper::dmYtoYmd($ed),
                        'kampus' => Yii::$app->user->identity->kampus
                    ],['x-access-token'=>Yii::$app->params['client_token']])->send();

                    if ($response->isOk) {
                        $results = $response->data['values'];
                    }
                } catch (\Exception $e) {
                    $results = [
                        'kode' => 500,
                        'nama' =>  'Data Tidak Ditemukan'
                    ];
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
                        ->setCellValue('B1', 'Kategori')
                        ->setCellValue('C1', 'Prodi')
                        ->setCellValue('D1', 'Total');

            //Put each record in a new cell

            $i= 1;
            $ii = 2;
            
            foreach($results as $row)
            {
                $size = count($row['items']);

                for($j=0;$j<$size;$j++)
                {

                    $v = $row['items'][$j];
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $i);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, $j==0?$row['kategori_nama']:'');
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $v['singkatan']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$ii, $v['total']);
                    $i++;
                    $ii++;      
                }

                
                
                        
            }       

            foreach(range('A','D') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }

            // Set worksheet title
            $objPHPExcel->getActiveSheet()->setTitle('Pelanggaran Per Prodi');
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Rincian_Pelanggaran_Per_Prodi.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $objWriter->save('php://output');
            exit();
        
        }

        return $this->render('rekap_prodi', [
            'results' => $results,
            // 'resultsProdi' => $resultsProdi,
            'model' => $model,
            // 'listProdi' => $out
        ]);
    }

    // public function actionRekapPelanggaran(){
    //     $model = new RiwayatPelanggaran;
    //     $results = [];
    //     $resultsProdi = [];
    //     // $out = [];


        
    //     if(!empty($_POST['RiwayatPelanggaran']['tanggal_awal']) && !empty($_POST['RiwayatPelanggaran']['tanggal_akhir']))
    //     {
    //         $sd = $_POST['RiwayatPelanggaran']['tanggal_awal'];
    //         $ed = $_POST['RiwayatPelanggaran']['tanggal_akhir'];
            
    //         // $list = Pasien::find()->addFilterWhere(['like',])
    //         // $out = [];
    //         $api_baseurl = Yii::$app->params['api_baseurl'];
    //         try {
    //             $client = new Client(['baseUrl' => $api_baseurl]);
    //             $response = $client->get('/simpel/rekap/semester', [
    //                 'sd' => MyHelper::dmYtoYmd($sd),
    //                 'ed' => MyHelper::dmYtoYmd($ed)
    //             ],['x-access-token'=>Yii::$app->params['client_token']])->send();

    //             $responseProdi = $client->get('/simpel/rekap/prodi', [
    //                 'sd' => MyHelper::dmYtoYmd($sd),
    //                 'ed' => MyHelper::dmYtoYmd($ed)
    //             ],['x-access-token'=>Yii::$app->params['client_token']])->send();

    //             if ($response->isOk) {
    //                 $result = $response->data['values'];
    //                 // print_r($result);exit;
    //                 foreach ($result as $d) {
    //                     $results[] = [
    //                         'smt' => $d['semester'],
    //                         'total'=> $d['total'],
    //                         // 'singkatan'=> $d['singkatan'],
                           
    //                     ];
    //                 }


    //             }

    //             if ($responseProdi->isOk) {
    //                 $result = $responseProdi->data['values'];
    //                 // print_r($result);exit;
    //                 foreach ($result as $d) {
    //                     $resultsProdi[] = [
    //                         'prodi' => $d['singkatan'],
    //                         'total'=> $d['total'],
    //                         // 'singkatan'=> $d['singkatan'],
                           
    //                     ];
    //                 }


    //             }
    //         } catch (\Exception $e) {
    //             $results = [
    //                 'kode' => 500,
    //                 'nama' =>  'Data Tidak Ditemukan'
    //             ];
    //         }

            
    //     }

    //     return $this->render('rekap_pelanggaran', [
    //         'results' => $results,
    //         'resultsProdi' => $resultsProdi,
    //         'model' => $model,
    //         // 'listProdi' => $out
    //     ]);
    // }
    

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
