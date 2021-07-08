<?php

namespace app\controllers;

use Yii;
use app\helpers\MyHelper;
use app\models\Events;
use app\models\SimakTahunakademik;
use app\models\SimakKegiatanMahasiswa;
use app\models\EventsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use yii\web\UploadedFile;
/**
 * EventsController implements the CRUD actions for Events model.
 */
class EventsController extends Controller
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
                'only' => ['update','index','view','delete','start'],
                'rules' => [
                    
                    [
                        'actions' => [
                            'update','index','view','start','delete'
                        ],
                        'allow' => true,
                        'roles' => ['theCreator','admin','operatorCabang','event'],
                    ],
                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'register' => ['post'],
                ],
            ],
        ];
    }

    public function actionAjaxListPeserta()
    {
        $dataPost = $_POST['dataPost'];
         // header('Content-Type: application/json');
        $model = Events::findOne($dataPost['event_id']);
        $list = $model->simakKegiatanMahasiswas;
        $results = [];
        // $colors = ['info','important','danger','success','purple','pink','yellow'];
        foreach($list as $res)
        {
            $results[] = [
                'id' => $res->id,
                'nim' => $res->nim,
                'nama' => $res->nim0->nama_mahasiswa,
                'checked_in' => $res->created_at,
                'prodi' => $res->nim0->kodeProdi->singkatan,
                'semester' => $res->nim0->semester
            ];
        }

        echo json_encode($results);
        exit;
    }

    public function actionAjaxRegister()
    {
        $dataPost = $_POST['dataPost'];
        $model = Events::findOne($dataPost['event_id']);
        $nim = $dataPost['nim'];

        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        
        $errors = '';
        $results = [];
        
        try 
        {

            $tahun_aktif = \app\models\SimakTahunakademik::getTahunAktif();
            $mhs = \app\models\SimakMastermahasiswa::find()->where(['nim_mhs'=>$nim])->one();
            if(!empty($model))
            {
                $keg = SimakKegiatanMahasiswa::find()->where([
                    'nim' => $nim,
                    'event_id' => $model->id
                ])->one();

                if(empty($keg))
                {
                    $keg = new SimakKegiatanMahasiswa;
                    $keg->nim =  $nim;
                    $keg->event_id = $model->id;
                    $keg->tahun_akademik = $tahun_aktif->tahun_id;
                    $keg->id_kegiatan = $model->kegiatan_id;
                    $keg->id_jenis_kegiatan = $model->kegiatan->id_jenis_kegiatan;
                    $keg->nilai = $model->kegiatan->nilai;
                    $keg->semester = (string)$mhs->semester;
                    $keg->waktu = $model->tanggal_mulai;
                    $keg->instansi = $model->penyelenggara;
                    $keg->tema = $model->nama;
                    $keg->is_approved = 1;
                    if($keg->save())
                    {
                        $results = [
                            'code' => 200,
                            'message' => 'Participant added'
                        ];

                        $transaction->commit();

                    }

                    else
                    {
                        $errors .= \app\helpers\MyHelper::logError($keg);
                        throw new \Exception;
                    }
                }

                else
                {
                    $errors .= 'This student has already been registered';
                    throw new \Exception;
                }
            }

            else
            {
                $errors .= 'Oops, Event does not exist';
                throw new \Exception;
                
            }
        } 
        catch (\Exception $e) {
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

        echo json_encode($results);
        die();
    }

    public function actionScan($id)
    {
        $model = Events::findOne($id);
        
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        
        $errors = '';
        $results = [];
        
        try 
        {
            if(empty(Yii::$app->user) || empty(Yii::$app->user->identity))
            {
                $errors .= 'Please Login as student';
                throw new \Exception;
                
            }

            if(Yii::$app->user->identity->access_role != 'Mahasiswa')
            {
                $errors .= 'Only a student can be allowed to scan this event';
                throw new \Exception;
            }

            $nim = Yii::$app->user->identity->nim;

            $tahun_aktif = \app\models\SimakTahunakademik::getTahunAktif();
            $mhs = \app\models\SimakMastermahasiswa::find()->where(['nim_mhs'=>$nim])->one();
            if(!empty($model))
            {
                if($model->status != '1')
                {
                    $list_status = \app\helpers\MyHelper::getStatusEvent();
                    $errors .= 'Oops, sorry, this event is '.$list_status[$model->status].'. You cannot register now';
                    throw new \Exception;
                }
                
                $keg = SimakKegiatanMahasiswa::find()->where([
                    'nim' => $nim,
                    'event_id' => $model->id
                ])->one();

                if(empty($keg))
                {
                    $keg = new SimakKegiatanMahasiswa;
                    $keg->nim =  $nim;
                    $keg->event_id = $model->id;
                    $keg->tahun_akademik = $tahun_aktif->tahun_id;
                    $keg->id_kegiatan = $model->kegiatan_id;
                    $keg->id_jenis_kegiatan = $model->kegiatan->id_jenis_kegiatan;
                    $keg->nilai = $model->kegiatan->nilai;
                    $keg->semester = (string)$mhs->semester;
                    $keg->waktu = $model->tanggal_mulai;
                    $keg->instansi = $model->penyelenggara;
                    $keg->tema = $model->nama;
                    $keg->is_approved = 1;
                    if($keg->save())
                    {
                        $results = [
                            'code' => 200,
                            'message' => 'Participant added'
                        ];

                        $transaction->commit();

                    }

                    else
                    {
                        $errors .= \app\helpers\MyHelper::logError($keg);
                        throw new \Exception;
                    }
                }

                else
                {
                    $errors .= 'This student has already been registered';
                    throw new \Exception;
                }
            }

            else
            {
                $errors .= 'Oops, Event does not exist';
                throw new \Exception;
                
            }
        } 
        catch (\Exception $e) {
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

        echo json_encode($results);
        die();
    }

    public function actionRegister($id)
    {   
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data(\yii\helpers\Url::to('https://siakad.unida.gontor.ac.id/events/scan?id='.$id))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            // ->logoPath(__DIR__.'/assets/symfony.png')
            ->labelText('Scan me to register')
            ->labelFont(new NotoSans(20))
            ->labelAlignment(new LabelAlignmentCenter())
            ->build();
        $model = $this->findModel($id);
        return $this->render('register',[
            'model' => $model,
            'result' => $result
        ]);
    }

    public function actionDownload()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','Petunjuk Pengisian');
        $sheet->setCellValue('A2', 'Format TglMulai & TglSelesai : yyyy-mm-dd hh:mm:ss. Tambahkan petik satu di awal tanggal. Contoh: \'2021-01-01 09:30:00');
        
        $sheet->setCellValue('A3', 'Isian Tingkat adalah [Lokal,Provinsi,Nasional,Internasional]');
        $sheet->setCellValue('A4', 'Isian Priority adalah [LOW,MED,HI,IM]');
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');
        $sheet->mergeCells('A3:G3');
        $sheet->mergeCells('A4:G4');
        $sheet->setCellValue('A5', 'Form Pengisian. Silakan isi event di bawah ini:');
        $sheet->mergeCells('A5:G5');
        $sheet->setCellValue('A6', 'Nama Event')
            ->setCellValue('B6', 'Venue/Tempat Acara')
            ->setCellValue('C6', 'Penyelenggara')
            ->setCellValue('D6', 'Tingkat')
            ->setCellValue('E6', 'Priority')
            ->setCellValue('F6', 'TglMulai')
            ->setCellValue('G6', 'TglSelesai');

        $sheet->getColumnDimension('A')->setWidth(50);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
    
        
        // foreach(range('A','H') as $columnID) {
  
        $filename = "template_events_".mt_rand(1,100000).'.xlsx'; //just some random filename
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename);
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit; //done.. exiting!
        
    }

    public function actionAjaxDelete()
    {
        $model = Events::findOne($_POST['id']);
        $results = [];
        $errors = '';
        if($model->delete())
        {
            $results = [
                'code' => 200,
                'message' => 'Data deleted'
            ];
        }

        else
        {
            $errors .= MyHelper::logError($model);
            $results = [
                'code' => 500,
                'id' => null,
                'message' => $errors
            ];
        }
        

        echo json_encode($results);
        exit;
    }

    public function actionAjaxGet()
    {
        $model = Events::findOne($_POST['id']);
       
            
        $results = [
            'id' => $model->id,
            'start' => $model->tanggal_mulai,
            'end' => $model->tanggal_selesai,
            'nama' => $model->nama,
            'tingkat' => $model->tingkat,
            'penyelenggara' => $model->penyelenggara,
            'venue' => $model->venue,
            'priority' => $model->priority,
            'kegiatan_id' => $model->kegiatan_id,
            'tahun_id' => $model->tahun_id,
            'toleransi_masuk' => $model->toleransi_masuk,
            'toleransi_keluar' => $model->toleransi_keluar,
        ];
        
        echo json_encode($results);
        exit;
    }

    public function actionAjaxUpdate()
    {
        $dataPost = $_POST['dataPost'];
        $model = Events::findOne($dataPost['id']);

        $model->nama = $dataPost['nama'];
        $model->tanggal_mulai = date('Y-m-d H:i:s',strtotime($dataPost['start']));
        $model->tanggal_selesai = date('Y-m-d H:i:s',strtotime($dataPost['end']));
        $model->penyelenggara = $dataPost['penyelenggara'];
        $model->venue = $dataPost['venue'];
        $model->tingkat = $dataPost['tingkat'];
        $model->priority = $dataPost['priority'];
        $model->kegiatan_id = $dataPost['kegiatan_id'];
        $model->tahun_id = $dataPost['tahun_id'];
        $model->toleransi_masuk = $dataPost['toleransi_masuk'];
        $model->toleransi_keluar = $dataPost['toleransi_keluar'];

        $results = [];
        $errors = '';
        if($model->save())
        {
            $results = [
                'code' => 200,
                'id' => $model->id,
                'message' => 'Data event updated'
            ];
        }

        else
        {
            $errors .= MyHelper::logError($model);
            $results = [
                'code' => 500,
                'id' => null,
                'message' => $errors
            ];
        }
        

        echo json_encode($results);
        exit;
    }

    public function actionAjaxAdd()
    {
        $dataPost = $_POST['dataPost'];
        $model = new Events;
        $model->id = 'CRT'.MyHelper::getRandomString().MyHelper::appendZeros(rand(1,1000),4);
        $model->nama = $dataPost['nama'];
        $model->tanggal_mulai = date('Y-m-d H:i:s',strtotime($dataPost['start']));
        $model->tanggal_selesai = date('Y-m-d H:i:s',strtotime($dataPost['end']));
        $model->penyelenggara = $dataPost['penyelenggara'];
        $model->venue = $dataPost['venue'];
        $model->tingkat = $dataPost['tingkat'];
        $model->priority = $dataPost['priority'];
        $model->kegiatan_id = $dataPost['kegiatan_id'];
        $model->tahun_id = $dataPost['tahun_id'];
        $model->toleransi_masuk = $dataPost['toleransi_masuk'];
        $model->toleransi_keluar = $dataPost['toleransi_keluar'];
        $results = [];
        $errors = '';
        if($model->save())
        {
            $results = [
                'code' => 200,
                'id' => $model->id,
                'message' => 'Data inserted'
            ];
        }

        else
        {
            $errors .= MyHelper::logError($model);
            $results = [
                'code' => 500,
                'id' => null,
                'message' => $errors
            ];
        }
        

        echo json_encode($results);
        exit;
    }

    public function actionAjaxList()
    {
         // header('Content-Type: application/json');
        $sd = $_GET['start'];
        $ed = $_GET['end'];
        $query = Events::find();
        $query->andWhere(['between','tanggal_mulai',$sd,$ed]);

        $results = [];
        // $colors = ['info','important','danger','success','purple','pink','yellow'];
        foreach($query->all() as $res)
        {
            $results[] = [
                'id' => $res->id,
                'start' => $res->tanggal_mulai,
                'end' => $res->tanggal_selesai,
                'title' => "Kegiatan: ".$res->nama.". Lokasi: ".$res->venue.". Tingkat: ".$res->tingkat.". Penyelenggara: ".$res->penyelenggara,
                'className' => 'label-'.$res->priority
            ];
        }

        echo json_encode($results);
        exit;
    }

    public function actionDaily($daily='today')
    {
        $searchModel = new EventsSearch();
        $dataProvider = $searchModel->searchDaily($daily,Yii::$app->request->queryParams);

        return $this->render('daily', [
            'searchModel' => $searchModel,
            'daily' => $daily,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Lists all Events models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $id = Yii::$app->request->post('editableKey');
            $model = Events::findOne($id);

            // store a default json response as desired by editable
            $out = json_encode(['output'=>'', 'message'=>'']);

            
            $posted = current($_POST['Events']);
            $post = ['Events' => $posted];

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
        ]);
    }

    /**
     * Displays a single Events model.
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

    public function actionAjaxStart()
    {
        $dataPost = $_POST['dataPost'];
        $model = Events::findOne($dataPost['id']);

        $model->status = $dataPost['status'];

        $results = [];
        $errors = '';
        if($model->save())
        {
            $results = [
                'code' => 200,
 
                'message' => 'Data event updated'
            ];
        }

        else
        {
            $errors .= MyHelper::logError($model);
            $results = [
                'code' => 500,
 
                'message' => $errors
            ];
        }
        

        echo json_encode($results);
        exit;
    }

    /**
     * Creates a new Events model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Events();
        $listTahun = SimakTahunakademik::find()->select(['tahun_id','nama_tahun'])->orderBy(['tahun_id' => SORT_DESC])->limit(5)->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'listTahun' => $listTahun
        ]);
    }

    /**
     * Updates an existing Events model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $file_path = $model->file_path;
        $s3config = Yii::$app->params['s3'];
        $s3 = new \Aws\S3\S3Client($s3config);
        $listTahun = SimakTahunakademik::find()->select(['tahun_id','nama_tahun'])->orderBy(['tahun_id' => SORT_DESC])->limit(5)->all();
        $errors = '';
        if ($model->load(Yii::$app->request->post())) 
        {
            $model->file_path = UploadedFile::getInstance($model,'file_path');
         
            $transaction = \Yii::$app->db->beginTransaction();
            try 
            {
                if($model->file_path)
                {
                    $file_path = $model->file_path->tempName;
                    $mime_type = $model->file_path->type;
                    
                    $file = 'evt_'.$model->id.'.'.$model->file_path->extension;

                    
                    $errors = '';
                            
                    $key = 'event/'.$model->tingkat.'/'.$model->venue.'/'.$file;
                     
                    $insert = $s3->putObject([
                         'Bucket' => 'siakad',
                         'Key'    => $key,
                         'Body'   => 'This is the Body',
                         'SourceFile' => $file_path,
                         'ContentType' => $mime_type
                    ]);

                    
                    $plainUrl = $s3->getObjectUrl('siakad', $key);
                    $model->file_path = $plainUrl;
                }

                if (empty($model->file_path)){
                    $model->file_path = $file_path;
                }

                if($model->save())
                {
                    
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Data tersimpan");
                    return $this->redirect(['index']);
                }

                else
                {

                    $errors .= \app\helpers\MyHelper::logError($model);
                    throw new \Exception;
                    
                }
            }

            catch (\Throwable $e) { // For PHP 7
                $transaction->rollBack();
                $errors .= $e->getMessage();
                Yii::$app->session->setFlash('danger', $errors);
                
            }

            catch(\Exception $e)
            {
                $transaction->rollBack();
                $errors .= $e->getMessage();
                Yii::$app->session->setFlash('danger', $errors);

                
            }
        }

        return $this->render('update_event', [
            'model' => $model,
            'listTahun' => $listTahun
        ]);
    }

    /**
     * Deletes an existing Events model.
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
     * Finds the Events model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Events the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Events::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
