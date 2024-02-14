<?php

namespace app\controllers;

use Yii;
use app\models\SimakLayananSurat;
use app\models\SimakLayananSuratSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\helpers\MyHelper;
use yii\httpclient\Client;
use app\models\SimakSyaratBebasAsrama;
use app\models\SimakSyaratBebasAsramaMahasiswa;
use app\models\SimakSyaratBebasAsramaMahasiswaSearch;
/**
 * SimakLayananSuratController implements the CRUD actions for SimakLayananSurat model.
 */
class SimakLayananSuratController extends Controller
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
                'only' => ['create','update','view','index','delete','download','approve'],
                'rules' => [
                    [
                        'actions' => [
                            'create','view','index','download'
                        ],
                        'allow' => true,
                        'roles' => ['operatorCabang','operatorUnit'],
                    ],
                    [
                        'actions' => [
                            'update','view','index','download','approve'
                        ],
                        'allow' => true,
                        'roles' => ['operatorCabang','operatorUnit'],
                    ],
                    [
                        'actions' => [
                            'create','update','view','index','delete','download','approve'
                        ],
                        'allow' => true,
                        'roles' => ['theCreator'],
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

    public function actionDownload($id)
    {
        $model = $this->findModel($id);

        try {

            $api_baseurl = Yii::$app->params['api_baseurl'];
            $client = new Client(['baseUrl' => $api_baseurl]);
            $client_token = Yii::$app->params['client_token'];
            $headers = ['x-access-token'=>$client_token];
                // ob_start();

            $this->layout = '';
            $orientation = 'P';
            $pdf = new \TCPDF($orientation, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);
            
            $fontpath = Yii::getAlias('@webroot') . '/themes/ace/fonts/pala.ttf';

            $fontreg = \TCPDF_FONTS::addTTFfont($fontpath, 'TrueTypeUnicode', '', 96);
            $pdf->SetAutoPageBreak(TRUE, 0);
            $pdf->SetFont($fontreg, '', 9);
            $pdf->AddPage();
            ob_start();
            $mhs = $model->nim0;

            $style = array(
                'border' => false,
                'padding' => 0,
                'fgcolor' => array(0, 0, 0),
                'bgcolor' => false, //array(255,255,255)
            );
            
            // echo '<pre>';print_r($model->jenis_surat);exit;

            switch($model->jenis_surat){
                case 1: 
                $pdf->SetMargins(20, 10, 10, true); // set the margins 
                    echo $this->renderPartial('print_surat_keterangan_aktif', [
                        'model' => $model,
                        'mhs' => $mhs,
                        'thn' => $model->tahun,
                        // 'jenis' => $jenis,
                        'kampus' => $mhs->kampus0,
                        // 'tanggal' => $tanggal,
                        'fakultas' => $mhs->kodeProdi->kodeFakultas,
                        'nama_dekan' => $model->nama_pejabat,
                        'prodi' => $mhs->kodeProdi,
                        'niy' => $model->nip
                        // 'listkrs' => $krs_mhs
                    ]);

                    $data = ob_get_clean();
                    $pdf->writeHTML($data);

                    $surat_setting = \app\models\SimakLayananSuratSetting::findOne(['kode_fakultas' => $mhs->kodeProdi->kode_fakultas]);

                    $imgdata = (!empty($surat_setting) ? $surat_setting->file_header_path : '');
                    $pdf->Image($imgdata, 5, 5, 200);

                    $imgdata = (!empty($surat_setting) ? $surat_setting->file_sign_path : '');
                    $pdf->Image($imgdata, 95, 200, 70);
                break;
                case 2: 
                    $params = [
                        'nama_unit' => 'Kepesantrenan',
                    ];

                    $nama_pejabat = '';
                    $niy = '';
                    $response = $client->get('/simpeg/list/unitkerja', $params,$headers)->send();
                    if ($response->isOk) {
                        $data = $response->data['values'];
                        if(count($data) > 0){
                            $nama_pejabat = $data[0]['nama_pejabat'];
                            $niy = $data[0]['niy'];
                        }
                    }
                    $pdf->SetMargins(20, 10, 20, true); // set the margins 
                    echo $this->renderPartial('print_surat_bebas_sanksi_disiplin', [
                        'model' => $model,
                        'mhs' => $mhs,
                        'thn' => $model->tahun,
                        // 'jenis' => $jenis,
                        'kampus' => $mhs->kampus0,
                        // 'tanggal' => $tanggal,
                        'fakultas' => $mhs->kodeProdi->kodeFakultas,
                        'nama_dekan' => $nama_pejabat,
                        'prodi' => $mhs->kodeProdi,
                        'niy' => $niy
                        // 'listkrs' => $krs_mhs
                    ]);

                    $data = ob_get_clean();
                    $pdf->writeHTML($data);

                    $surat_setting = \app\models\SimakLayananSuratSetting::findOne(['kode_fakultas' => 'dkp']);
                    if(!empty($surat_setting)){
                        
                        if(!file_exists(Yii::$app->basePath . '/../uploads/header.jpg')){
                            $local_header_path = basename(parse_url($surat_setting->file_header_path, PHP_URL_PATH));
                            $image = file_get_contents($surat_setting->file_header_path);
                            file_put_contents(Yii::$app->basePath.'/../uploads/header.jpg', $image);
                            
                        }

                        if(!file_exists(Yii::$app->basePath . '/../uploads/footer.jpg')){
                            $local_header_path = basename(parse_url($surat_setting->file_footer_path, PHP_URL_PATH));
                            $image = file_get_contents($surat_setting->file_footer_path);
                            file_put_contents(Yii::$app->basePath.'/../uploads/footer.jpg', $image);
                            
                        }

                        if(!file_exists(Yii::$app->basePath . '/../uploads/ttd.jpg')){
                            $local_header_path = basename(parse_url($surat_setting->file_sign_path, PHP_URL_PATH));
                            $image = file_get_contents($surat_setting->file_sign_path);
                            file_put_contents(Yii::$app->basePath.'/../uploads/ttd.jpg', $image);
                            
                        }

                        $imgdata = Yii::$app->basePath.'/../uploads/header.jpg';
                        $pdf->Image($imgdata, 5, 5, 200);

                        $imgdata = Yii::$app->basePath.'/../uploads/ttd.jpg';
                        if($mhs->kampus0->kode_kampus == 1 && in_array($mhs->kode_jenjang_studi,['C','D']) ){
                            $pdf->Image($imgdata, 75, 187, 65);

                            $pdf->write2DBarcode($mhs->nim_mhs.'/'.$mhs->nama_mahasiswa.'/'.date('d-m-Y',strtotime($model->tanggal_disetujui)).'/'.$mhs->nama_mahasiswa, 'QRCODE,Q', 20, 180, 24, 30, $style, 'N');
                        }

                        else{
                            $pdf->Image($imgdata, 30, 185, 65);
                            if(!empty($mhs->koordinator)){
                                $imgdata = $mhs->koordinator->ttd_path;
                                $pdf->Image($imgdata, 120, 185, 65);
                            }

                            $pdf->write2DBarcode($mhs->nim_mhs.'/'.$mhs->nama_mahasiswa.'/'.date('d-m-Y',strtotime($model->tanggal_disetujui)).'/'.$mhs->nama_mahasiswa, 'QRCODE,Q', 20, 165, 220, 16, $style, 'N');
                        }
                        // $pdf->Image($imgdata, 65, 187, 65);

                        $imgdata = Yii::$app->basePath.'/../uploads/footer.jpg';
                        $pdf->Image($imgdata, 5, 285, 200);
                    }

                    
                break;
                case 3: 
                $list_akpam = [];
                    $listJenisKegiatan = [];
                    $list_ipks = [];
                    $subakpam = 0;
                    $ipks = 0;
                    
                    $listJenisKegiatan = \app\models\SimakJenisKegiatan::find()->all();
                    $limit_semester = 14;
                            
                    
                    $list_akpam = $this->getRekapIpks($model->nim);
                    $nim = $model->nim;
                    $subakpam = 0;

                    foreach($listJenisKegiatan as $jk) {
                        $sum = 0;
                        for($i=1;$i<=$limit_semester;$i++) {
                            $formated_akpam = '';
                            if(!empty($list_akpam[$i][$jk->id][$nim])) {
                                $akpam = $list_akpam[$i][$jk->id][$nim];
                                $akpam = $akpam >= $jk->nilai_maximal ? $jk->nilai_maximal : $akpam;
                                $formated_akpam = round($akpam);
                                $sum += $akpam;
                            }
                            
                            else
                            {
                                $formated_akpam = '-';
                            }
                        }

                        $subakpam += $sum;
                        $avg = $sum / $model->nim0->semester;
                        $ipks = round($avg,2);

                        $list_ipks[$jk->id] = $avg;
                    }

                    $pembagi = $model->nim0->semester;
                    $subakpam = $subakpam / $pembagi;
                    $ipks = $subakpam / 100;
                       

                    $params = [
                        'nama_unit' => 'Kepesantrenan',
                    ];

                    $nama_pejabat = '';
                    $niy = '';
                    $response = $client->get('/simpeg/list/unitkerja', $params,$headers)->send();
                    if ($response->isOk) {
                        $data = $response->data['values'];
                        if(count($data) > 0){
                            $nama_pejabat = $data[0]['nama_pejabat'];
                            $niy = $data[0]['niy'];
                        }
                    }
                    $pdf->SetMargins(20, 10, 20, true); // set the margins 
                    echo $this->renderPartial('print_surat_keterangan_akpam', [
                        'model' => $model,
                        'mhs' => $mhs,
                        'thn' => $model->tahun,
                        // 'jenis' => $jenis,
                        'kampus' => $mhs->kampus0,
                        // 'tanggal' => $tanggal,
                        'fakultas' => $mhs->kodeProdi->kodeFakultas,
                        'nama_dekan' => $nama_pejabat,
                        'prodi' => $mhs->kodeProdi,
                        'niy' => $niy,
                        'list_akpam' => $list_akpam,
                        'listJenisKegiatan' => $listJenisKegiatan,
                        'list_ipks' => $list_ipks,
                        'subakpam' => $subakpam,
                        'ipks' => $ipks
                        // 'listkrs' => $krs_mhs
                    ]);

                    $data = ob_get_clean();
                    $pdf->writeHTML($data);

                    $surat_setting = \app\models\SimakLayananSuratSetting::findOne(['kode_fakultas' => 'dkp']);
                    if(!empty($surat_setting)){
                        
                        if(!file_exists(Yii::$app->basePath . '/../uploads/header.jpg')){
                            $local_header_path = basename(parse_url($surat_setting->file_header_path, PHP_URL_PATH));
                            $image = file_get_contents($surat_setting->file_header_path);
                            file_put_contents(Yii::$app->basePath.'/../uploads/header.jpg', $image);
                            
                        }

                        if(!file_exists(Yii::$app->basePath . '/../uploads/footer.jpg')){
                            $local_header_path = basename(parse_url($surat_setting->file_footer_path, PHP_URL_PATH));
                            $image = file_get_contents($surat_setting->file_footer_path);
                            file_put_contents(Yii::$app->basePath.'/../uploads/footer.jpg', $image);
                            
                        }

                        if(!file_exists(Yii::$app->basePath . '/../uploads/ttd.jpg')){
                            $local_header_path = basename(parse_url($surat_setting->file_sign_path, PHP_URL_PATH));
                            $image = file_get_contents($surat_setting->file_sign_path);
                            file_put_contents(Yii::$app->basePath.'/../uploads/ttd.jpg', $image);
                            
                        }

                        $imgdata = Yii::$app->basePath.'/../uploads/header.jpg';
                        $pdf->Image($imgdata, 5, 5, 200);

                        $imgdata = Yii::$app->basePath.'/../uploads/ttd.jpg';
                        if($mhs->kampus0->kode_kampus == 1 && in_array($mhs->kode_jenjang_studi,['C','D']) ){
                            $pdf->Image($imgdata, 65, 230, 65);

                            $pdf->write2DBarcode($mhs->nim_mhs.'/'.$mhs->nama_mahasiswa.'/'.date('d-m-Y',strtotime($model->tanggal_disetujui)).'/'.$mhs->nama_mahasiswa, 'QRCODE,Q', 20, 210, 20, 16, $style, 'N');
                        }

                        else{
                            $pdf->Image($imgdata, 30, 230, 65);
                            if(!empty($mhs->koordinator)){
                                $imgdata = $mhs->koordinator->ttd_path;
                                $pdf->Image($imgdata, 120, 230, 65);
                            }

                            $pdf->write2DBarcode($mhs->nim_mhs.'/'.$mhs->nama_mahasiswa.'/'.date('d-m-Y',strtotime($model->tanggal_disetujui)).'/'.$mhs->nama_mahasiswa, 'QRCODE,Q', 20, 210, 220, 16, $style, 'N');
                        }

                        $imgdata = Yii::$app->basePath.'/../uploads/footer.jpg';
                        $pdf->Image($imgdata, 5, 285, 200);
                    }

                    
                break;
                case 4: 
                $params = [
                        'nama_unit' => 'Kepesantrenan',
                    ];

                    $nama_pejabat = '';
                    $niy = '';
                    $response = $client->get('/simpeg/list/unitkerja', $params,$headers)->send();
                    if ($response->isOk) {
                        $data = $response->data['values'];
                        if(count($data) > 0){
                            $nama_pejabat = $data[0]['nama_pejabat'];
                            $niy = $data[0]['niy'];
                        }
                    }
                    $pdf->SetMargins(20, 10, 20, true); // set the margins 
                    echo $this->renderPartial('print_surat_bebas_asrama', [
                        'model' => $model,
                        'mhs' => $mhs,
                        'thn' => $model->tahun,
                        // 'jenis' => $jenis,
                        'kampus' => $mhs->kampus0,
                        // 'tanggal' => $tanggal,
                        'fakultas' => $mhs->kodeProdi->kodeFakultas,
                        'nama_dekan' => $nama_pejabat,
                        'prodi' => $mhs->kodeProdi,
                        'niy' => $niy
                        // 'listkrs' => $krs_mhs
                    ]);

                    $data = ob_get_clean();
                    $pdf->writeHTML($data);

                    $surat_setting = \app\models\SimakLayananSuratSetting::findOne(['kode_fakultas' => 'dkp']);
                    if(!empty($surat_setting)){
                        
                        if(!file_exists(Yii::$app->basePath . '/../uploads/header.jpg')){
                            $local_header_path = basename(parse_url($surat_setting->file_header_path, PHP_URL_PATH));
                            $image = file_get_contents($surat_setting->file_header_path);
                            file_put_contents(Yii::$app->basePath.'/../uploads/header.jpg', $image);
                            
                        }

                        if(!file_exists(Yii::$app->basePath . '/../uploads/footer.jpg')){
                            $local_header_path = basename(parse_url($surat_setting->file_footer_path, PHP_URL_PATH));
                            $image = file_get_contents($surat_setting->file_footer_path);
                            file_put_contents(Yii::$app->basePath.'/../uploads/footer.jpg', $image);
                            
                        }

                        if(!file_exists(Yii::$app->basePath . '/../uploads/ttd.jpg')){
                            $local_header_path = basename(parse_url($surat_setting->file_sign_path, PHP_URL_PATH));
                            $image = file_get_contents($surat_setting->file_sign_path);
                            file_put_contents(Yii::$app->basePath.'/../uploads/ttd.jpg', $image);
                            
                        }

                        $imgdata = Yii::$app->basePath.'/../uploads/header.jpg';
                        $pdf->Image($imgdata, 5, 5, 200);

                        $imgdata = Yii::$app->basePath.'/../uploads/ttd.jpg';
                        if($mhs->kampus0->kode_kampus == 1 && in_array($mhs->kode_jenjang_studi,['C','D']) ){
                            $pdf->Image($imgdata, 65, 216, 65);

                            $pdf->write2DBarcode($mhs->nim_mhs.'/'.$mhs->nama_mahasiswa.'/'.date('d-m-Y',strtotime($model->tanggal_disetujui)).'/'.$mhs->nama_mahasiswa, 'QRCODE,Q', 20, 210, 20, 16, $style, 'N');
                        }

                        else{
                            $pdf->Image($imgdata, 30, 216, 65);
                            if(!empty($mhs->koordinator)){
                                $imgdata = $mhs->koordinator->ttd_path;
                                $pdf->Image($imgdata, 120, 216, 65);
                            }

                            $pdf->write2DBarcode($mhs->nim_mhs.'/'.$mhs->nama_mahasiswa.'/'.date('d-m-Y',strtotime($model->tanggal_disetujui)).'/'.$mhs->nama_mahasiswa, 'QRCODE,Q', 20, 210, 220, 16, $style, 'N');
                        }

                        $imgdata = Yii::$app->basePath.'/../uploads/footer.jpg';
                        $pdf->Image($imgdata, 5, 285, 200);
                    }

                    
                break;
            }
            

            

            

            
            ob_end_clean();
            $pdf->Output($model->nim.$model->tahun->tahun_id.'.pdf');
        } catch (\HTML2PDF_exception $e) {
            print_r($e->getMessage());
            exit;
        }

        die();
    }

    /**
     * Lists all SimakLayananSurat models.
     * @return mixed
     */
    public function actionIndex($jenis_surat = 1)
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/logout']);
        }

        $searchModel = new SimakLayananSuratSearch();
        $searchModel->jenis_surat = $jenis_surat;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $mhs = null;
        if(Yii::$app->user->identity->access_role == 'Mahasiswa'){

            $mhs = \app\models\SimakMastermahasiswa::findOne(['nim_mhs' => Yii::$app->user->identity->nim]);

        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mhs' => $mhs,
            'jenis_surat' => $jenis_surat
        ]);
    }

    /**
     * Displays a single SimakLayananSurat model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $list_akpam = [];
        $listJenisKegiatan = [];
        $list_ipks = [];
        $subakpam = 0;
        $ipks = 0;
        $searchModel = null;
        $dataProvider = null;

        $searchModelBerkas = null;
        $dataProviderBerkas = null;
        switch($model->jenis_surat){
            case 3:
            $listJenisKegiatan = \app\models\SimakJenisKegiatan::find()->all();
            $limit_semester = 14;
                    
            
            $list_akpam = $this->getRekapIpks($model->nim);
            $nim = $model->nim;
            $subakpam = 0;

            foreach($listJenisKegiatan as $jk) {
                $sum = 0;
                for($i=1;$i<=$limit_semester;$i++) {
                    $formated_akpam = '';
                    if(!empty($list_akpam[$i][$jk->id][$nim])) {
                        $akpam = $list_akpam[$i][$jk->id][$nim];
                        $akpam = $akpam >= $jk->nilai_maximal ? $jk->nilai_maximal : $akpam;
                        $formated_akpam = round($akpam);
                        $sum += $akpam;
                    }
                    
                    else
                    {
                        $formated_akpam = '-';
                    }
                }

                $subakpam += $sum;
                $avg = $sum / $model->nim0->semester;
                $ipks = round($avg,2);

                $list_ipks[$jk->id] = $avg;
            }

            $pembagi = $model->nim0->semester;
            $subakpam = $subakpam / $pembagi;
            $ipks = $subakpam / 100;
            break;

            case 4:
            // $list_syarat_bebas = SimakSyaratBebasAsrama::find()->where(['is_aktif' => 'Y'])->all();

            $searchModel = new SimakSyaratBebasAsramaMahasiswaSearch();
            $searchModel->mhs_id = $model->nim0->id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $searchModelBerkas = new SimakLayananSuratSearch();
            $searchModelBerkas->jenis_surat = [2,3];
            $searchModelBerkas->nim = $model->nim;
            $dataProviderBerkas = $searchModelBerkas->search(Yii::$app->request->queryParams);
            break;
        }
        return $this->render('view', [
            'model' => $model,
            'list_akpam' => $list_akpam,
            'listJenisKegiatan' => $listJenisKegiatan,
            'list_ipks' => $list_ipks,
            'subakpam' => $subakpam,
            'ipks' => $ipks,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelBerkas' => $searchModelBerkas,
            'dataProviderBerkas' => $dataProviderBerkas,
        ]);
    }

    /**
     * Creates a new SimakLayananSurat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($jenis_surat=1)
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/logout']);
        }

        $model = new SimakLayananSurat();
        $model->id = MyHelper::gen_uuid();
        $errors = '';
        // 1 = Suket Aktif, 2 = Bebas Sanksi Disiplin, 3= Ket lulus akpam, 4 = bebas asrama
        $model->jenis_surat = $jenis_surat; 
        $mhs = null;
        if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
            $model->nim = Yii::$app->user->identity->nim;

            $mhs = \app\models\SimakMastermahasiswa::findOne(['nim_mhs' => $model->nim]);

            if(!empty($mhs) && $mhs->status_aktivitas != 'A'){
                Yii::$app->session->setFlash('danger', 'Mohon maaf, Anda tidak bisa mengajukan surat keterangan aktif karena status Anda belum Aktif.');
                return $this->redirect(['index']);
            }
        }

        if ($model->load(Yii::$app->request->post())) {

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $keperluan_id = $_POST['keperluan_id'];
                $model->tanggal_diajukan = date('Y-m-d H:i:s');
                if($keperluan_id != 99){
                    $list_keperluan = explode("/", $model->keperluan);
                    if(count($list_keperluan) > 1){
                        if($model->bahasa == 'id')
                            $model->keperluan = $list_keperluan[0];
                        else if($model->bahasa == 'en')
                            $model->keperluan = $list_keperluan[1];
                    }

                    
                }
                
                $mhs = \app\models\SimakMastermahasiswa::findOne(['nim_mhs' => $model->nim]);
                $list_header = MyHelper::getListHeaderSurat();
                $konten = [
                    'judul' => $list_header[$jenis_surat],
                    'isi' => 'Mahasiswa atas nama <b>'.$mhs->nama_mahasiswa.'</b> NIM <b>'.$model->nim.'</b> telah mengajukan '.$list_header[$jenis_surat].' untuk keperluan <b>'.$model->keperluan.'</b>'
                ];

                $emailTemplate = $this->renderPartial('email_template', [
                    'konten' => $konten,
                ]);

                $user = \app\models\User::findOne([
                    'prodi' => $mhs->kode_prodi,
                    'access_role' => 'sekretearis'
                ]);
                
                Yii::$app->mailer->compose()
                ->setTo(trim($user->email))
                ->setFrom([Yii::$app->params['supportEmail'] => 'SIAKAD UNIDA Gontor'])
                ->setSubject('[SIAKAD] '.$list_header[$jenis_surat])
                ->setHtmlBody($emailTemplate)
                ->send();

                

                if($model->validate()){
                    $model->save();
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Data tersimpan");
                    return $this->redirect(['index','jenis_surat' => $jenis_surat]);
                }
            } catch (\Exception $e) {
                $errors .= $e->getMessage();
                $transaction->rollBack();
                Yii::$app->session->setFlash('danger', $errors);
                
            }

            
        }

        return $this->render('create', [
            'model' => $model,
            'jenis_surat' => $jenis_surat
        ]);
    }

    private function getRekapIpks($nim)
    {
        $results = [];
        $list_akpam = [];
        $params = [];
        // $listJenisKegiatan = \app\models\SimakJenisKegiatan::find()->all();
        
        // $results = SimakMastermahasiswa::find();

        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $client_token = Yii::$app->params['client_token'];
        $headers = ['x-access-token' => $client_token];

        $params = [
            'nim' => $nim
        ];
        $response = $client->get('/report/akpam/get', $params, $headers)->send();


        if ($response->isOk) {
            // print_r($response->data);exit;
            $temp = $response->data['values'];

            foreach ($temp as $tmp) {
                foreach ($tmp as $t) {

                    $list_akpam[$t['semester']][$t['id_jenis_kegiatan']][$t['nim']] = $t['akpam'];
                }
            }
        }
        
        return $list_akpam;
    }

    /**
     * Updates an existing SimakLayananSurat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post())) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            $errors = '';
            try {

                // Ngirim email jika hanya status ajuan DISETUJUI
                if($model->status_ajuan == 1){
                    $list_header = MyHelper::getListHeaderSurat();
                    $model->tanggal_disetujui = date('Y-m-d H:i:s');
                    $mhs = \app\models\SimakMastermahasiswa::findOne(['nim_mhs' => $model->nim]);
                    $konten = [
                        'judul' => $list_header[$model->jenis_surat].' Anda Disetujui',
                        'isi' => 'Dear <b>'.$mhs->nama_mahasiswa.'</b><br>. '.$list_header[$model->jenis_surat].' Anda telah disetujui. Silakan Cek SIAKAD Anda untuk mengunduh surat tersebut. Terima kasih sudah menggunakan layanan ini.'
                    ];

                    $emailTemplate = $this->renderPartial('email_template', [
                        'konten' => $konten,
                    ]);

                    // $user = \app\models\User::findOne([
                    //     'nim' => $mhs->nim_mhs,
                    //     'access_role' => 'Mahasiswa'
                    // ]);
                    
                    Yii::$app->mailer->compose()
                    ->setTo(trim($mhs->email))
                    ->setFrom([Yii::$app->params['supportEmail'] => 'SIKAP UNIDA Gontor'])
                    ->setSubject('[SIAKAD] '.$list_header[$model->jenis_surat])
                    ->setHtmlBody($emailTemplate)
                    ->send();
                }

                if($model->validate()){
                    $mhs = $model->nim0;
                    $dekan = $mhs->kodeProdi->kodeFakultas->pejabat0;
                    $model->nama_pejabat = $dekan->nama_dosen;
                    $model->nip = $dekan->niy;
                    $model->save();

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Data tersimpan");
                    return $this->redirect(['index','jenis_surat' => $model->jenis_surat]);
                }
            } catch (\Exception $e) {
                $errors .= $e->getMessage();
                $transaction->rollBack();
                Yii::$app->session->setFlash('danger', $errors);
                
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SimakLayananSurat model.
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
     * Finds the SimakLayananSurat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SimakLayananSurat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakLayananSurat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
