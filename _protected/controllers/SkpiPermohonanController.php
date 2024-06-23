<?php

namespace app\controllers;

use Yii;
use app\models\SyaratPenerimaan;
use app\models\SimakUniv;
use app\models\SimakSertifikasi;
use app\models\SimakRangeNilai;
use app\models\CapaianPembelajaranLulusan;
use app\models\SimakUniversitas;
use app\models\SimakMastermahasiswa;
use app\models\SkpiPermohonan;
use app\models\SkpiPermohonanSearch;
use yii\web\Controller;
use app\helpers\MyHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\MyTcpdf;
use yii\httpclient\Client;

/**
 * SkpiPermohonanController implements the CRUD actions for SkpiPermohonan model.
 */
class SkpiPermohonanController extends Controller
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
                'only' => ['create','update','delete','index','ajax-apply','print-skpi','ajax-save'],
                'rules' => [
                    [
                        'actions' => ['create','update','delete','index','print-skpi','ajax-save'],
                        'allow' => true,
                        'roles' => ['akpamPusat','admin','sekretearis','fakultas'],
                    ],
                    [
                        'actions' => ['create','ajax-apply','print-skpi'],
                        'allow' => true,
                        'roles' => ['Mahasiswa'],
                    ],
                    [
                        'actions' => [
                            'create','update','delete','index','view','print-skpi','ajax-save'
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

    public function actionAjaxSave()
    {
        $results = [];

        $errors = '';

        if(!empty($_POST['skpi_permohonan_id'])){
            
            $skpi_permohonan_id = $_POST['skpi_permohonan_id'];
            $model = $this->findModel($skpi_permohonan_id);
            $model->deskripsi = $_POST['deskripsi'] ?: '-';
            $model->deskripsi_en = $_POST['deskripsi_en'] ?: '-';
            
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();

           
            try {
                
                if($model->save()){
                    $transaction->commit();
                    
                    $results = [
                        'code' => 200,
                        'message' => 'Data successfully saved'
                    ];
                }

                else{
                    $errors .= \app\helpers\MyHelper::logError($model);
                    throw new \Exception;
                }
            }

            
            catch (\Exception $e) {
                $transaction->rollBack();
                $errors .= $e->getMessage();
                $results = [
                    'code' => $e->getCode(),
                    'message' => $errors
                ];
            } 

            
        }
        
        echo json_encode($results);
        exit;
    }

    public function actionPrintSkpi($id)
    {
        $curDate = date('Y-m-d');

        $model = $this->findModel($id);

        if($model->status_pengajuan != 2){
            Yii::$app->session->setFlash('warning', 'Oops. Permohonan SKPI Anda belum disetujui');
            return $this->redirect(['view','id' => $id]);
        }

        $mhs = $model->nim0;
        
        if (!empty($mhs)) {

            
            try {

                $api_baseurl = Yii::$app->params['api_baseurl'];
                $client = new Client(['baseUrl' => $api_baseurl]);
                $client_token = Yii::$app->params['client_token'];
                $headers = ['x-access-token'=>$client_token];

                $params = [
                    'kode_prodi' => $mhs->kode_prodi
                ];

                $options = [
                    'timeout' => 7
                ];

                $response = $client->get('/spmi/prodi/akreditasi/get', $params,$headers,$options)->send();
                
                $list_akreditasi_nasional = [];
                $list_akreditasi_internasional = [];
                if ($response->isOk) {
                    $values = $response->data['values'];

                    foreach($values as $akr){
                        if($akr['tingkat'] == 3 || $akr['tingkat'] == 2){
                            $list_akreditasi_internasional[] = [
                                'nomor_sk' => $akr['nomor_sk'],
                                'tanggal_sk' => $akr['tanggal_sk'],
                                'lembaga' => $akr['singkatan_lembaga'],
                                'status_akreditasi' => $akr['status_akreditasi'],
                                'status_akreditasi_en' => $akr['status_akreditasi_en']
                            ];
                        }

                        else{
                            $list_akreditasi_nasional[] = [
                                'nomor_sk' => $akr['nomor_sk'],
                                'tanggal_sk' => $akr['tanggal_sk'],
                                'lembaga' => $akr['singkatan_lembaga'],
                                'status_akreditasi' => $akr['status_akreditasi'],
                                'status_akreditasi_en' => $akr['status_akreditasi_en']
                            ];
                        }
                    }
                    $akreditasi = [
                        'nasional' => $list_akreditasi_nasional,
                        'internasional' => $list_akreditasi_internasional,
                    ];
                }

                $list_cpl = CapaianPembelajaranLulusan::find()->where([
                    'kode_prodi' => $mhs->kode_prodi,
                    'state' => '1'
                ])->orderBy(['urutan' => SORT_ASC])->all();

                // $list_sistem_pendidikan = SimakUniv::find()
                //     ->where(['kode'=>'SISDIK'])
                //     ->orderBy(['urutan' => SORT_ASC])
                //     ->all();

                $list_kkni = SimakUniv::find()
                    ->where([
                        'kode'=>'KKNI1',
                        'pilihan_id' => $mhs->kodeProdi->jenjang->id,
                    ])
                    ->orderBy(['urutan' => SORT_ASC])
                    ->all();

                $level_kkni = SimakUniv::findOne([
                    'kode'=>'KKNI1',
                    'pilihan_id' => $mhs->kodeProdi->jenjang->id,
                ]);
                    
                // print_r($mhs->kodeProdi->jenjang);exit;
                $syarat_penerimaan = SyaratPenerimaan::findOne([
                    'jenjang_id' => $mhs->kodeProdi->jenjang->id,

                ]);

                $range_nilai = SimakRangeNilai::find()->orderBy(['dari' => SORT_DESC])->all();
                $label_range_nilai = [];
                foreach($range_nilai as $nilai){
                    $label_range_nilai[] = $nilai->nilai_huruf.'='.$nilai->angka;
                }

                $label_range_nilai = implode(', ', $label_range_nilai);                
                $data_universitas = SimakUniversitas::findOne(['status_aktif' => 'Y']);

                $this->layout = '';

                ob_start();
                $pdf = new MyTcpdf('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                $fontpath = Yii::getAlias('@webroot') . '/themes/ace/fonts/pala.ttf';
                $fontpathbold = Yii::getAlias('@webroot') . '/themes/ace/fonts/palab.ttf';
                $fontpathitalic = Yii::getAlias('@webroot') . '/themes/ace/fonts/palai.ttf';
                $fontreg = \TCPDF_FONTS::addTTFfont($fontpath, 'TrueTypeUnicode', '', 86);
                $fontbold = \TCPDF_FONTS::addTTFfont($fontpathbold, 'TrueTypeUnicode', '', 86);
                $fontitalic = \TCPDF_FONTS::addTTFfont($fontpathitalic, 'TrueTypeUnicode', '', 86);
                // $pdf->SetAutoPageBreak(TRUE, 0);
                $pdf->SetAutoPageBreak(TRUE, 20);
                $pdf->SetFont($fontreg, '', 8, '', false);
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->AddPage();
                $imgdata = Yii::getAlias('@webroot').'/themes/ace/assets/img/logo-ori.png';
                $header_img = Yii::getAlias('@webroot').'/themes/ace/assets/img/header_skpi.png';
                // $imgdata = Yii::getAlias('@webroot').'/themes/klorofil/assets/img/logo_full.png';
                $size = 50;
                $pdf->Image($header_img,10,5,190);

                // $header = '<span style="text-align:center;">UNIVERSITAS DARUSSALAM GONTOR<br>PONOROGO - INDONESIA</span>';
                // $pdf->SetFont($fontbold, '', 12);
                // $pdf->writeHTML($header, true, 0, true, true);

                $pdf->write2DBarcode(($model->link_barcode ?: 'https://unida.gontor.ac.id'), 'QRCODE,H', 180, 35, 16,16);
                $pdf->setXY(10, 30);

                $font_reg_size = 8;

                               
                ob_start();
                echo $this->renderPartial('_header', [
                    'mhs' => $mhs,
                    'model' => $model,
                    'data_universitas' => $data_universitas
                ]);

                $data = ob_get_clean();
                $pdf->SetFont($fontreg, '', 8);
                $pdf->writeHTML($data);

                ob_start();
                echo $this->renderPartial('_identitas', [
                    'mhs' => $mhs,
                ]);

                $data = ob_get_clean();
                $pdf->SetFont($fontreg, '', 7);
                $pdf->writeHTML($data);

                ob_start();
                echo $this->renderPartial('_institusi', [
                    'data_universitas' => $data_universitas,
                    'mhs' => $mhs,
                    'label_range_nilai' => $label_range_nilai,
                    'syarat_penerimaan' => $syarat_penerimaan,
                    'level_kkni' => $level_kkni,
                    'akreditasi' => $akreditasi
                ]);

                $data = ob_get_clean();
                $pdf->SetFont($fontreg, '', 8);
                $pdf->writeHTML($data);


                $pdf->SetHeaderFont([$fontreg, '', 6]);
                $pdf->SetFooterFont([$fontreg, '', 6]);

                $pdf->SetPrintHeader(true);
                $pdf->SetPrintFooter(true);
                $pdf->customHeaderText = $mhs->nama_mahasiswa.' | No. '.$mhs->nina;
                $pdf->AddPage();

                
                ob_start();
                echo $this->renderPartial('_cpl', [
                    'data_universitas' => $data_universitas,
                    'mhs' => $mhs,
                    'list_cpl' => $list_cpl
                ]);

                $data = ob_get_clean();
                $pdf->SetFont($fontreg, '', 8);
                $pdf->writeHTML($data);

                $list_sertifikasi = $mhs->getSimakSertifikasis()->where(['status_validasi' => '1'])->all();
                $list_jenis_sertifikasi = MyHelper::getJenisSertifikasi();
                

                $nilai_akpam = $this->getRekapAkpam($mhs->nim_mhs);
                
                $nilai_kompetensi = $this->getKompetensi($mhs->nim_mhs);
                $nilai_induk_kompetensi = $this->getIndukKompetensi($mhs->nim_mhs);

                ob_start();
                echo $this->renderPartial('_sertifikasi', [
                    'data_universitas' => $data_universitas,
                    'mhs' => $mhs,
                    'model' => $model,
                    'list_jenis_sertifikasi' => $list_jenis_sertifikasi,
                    'list_sertifikasi' => $list_sertifikasi,
                    'nilai_akpam' => $nilai_akpam,
                    'nilai_kompetensi' => $nilai_kompetensi,
                    'nilai_induk_kompetensi' => $nilai_induk_kompetensi
                ]);



                $pdf->AddPage();

                $data = ob_get_clean();

                $pdf->SetFont($fontreg, '', 8);
                $pdf->writeHTML($data);

                $list_prestasi = $mhs->getSimakPrestasis()->where(['status_validasi' => '1'])->all();
                if(count($list_prestasi) > 0){


                    ob_start();
                    echo $this->renderPartial('_prestasi', [
                        'data_universitas' => $data_universitas,
                        'mhs' => $mhs,
                        'model' => $model,
                        'list_prestasi' => $list_prestasi
                    ]);
                    $pdf->AddPage();
                    $data = ob_get_clean();

                    $pdf->SetFont($fontreg, '', 8);
                    $pdf->writeHTML($data);
                }
                // ob_start();
                // echo $this->renderPartial('_sisdik', [
                //     'data_universitas' => $data_universitas,
                //     'mhs' => $mhs,
                //     'list_sistem_pendidikan' => $list_sistem_pendidikan
                // ]);
                // $pdf->AddPage();
                // $data = ob_get_clean();
                // $pdf->SetFont($fontreg, '', 8);
                // $pdf->writeHTML($data);

                ob_start();
                echo $this->renderPartial('_kkni', [
                    'data_universitas' => $data_universitas,
                    'mhs' => $mhs,
                    'list_kkni' => $list_kkni
                ]);
                $pdf->AddPage();
                $data = ob_get_clean();
                $pdf->SetFont($fontreg, '', 8);
                $pdf->writeHTML($data);
                
                $rektor = \app\helpers\MyHelper::getRektor();
                $nama_rektor = !empty($rektor) ? $rektor->rektor0->nama_dosen : 'contoh nama rektor';
                $niy = !empty($rektor) ? $rektor->rektor0->nidn_asli : '';
                $label_dekan_id = !in_array($mhs->kodeProdi->kode_jenjang_studi, ['A', 'B']) ? 'Dekan Fakultas' : 'Direktur Pascasarjana';
                $label_dekan_en = !in_array($mhs->kodeProdi->kode_jenjang_studi, ['A', 'B']) ? 'Dean of ' : 'Director of Postgraduate';

                
                

                $nama_dekan = '';
                $niy_dekan = '';
                if (!empty($mhs->kodeProdi->kodeFakultas->pejabat0)) {
                    $nama_dekan = $mhs->kodeProdi->kodeFakultas->pejabat0->nama_dosen;
                    $niy_dekan = $mhs->kodeProdi->kodeFakultas->pejabat0->niy;
                }

                ob_start();
                echo $this->renderPartial('_pengesahan', [
                    'data_universitas' => $data_universitas,
                    'model' => $model,
                    'mhs' => $mhs,
                    'list_kkni' => $list_kkni,
                    'nama_dekan' => $nama_dekan,
                    'nama_rektor' => $nama_rektor,
                    'niy_rektor' => $niy,
                    'niy_dekan' => $niy_dekan,
                    'label_dekan_id' => $label_dekan_id,
                    'label_dekan_en' => $label_dekan_en,
                ]);

                $pdf->AddPage();
                $data = ob_get_clean();
                $pdf->SetFont($fontreg, '', 8);
                $pdf->writeHTML($data);
                

                // $pdf->writeHTMLCell($page_div_3 + 25, '', 15, '', '<strong><u>' . $nama_rektor . '</u></strong>', 0, 0, 0, true, 'L', true);
                // $pdf->writeHTMLCell($page_div_3 + 5, '', '', '', '', 0, 0, 0, true, 'L', true);
                // $pdf->writeHTMLCell($page_div_3 + 10, '', '', '', '<strong><u>' . $nama_dekan . '</u></strong>', 0, 0, 0, true, 'L', true);
                // $pdf->Ln();
                // $pdf->writeHTMLCell($page_div_3 + 20, '', 15, '', 'NIDN: ' . $niy, 0, 0, 0, true, 'L', true);
                // $pdf->writeHTMLCell($page_div_3 + 10, '', '', '', '', 0, 0, 0, true, 'L', true);
                // $pdf->writeHTMLCell($page_div_3 + 10, '', '', '', 'NIDN: ' . $mhs->kodeProdi->kodeFakultas->pejabat0->nidn_asli, 0, 0, 0, true, 'L', true);
                // $data = ob_get_clean();
                // $pdf->SetFont($fontreg, '', 8);
                // $pdf->writeHTML($data);

                // $pdf->SetFont($fontreg, '', $font_reg_size);
                // $txt = 'SURAT KETERANGAN PENDAMPING IJAZAH ' . strtoupper($mhs->kodeProdi->jenjang->label_id) . ' (' . strtoupper($mhs->kodeProdi->jenjang->label) . ')';
                // $pdf->Cell('', '', $txt, 0, 1, 'C', 0);
                // $pdf->SetFont($fontreg, 'I', 8);
                // $txt = 'DIPLOMA SUPPLEMENT ' . $mhs->kodeProdi->jenjang->label_en . ' Degree';
                // $pdf->Cell('', '', $txt, 0, 1, 'C', 0);
                // $pdf->SetFont($fontreg, '', $font_reg_size);
                // $txt = ($mhs->no_transkrip ?: 'Nomor transkrip belum diisi');
                // $pdf->Cell('', '', $txt, 0, 1, 'C', 0);

                



                // $style = ['width' => 0.4, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => [0, 0, 0]];

                // ob_start();
                // echo $this->renderPartial('print_transkrip', [
                //     'results' => $results1,
                //     'mhs' => $mhs,

                // ]);

                // $data = ob_get_clean();
                // $pdf->SetFont($fontreg, '', 7);
                // $pdf->writeHTML($data);

                // if (in_array($mhs->kodeProdi->kode_jenjang_studi, ['C', 'D'])) {

                //     $pdf->AddPage();
                //     $pdf->setTopMargin(33);

                //     ob_start();
                //     echo $this->renderPartial('print_transkrip', [
                //         'results' => $results2,
                //         'mhs' => $mhs,
                //     ]);

                //     $data = ob_get_clean();
                //     $pdf->SetFont($fontreg, '', 7);
                //     $pdf->writeHTML($data);
                // }

                // $pdf->Ln();
                // if ($pdf->getY() > 210) {
                //     $pdf->AddPage();
                //     $pdf->Ln(15);
                // }

                // $grades = '';
                // $grades .= '<table width="100%" cellpadding="1" border="1">';
                // $grades .= '<tr>';
                // $grades .= '<td colspan="2">Catatan Nilai / Grade Explanation</td>';
                // $grades .= '</tr>';
                // $grades .= '<tr>';
                // $grades .= '<td width="50%" style="text-align:center">2014 - 2020</td>';
                // $grades .= '<td width="50%" style="text-align:center;">2021 - 2025</td>';
                // $grades .= '</tr>';
                // $grades .= '<tr>';
                // $grades .= '<td width="50%">';
                // $grades .= '<table width="100%" cellpadding="0" >';
                // foreach ($list_konversi_lama as $key => $value) {

                //     $grades .= '<tr>';
                //     $grades .= '<td width="30%"  style="text-align:left">&nbsp;&nbsp;' . $key . '</td>';
                //     $grades .= '<td width="70%" style="text-align:left">: ' . $value . '</td>';
                //     $grades .= '</tr>';
                // }

                // $grades .= '</table>';
                // $grades .= '</td>';
                // $grades .= '<td width="50%">';
                // $grades .= '<table width="100%" cellpadding="0">';

                // foreach ($konversi_nilai as $key => $value) {
                //     if ($value <= 1) continue;

                //     $grades .= '<tr>';
                //     $grades .= '<td width="30%"  style="text-align:left;">&nbsp;&nbsp;' . $key . '</td>';
                //     $grades .= '<td width="70%" style="text-align:left">: ' . $value . '</td>';
                //     $grades .= '</tr>';
                // }

                // $grades .= '<tr>';
                // $grades .= '<td width="30%"  style="text-align:left;">&nbsp;</td>';
                // $grades .= '<td width="70%" style="text-align:left">&nbsp;</td>';
                // $grades .= '</tr>';


                // $grades .= '<tr>';
                // $grades .= '<td width="30%"  style="text-align:left;">&nbsp;</td>';
                // $grades .= '<td width="70%" style="text-align:left">&nbsp;</td>';
                // $grades .= '</tr>';

                // $grades .= '</table>';
                // $grades .= '</td>';
                // $grades .= '</tr>';
                // $grades .= '</table>';


                // $y = $pdf->getY();
                // $pdf->SetFont($fontreg, '', $font_reg_size);
                // $pdf->writeHTMLCell(50, 38, '', $y, $grades, 0, 0, 0, true, 'J', true);
                // // $pdf->writeHTMLCell(50, 10,  '', $y, '2014', 1, 0, 0, false, 'J', true);

                // $pdf->SetFont($fontreg, 'B', 8);

                // $skripsi = strip_tags($mhs->judul_skripsi) . '<br>';
                // if (!empty($mhs->judul_skripsi_ar)) {
                //     $font_arab_path = Yii::getAlias('@webroot') . '/themes/klorofil/assets/fonts/trado.ttf';
                //     $font_arab = \TCPDF_FONTS::addTTFfont($font_arab_path, 'TrueTypeUnicode', '', 86);

                //     $skripsi .= '<span style="font-size:12px;direction: rtl;">' . strip_tags($mhs->judul_skripsi_ar) . '</span>';
                //     $pdf->SetFont($font_arab, '', 8);
                //     if (in_array($mhs->kodeProdi->kode_jenjang_studi, ['C', 'D'])) {
                //         $pdf->writeHTMLCell($pdf->GetPageWidth() - 70, 24, '', '', '<strong>Skripsi / Thesis</strong><br>' . $skripsi, 1, 0, 0, true, 'C', true);
                //     } else {
                //         $pdf->writeHTMLCell($pdf->GetPageWidth() - 70, 24, '', '', '<strong>Tesis / Thesis</strong><br>' . $skripsi, 1, 0, 0, true, 'C', true);
                //     }

                //     $pdf->setRTL(false);
                // } else {
                //     $skripsi .= '<span style="font-style:italic;">' . strip_tags($mhs->judul_skripsi_en) . '</span>';
                //     $pdf->SetFont($fontreg, '', $font_reg_size);
                //     if (in_array($mhs->kodeProdi->kode_jenjang_studi, ['C', 'D'])) {
                //         $pdf->writeHTMLCell($pdf->GetPageWidth() - 70, 24, '', '', '<strong>Skripsi / Thesis</strong><br>' . $skripsi, 1, 0, 0, true, 'C', true);
                //     } else {
                //         $pdf->writeHTMLCell($pdf->GetPageWidth() - 70, 24, '', '', '<strong>Tesis / Thesis</strong><br>' . $skripsi, 1, 0, 0, true, 'C', true);
                //     }
                // }

                // $pdf->Ln();

                // $page_div_3 = ($pdf->GetPageWidth() - 70) / 3;
                // $pdf->SetFont($fontreg, '', $font_reg_size);
                // $pdf->writeHTMLCell($page_div_3, 13.5, 60, '', '<strong>Total SKS</strong> / Total of Credits<br>' . $mhs->SKSLulus, 1, 0, 0, true, 'C', true);
                // $pdf->writeHTMLCell($page_div_3, 13.5, 60 + $page_div_3, '', '<strong>IPK</strong> / GPA<br>' . \app\helpers\MyHelper::formatRupiah($mhs->getIpk(), 2), 1, 0, 0, true, 'C', true);
                // $pdf->writeHTMLCell($page_div_3, 13.5, 60 + $page_div_3 + $page_div_3, '', '<strong>Predikat</strong> / Predicate<br><strong>' . strtoupper($predikat_label) . '</strong><br>' . strtoupper($predikat_label_en), 1, 0, 0, true, 'C', true);


                // $pdf->Ln();
                // $pdf->Ln(2);

                // $rektor = \app\helpers\MyHelper::getRektor();
                // $nama_rektor = !empty($rektor) ? $rektor->rektor0->nama_dosen : 'contoh nama rektor';
                // $niy = !empty($rektor) ? $rektor->rektor0->nidn_asli : '';
                // $label_dekan_id = !in_array($mhs->kodeProdi->kode_jenjang_studi, ['A', 'B']) ? 'Dekan,' : 'Direktur,';
                // $label_dekan_en = !in_array($mhs->kodeProdi->kode_jenjang_studi, ['A', 'B']) ? 'Dean,' : 'Director,';

                // $pdf->MultiCell($pdf->GetPageWidth() - 80, '', '', 0, 'C', 0, 0);
                // $pdf->MultiCell('', '', 'Ponorogo, ' . (isset($mhs->tgl_lulus) ? \app\helpers\MyHelper::convertTanggalIndo($mhs->tgl_lulus) : 'not set'), 0, 'L', 0, 0);
                // $pdf->Ln();
                // $pdf->writeHTMLCell($page_div_3 + 20, '', 15, '', 'Rektor,', 0, 0, 0, true, 'C', true);
                // $pdf->writeHTMLCell($page_div_3 + 5, '', '', '', '', 0, 0, 0, true, 'C', true);
                // $pdf->writeHTMLCell($page_div_3 + 10, '', '', '', $label_dekan_id, 0, 0, 0, true, 'C', true);
                // $pdf->Ln();
                // $pdf->writeHTMLCell($page_div_3 + 20, '', 15, '', '<i>Rector,</i>', 0, 0, 0, true, 'C', true);
                // $pdf->writeHTMLCell($page_div_3 + 5, '', '', '', '<br><br><br><br>Pas foto 2x3', 0, 0, 0, true, 'C', true);
                // $pdf->writeHTMLCell($page_div_3 + 10, '', '', '', '<i>' . $label_dekan_en . '</i>', 0, 0, 0, true, 'C', true);
                // // $pdf->MultiCell(($pdf->GetPageWidth() - 20) / 3, '', '<i>Rector</i>,', 0, 'C', 0, 0,15);
                // // $pdf->MultiCell(($pdf->GetPageWidth() - 20) / 3, '', '', 0, 'C', 0, 0);
                // // $pdf->MultiCell(($pdf->GetPageWidth() - 20) / 3 - 20, '', '<i>'.$label_dekan_en.'</i>', 0, 'C', 0, 0);
                // // $pdf->Ln();
                // // $pdf->writeHTMLCell($page_div_3+20, '', '15', '', 'a', 1, 0, 0, true, 'C', true);
                // // if($pdf->getY() > 247) // ada mata kuliah yang panjang
                // //     $pdf->Ln(18);
                // // else
                // // if(!in_array($mhs->kodeProdi->kode_jenjang_studi, ['C','D']))
                // //     $pdf->Ln(16);
                // // else
                // $pdf->Ln(18);


                // $nama_dekan = '';
                // if (!empty($mhs->kodeProdi->kodeFakultas->pejabat0)) {
                //     $nama_dekan = $mhs->kodeProdi->kodeFakultas->pejabat0->nama_dosen;
                // }

                // $pdf->writeHTMLCell($page_div_3 + 25, '', 15, '', '<strong><u>' . $nama_rektor . '</u></strong>', 0, 0, 0, true, 'L', true);
                // $pdf->writeHTMLCell($page_div_3 + 5, '', '', '', '', 0, 0, 0, true, 'L', true);
                // $pdf->writeHTMLCell($page_div_3 + 10, '', '', '', '<strong><u>' . $nama_dekan . '</u></strong>', 0, 0, 0, true, 'L', true);
                // $pdf->Ln();
                // $pdf->writeHTMLCell($page_div_3 + 20, '', 15, '', 'NIDN: ' . $niy, 0, 0, 0, true, 'L', true);
                // $pdf->writeHTMLCell($page_div_3 + 10, '', '', '', '', 0, 0, 0, true, 'L', true);
                // $pdf->writeHTMLCell($page_div_3 + 10, '', '', '', 'NIDN: ' . $mhs->kodeProdi->kodeFakultas->pejabat0->nidn_asli, 0, 0, 0, true, 'L', true);
               
                $pdf->Output('skpi_' . $mhs->nim_mhs . '.pdf', 'I');
                die();
            } catch (\HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
        die();
    }

    public function actionAjaxApply()
    {
        $results = [
            'code' => 406,
            'message' => 'Bad Request'
        ] ;
        if (!Yii::$app->user->isGuest && Yii::$app->request->isPost) {
            if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
                $model = SkpiPermohonan::findOne(['nim' => Yii::$app->user->identity->nim]);

                if(!empty($model)){
                    $results = [
                        'code' => 500,
                        'message' => 'Anda saat ini sudah memiliki permohonan SKPI'
                    ] ;         
                }

                else{
                    $model = new SkpiPermohonan;
                    $model->id = MyHelper::gen_uuid();
                    $model->tanggal_pengajuan = date('YmdHis');
                    $model->status_pengajuan = '1';
                    $model->nim = Yii::$app->user->identity->nim;
                    if($model->save()){
                        $results = [
                            'code' => 200,
                            'message' => 'Data permohonan SKPI berhasil diajukan'
                        ] ;  
                    }

                    else{
                        $error = MyHelper::logError($model);
                        $results = [
                            'code' => 500,
                            'message' => $error
                        ] ; 
                    }
                }    
            }
            
        }

        echo json_encode($results);
        exit;
    }

    /**
     * Lists all SkpiPermohonan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SkpiPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $kode_prodi = '';
        $list_prodi = [];
        if (!Yii::$app->user->isGuest) {
            if(Yii::$app->user->identity->access_role == 'sekretearis'){
                $kode_prodi = Yii::$app->user->identity->prodi;
                $listProdi = \app\models\SimakMasterprogramstudi::find()->where(['kode_prodi' => $kode_prodi])->all();

                foreach ($listProdi as $item_name) {
                    $list_prodi[$item_name->kode_prodi] = $item_name->nama_prodi;
                } 
            }
            else if(Yii::$app->user->identity->access_role == 'fakultas'){
                $kode_fakultas = Yii::$app->user->identity->fakultas;
                $listProdi = \app\models\SimakMasterprogramstudi::find()->where(['kode_fakultas' => $kode_fakultas])->all();

                foreach ($listProdi as $item_name) {
                    $list_prodi[$item_name->kode_prodi] = $item_name->nama_prodi;
                } 
            }
            else{
                $list_fakultas = \app\models\SimakMasterfakultas::find()->orderBy(['nama_fakultas'=>SORT_ASC])->all();
                $listProdi = \app\models\SimakMasterprogramstudi::find()->all();

                foreach ($listProdi as $item_name) {
                    $list_prodi[$item_name->kode_prodi] = $item_name->nama_prodi;
                }
            }
        }
        if (Yii::$app->request->post('hasEditable')) {

            // instantiate your book model for saving
            $id = Yii::$app->request->post('editableKey');
            $model = SkpiPermohonan::findOne($id);

            // store a default json response as desired by editable
            $out = json_encode(['output' => '', 'message' => '']);

            $posted = current($_POST['SkpiPermohonan']);
            $post = ['SkpiPermohonan' => $posted];

            // load model like any single model validation
            if ($model->load($post)) {

                // can save model or do something before saving model
                if ($model->save()) {
                    $out = json_encode(['output' => '', 'message' => '']);
                } else {
                    $error = \app\helpers\MyHelper::logError($model);
                    $out = json_encode(['output' => '', 'message' => 'Oops, ' . $error]);
                }
            }
            // return ajax json encoded response and exit
            echo $out;
            exit;
        }


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'kode_prodi' => $kode_prodi,
            'list_prodi' => $list_prodi
        ]);
    }

    /**
     * Displays a single SkpiPermohonan model.
     * @param string $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $mhs = $model->nim0;
        return $this->render('view', [
            'model' => $model,
            'mhs' => $mhs
        ]);
    }

    /**
     * Creates a new SkpiPermohonan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SkpiPermohonan();
        $model->id = MyHelper::gen_uuid();
        $model->tanggal_pengajuan = date('Y-m-d H:i:s');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SkpiPermohonan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->approved_by = Yii::$app->user->identity->id;
            if($model->save()){
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SkpiPermohonan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SkpiPermohonan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return SkpiPermohonan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SkpiPermohonan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function getIndukKompetensi($nim)
    {
        $list_induk = \app\models\SimakIndukKegiatan::find()->all();

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
            $label_en = !empty($range) ? $range->label_en : '';
            $color = !empty($range) ? $range->color : '';
            $results[$induk->id] = [
                'persentase' => $persentase,
                'akpam' => round($pembagi > 0 ? $akpam_total / $pembagi : $akpam_total,2),
                'induk' => $induk->nama,
                'induk_en' => $induk->nama_en,
                'induk_id' => $induk->id,
                'label' => $label,
                'label_en' => $label_en,
                'color' => $color
            ];
        }

        return $results;
        
    }

    private function getKompetensi($nim)
    {

        $list_kompetensi = \app\models\SimakPilihan::find()->select(['id', 'label_en','label'])->where(['kode' => 'kompetensi'])->cache(60)->all();

        $mhs = SimakMastermahasiswa::findOne(['nim_mhs' => $nim]);
        $tahun_awal = $mhs->tahun_masuk . '1';
        $tahun_lulus = (!empty($mhs->tgl_lulus) ? date('Y',strtotime($mhs->tgl_lulus)) : null);

        $query = \app\models\SimakTahunakademik::find();
        $query->where(['>=', 'tahun_id', $tahun_awal]);

        if(!empty($tahun_lulus))
            $query->andWhere(['<=', 'tahun_id', $tahun_lulus.'2']);

        $list_tahun = $query->orderBy(['tahun_id' => SORT_DESC])->cache(60 * 10)->all();


        $pembagi = count($list_tahun);
        foreach($list_kompetensi as $kompetensi){

            $total_bobot = 0;
            $induk = \app\models\SimakIndukKegiatanKompetensi::findOne(['pilihan_id' => $kompetensi->id]);
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
            $label_en = '';
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
                    $label_en = $range->label_en;
                    $color = $range->color;
                    
                }
            }

            $results[] = [
                'total' => round($avg_bobot,2),
                'induk' => '',
                'induk_id' => '',
                'nama' => $kompetensi->label,
                'nama_en' => $kompetensi->label_en,
                'limit' => 5,
                'label' => $label,
                'label_en' => $label_en,
                'color' => $color,
                'nilai_akhir' => round($nilai_akhir,2)
            ];

            $unsorted[] = [
                'normalized' => $normalized,
                'komponen' => $kompetensi->label_en,
                'komponen_indonesia' => $kompetensi->label,
                'kompetensi_id' => $kompetensi->id,
                'label' => $label,
                
            ];

            $topAndBottonSkills = MyHelper::getTopAndBottonSkills($unsorted);
            
            $sorted = $topAndBottonSkills['sorted'];
            $list_bottom_skills = $topAndBottonSkills['list_bottom_skills'];
            $list_top_skills = $topAndBottonSkills['list_top_skills'];
            $list_bottom_skills_en = $topAndBottonSkills['list_bottom_skills_en'];
            $list_top_skills_en = $topAndBottonSkills['list_top_skills_en'];
            $bottom3_evaluasi = $topAndBottonSkills['bottom3_evaluasi'];
            $top3_evaluasi = $topAndBottonSkills['top3_evaluasi'];
        }
        
        return [
            'items' => $results,
            'sorted' => $sorted,
            'list_bottom_skills' => '<b>'.$list_bottom_skills.'</b>',
            'list_top_skills' => '<b>'.$list_top_skills.'</b>',
            'list_bottom_skills_en' => '<b>'.$list_bottom_skills_en.'</b>',
            'list_top_skills_en' => '<b>'.$list_top_skills_en.'</b>',
            'bottom3_evaluasi' => $bottom3_evaluasi,
            'top3_evaluasi' => $top3_evaluasi,
        ];
           
    }

    private function getRekapAkpam($nim)
    {
        $results = [];
        $list_akpam = [];
        $params = [];
        $listJenisKegiatan = \app\models\SimakJenisKegiatan::find()->all();
        
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
                'nama_en' => $jk->nama_jenis_kegiatan_en,
                'nilai' => $nilai
            ];
        }

        $pembagi = $limit_semester;
        $subakpam = $subakpam / $pembagi;

        $ipks = $subakpam / 100;
        $results['total'] = $subakpam;
        $results['ipks'] = $ipks;
        $results['items'] = $items;
        return $results;
    }
}
