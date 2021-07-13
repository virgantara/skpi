<?php

namespace app\controllers;

use Yii;
use app\models\Dapur;
use app\models\DapurSearch;

use app\models\Asrama;
use app\models\AsramaSearch;

use app\models\SimakMastermahasiswa;
use app\models\SimakMasterprogramstudi;
use app\models\RiwayatKamar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Protection;
/**
 * AsramaController implements the CRUD actions for Asrama model.
 */
class AsramaController extends Controller
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

    public function actionListAsrama()
    {   
        $kampus_id = $_POST['kampus_id'];
        $results = [];
        if (!empty($kampus_id)) 
        {
            $temp = Asrama::find()->where([ 'kampus_id' => $kampus_id ])->all();
            foreach($temp as $t)
            {
                $results[] = [
                    'id' => $t->id,
                    'nama' => $t->nama
                ];
            }
            echo json_encode($results);

            
        }
        die();
    }    

    public function actionAjaxDapur()
    {
        $dataku = $_POST['dataku'];
        $nim = $dataku['nimku'];
        $dapur_id = $dataku['dapur_id'];
        if (!empty($dataku['nimku'])) {
            if (!empty($dataku['dapur_id'])) {
                $data = SimakMastermahasiswa::find()->where([ 'nim_mhs' => $nim ])->one();
                $kamarLama = $data->kamar;
                
                $data->dapur_id = $dapur_id;
                $data->save();
                
                $results = [
                    'code' => 200,
                    'msg' => "Perpindahan Berhasil",
                    'dapur' => $data->dapur->nama,
                ];
                echo json_encode($results);

            }
            else{
                echo "Dapur kosong, Isi terlebih dahulu";
            }
        }
        else {
            echo "NIM kosong, Isi terlebih dahulu";
        }
        die();
    }

    public function actionDapur()
    {
        $model = new SimakMastermahasiswa;
        $model->setScenario('asrama');


        $query = Dapur::find();

        if(Yii::$app->user->identity->access_role == 'operatorCabang')
        {
            $query->where(['kampus'=>Yii::$app->user->identity->kampus]);
        }

        $listDapur = $query->all();
        $results = [];
        $params = [];

        if (!empty($_GET['btn-search'])) {
            if(!empty($_GET['SimakMastermahasiswa']))
            {
                $params = $_GET['SimakMastermahasiswa'];
                $results = SimakMastermahasiswa::find()->where([
                    'kampus' => $params['kampus'],
                    'kode_prodi' => !empty($params['kode_prodi']) ? $params['kode_prodi'] : '-',
                    
                    'status_aktivitas' => $params['status_aktivitas'],
                ])->orderBy(['semester'=>SORT_DESC,'nama_mahasiswa'=>SORT_ASC])->all();          


            }
        }
        return $this->render('dapur',[
            'model' => $model,
            'results' => $results,
            'params' => $params,
            'listDapur' => $listDapur
        ]);
    } 

    public function actionSync()
    {
        $penghunis = \app\models\AsramaRaw::find()->all();

        foreach ($penghunis as $key => $value) {



            $m = SimakMastermahasiswa::find()->where(['nim_mhs'=>$value->nim])->one();
            $notfound = 0;
            $saved = 0;


            if(!empty($m))
            {        


                if(!empty($value->kamar) && !empty($value->asrama_id))
                {
                    $kamar = \app\models\Kamar::find()->where([
                        'nama' => $value->kamar,
                        'asrama_id' => $value->asrama_id
                    ])->one();
                    
                    if(empty($kamar)){
                        $kamar = new \app\models\Kamar;
                        $kamar->kapasitas = 0;
                    }

                    $kamar->nama = $value->kamar;
                    $kamar->asrama_id = $value->asrama_id;
                    
                    if($kamar->validate())
                    {
                        $kamar->save();
                        $m->kamar_id = $kamar->id;
                        $m->save(false,['kamar_id']);
                        $saved++;
                    }

                    else
                    {
                        print_r($kamar->getErrors());exit;
                        
                    }
                }
                // if($value->status_aktivitas != 'A')
                // {
                    // $m->status_aktivitas = $value->status_aktivitas;
                    // $m->save(false,['status_aktivitas']);
                // }
            }

            else{
                $notfound++;
            }
        }
        echo 'NotFound: '.$notfound;
        echo 'Saved: '.$saved;
        die();
    }

    private function getProdiList($id){
        $list = SimakMasterprogramstudi::find()->where(['kode_fakultas'=>$id])->all();
        $result = [];
        foreach($list as $item)
        {
            $result[] = [
                'id' => $item->kode_prodi,
                'name' => $item->kode_prodi.' - '.$item->nama_prodi
            ];
        }

        return $result;
    }

    public function actionProdi() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_all_params'])) {
            // print_r($_POST);
            $parents = $_POST['depdrop_all_params'];
            if ($parents != null) {
                $cat_id = !empty($parents['fakultas_id']) ? $parents['fakultas_id']: '-';
                $selected_id = !empty($parents['selected_id']) ? $parents['selected_id'] : '-';
                $out = self::getProdiList($cat_id); 
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                return ['output'=>$out, 'selected'=>$selected_id];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }

    public function actionKamar()
    {
        $dataku = $_POST['dataku'];
        $nim = $dataku['nimku'];
        $kamar = $dataku['kamarku'];
        if (!empty($dataku['nimku'])) {
            if (!empty($dataku['kamarku'])) {
                $data = SimakMastermahasiswa::find()->where([ 'nim_mhs' => $nim ])->one();
                $kamarLama = $data->kamar;
                

                $data2 = new RiwayatKamar;
                $data2->nim = $dataku['nimku'];
                $data2->kamar_id = $dataku['kamarku'];
                $data2->dari_kamar_id = $kamarLama->id;
                $data2->save();

                $data->kamar_id = $kamar;
                if($data->save())
                {
                    $results = [
                        'code' => 200,
                        'msg' => "Perpindahan Berhasil",
                        'kamar' => $data->kamar->nama,
                        'asrama' => $data->kamar->namaAsrama,
                    ];
                }

                else
                {
                    $errors = \app\helpers\MyHelper::logError($data);
                    $results = [
                        'code' => 400,
                        'msg' => $errors,
                        'kamar' => '',
                        'asrama' => '',
                    ];
                }
                
                
                echo json_encode($results);

            }
            else{
                echo "Kamar kosong, Isi terlebih dahulu";
            }
        }
        else {
            echo "Kamar kosong, Isi terlebih dahulu";
        }
        die();
    }

    public function actionPindah()
    {
        $model = new SimakMastermahasiswa;
        $model->setScenario('asrama');
        
        $results = [];
        $params = [];

        if (!empty($_GET['btn-search'])) {
            if(!empty($_GET['SimakMastermahasiswa']))
            {
                $params = $_GET['SimakMastermahasiswa'];
                $query = SimakMastermahasiswa::find()->where([
                    'kampus' => $params['kampus'],
                    'kode_prodi' => !empty($params['kode_prodi']) ?$params['kode_prodi'] : '-',
                    
                    'status_aktivitas' => $params['status_aktivitas']
                ]);

                if(Yii::$app->user->identity->access_role == 'operatorCabang')
                {
                    $query->andWhere(['kampus'=>Yii::$app->user->identity->kampus]);    
                }
                
                $query->orderBy(['semester'=>SORT_ASC,'nama_mahasiswa'=>SORT_ASC]);          
                $results = $query->all();


            }
        }

        return $this->render('pindah',[
            'model' => $model,
            'results' => $results,
            'params' => $params,
        ]);
    } 

    public function actionMahasiswa()
    {
        $model = new SimakMastermahasiswa;
        $model->setScenario('asrama');
        $listAsrama = Asrama::find()->all();
        $results = [];
        $params = [];

        if (!empty($_GET['btn-search'])) {
            if(!empty($_GET['SimakMastermahasiswa']))
            {
                $params = $_GET['SimakMastermahasiswa'];
                $query = SimakMastermahasiswa::find()->where([
                    'kampus' => $params['kampus'],
                    'kode_prodi' => !empty($params['kode_prodi']) ? $params['kode_prodi'] : '-',
                    // 'kode_fakultas' => $params['kode_fakultas'],
                    'status_aktivitas' => $params['status_aktivitas']
                ]);

                if(Yii::$app->user->identity->access_role == 'operatorCabang')
                {
                    $query->andWhere(['kampus'=>Yii::$app->user->identity->kampus]);    
                }

                $query->orderBy(['semester'=>SORT_ASC,'nama_mahasiswa'=>SORT_ASC]);          
                $results = $query->all();

            }
        }

        else if (!empty($_GET['btn-export'])) {
            if(!empty($_GET['SimakMastermahasiswa']))
            {
                $params = $_GET['SimakMastermahasiswa'];
                $query = SimakMastermahasiswa::find()->where([
                    'kampus' => $params['kampus'],
                    'kode_prodi' => !empty($params['kode_prodi']) ? $params['kode_prodi'] : '-',
                    // 'kode_fakultas' => $params['kode_fakultas'],
                    'status_aktivitas' => $params['status_aktivitas']
                ]);

                if(Yii::$app->user->identity->access_role == 'operatorCabang')
                {
                    $query->andWhere(['kampus'=>Yii::$app->user->identity->kampus]);    
                }
                
                $query->orderBy(['semester'=>SORT_ASC,'nama_mahasiswa'=>SORT_ASC]);          
                $results = $query->all();
    

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $sheet
                ->setCellValue('A1', 'No')
                ->setCellValue('B1', 'NIM')
                ->setCellValue('C1', 'Nama Mahasiswa')
                ->setCellValue('D1', 'JK')
                ->setCellValue('E1', 'Semester')
                ->setCellValue('F1', 'Asrama')
                ->setCellValue('G1', 'Kamar');

                $i= 1;
                $ii = 2;

                foreach($results as $row)
                {
                    $sheet->setCellValue('A'.$ii, $i);
                    $sheet->setCellValue('B'.$ii, $row->nim_mhs);
                    $sheet->setCellValue('C'.$ii, $row->nama_mahasiswa);
                    $sheet->setCellValue('D'.$ii, $row->jenis_kelamin);
                    $sheet->setCellValue('E'.$ii, $row->semester);
                    $sheet->setCellValue('F'.$ii, !empty($row->kamar) ? $row->kamar->namaAsrama : 'not set');
                    $sheet->setCellValue('G'.$ii, !empty($row->kamar) ? $row->kamar->nama : 'not set');

                    $i++;
                    $ii++;
                }       

                foreach(range('A','G') as $columnID) {
                    $sheet->getColumnDimension($columnID)
                    ->setAutoSize(true);
                }

                $sheet->setTitle('Rincian Penghuni Kamar');

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Rincian_Penghuni_Kamar.xlsx"');              
                header('Cache-Control: max-age=0');
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
                die();   
            }

        }


        return $this->render('mahasiswa',[
            'model' => $model,
            'results' => $results,
            'params' => $params,
            'listAsrama' => $listAsrama
        ]);
    }

    /**
     * Lists all Asrama models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AsramaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Asrama model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   

        $model = $this->findModel($id);
        $model->scenario = 'sce_upload_file';
        if (Yii::$app->request->isPost) {
            $uploadedFile = UploadedFile::getInstance($model, 'dataKamar');
            $extension =$uploadedFile->extension;
            if($extension=='xlsx'){
                $inputFileType = 'Xlsx';
            }else{
                $inputFileType = 'Xls';
            }

            
            $sheetname =$model->dataKamar;
            $inputFileName = $uploadedFile->tempName;
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
/**  Create a new Reader of the type that has been identified  **/
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

            $reader->setLoadSheetsOnly($sheetname);
            // print_r($sheetname);exit;
            $spreadsheet = $reader->load($uploadedFile->tempName);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
              
            for ($row = 1; $row <= $highestRow; ++$row) 
            { 
                $asrama_id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $nama_kamar = $worksheet->getCellByColumnAndRow(2, $row)->getValue(); // 10 artinya kolom 10
                $kapasitas = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                // print_r($kapasitas);exit;
                $kamar = \app\models\Kamar::find()->where([
                    'nama' => $nama_kamar,
                    'asrama_id' => $asrama_id
                ])->one();

                if(empty($kamar))
                {
                    $kamar = new \app\models\Kamar;
                    $kamar->nama = (string)$nama_kamar;
                    $kamar->asrama_id = $id;
                }

                $kamar->kapasitas = $kapasitas;
                if(!$kamar->save()){
                    print_r($kamar->getErrors());exit;
                }

            }
            // return;
            
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Asrama model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Asrama();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Asrama model.
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
     * Deletes an existing Asrama model.
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
     * Finds the Asrama model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Asrama the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Asrama::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
