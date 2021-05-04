<?php

namespace app\controllers;

use Yii;
use app\helpers\MyHelper;
use app\models\Events;
use app\models\EventsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Protection;

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
                        'roles' => ['theCreator','admin','operatorCabang'],
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
            'kegiatan_id' => $model->kegiatan_id
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
