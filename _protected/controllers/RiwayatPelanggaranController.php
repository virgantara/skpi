<?php

namespace app\controllers;

use Yii;
use app\models\Asrama;
use app\models\RiwayatKamar;
use app\models\RiwayatPelanggaran;
use app\models\RiwayatPelanggaranSearch;
use app\models\SimakMastermahasiswa;
use app\models\SimakKabupaten;
use app\models\IzinMahasiswa;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\httpclient\Client;
use app\models\RiwayatHukuman;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * RiwayatPelanggaranController implements the CRUD actions for RiwayatPelanggaran model.
 */
class RiwayatPelanggaranController extends Controller
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

    public function actionProfil($nim)
    {
        $model = new RiwayatPelanggaran;
        $mahasiswa = [];
        if(!empty($nim))
        {
            $api_baseurl = Yii::$app->params['api_baseurl'];
            $client = new Client(['baseUrl' => $api_baseurl]);
            $response = $client->get('/m/profil/nim', ['nim' => $nim],['x-access-token'=>Yii::$app->params['client_token']])->send();
            
            if ($response->isOk) {
                $mahasiswa = $response->data['values'][0];
            }    
        }

        $query = RiwayatPelanggaran::find()->where([
            'nim'=> $nim
        ]);

        $query->orderBy(['created_at'=>SORT_DESC]);

        $riwayat = $query->all();

        $query = IzinMahasiswa::find()->where([
            'nim'=> $nim
        ]);

        $query->orderBy(['created_at'=>SORT_DESC]);

        $riwayatIzin = $query->all();

            
        return $this->render('profil',[
            'model' => $model,
            'mahasiswa' => $mahasiswa,
            'riwayat' => $riwayat,
            'riwayatIzin' => $riwayatIzin
        ]);
    }

    public function actionCariMahasiswa()
    {

        $model = new RiwayatPelanggaran;
        if($model->load($_POST))
        {
            $this->redirect(['profil','nim'=>$model->nim]);

        }
        
        return $this->render('cariMahasiswa',[
            'model' => $model
        ]);
        
    }

    /**
     * Lists all RiwayatPelanggaran models.
     * @return mixed
     */
    public function actionIndex()
    {
        $asramas = ArrayHelper::map(Asrama::find()->all(),'id','nama');
        $prodis = ArrayHelper::map(\app\models\SimakMasterprogramstudi::find()->all(),'kode_prodi','nama_prodi');
        $fakultas = ArrayHelper::map(\app\models\SimakMasterfakultas::find()->all(),'kode_fakultas','nama_fakultas');

        $status_aktif = ArrayHelper::map(\app\models\SimakPilihan::find()->where(['kode'=>'05'])->all(),'value','label');
        $searchModel = new RiwayatPelanggaranSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'asramas' => $asramas,
            'prodis' => $prodis,
            'fakultas' => $fakultas,
            'status_aktif' =>$status_aktif
        ]);
    }

    /**
     * Displays a single RiwayatPelanggaran model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $mahasiswa = [];
        // if(!empty($model->nim))
        // {
        //     $api_baseurl = Yii::$app->params['api_baseurl'];
        //     $client = new Client(['baseUrl' => $api_baseurl]);
        //     $response = $client->get('/m/profil/nim', ['nim' => $model->nim],['x-access-token'=>Yii::$app->params['client_token']])->send();
            
        //     if ($response->isOk && !empty($response->data['values'])) {
                
        //         $mahasiswa = $response->data['values'][0];
        //     }

        //     else{
        //         $mahasiswa = $model->nim0;
        //     }    
        // }

        $mahasiswa = $model->nim0;
        $kabupaten = SimakKabupaten::findOne(['id' => $mahasiswa->kabupaten]);
        $mahasiswa['kabupaten'] = $kabupaten;

        $query = RiwayatPelanggaran::find()->where([
            'nim'=> $model->nim
        ]);

        $query->orderBy(['created_at'=>SORT_DESC]);

        $riwayat = $query->all();

        $query = RiwayatKamar::find()->where([
            'nim'=> $model->nim
        ]);

        $query->orderBy(['created_at'=>SORT_DESC]);

        $riwayatKamar = $query->all();
            
        return $this->render('view',[
            'model' => $model,
            'mahasiswa' => $mahasiswa,
            'riwayat' => $riwayat,
            'riwayatKamar' => $riwayatKamar
        ]);
    }

    /**
     * Creates a new RiwayatPelanggaran model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($nim)
    {
        $s3config = Yii::$app->params['s3'];
        $s3 = new \Aws\S3\S3Client($s3config);

        $model = new RiwayatPelanggaran();
        $mahasiswa = null;
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $kabupaten = null;
        $client = new Client(['baseUrl' => $api_baseurl]);
        if(!empty($nim))
        {
            $mahasiswa = SimakMastermahasiswa::find()->where(['nim_mhs'=>$nim])->one();  
            $kabupaten = SimakKabupaten::find()->where(['id'=>$mahasiswa->kabupaten])->one();
        }

        $response = $client->get('/tahun/aktif',[],['x-access-token'=>Yii::$app->params['client_token']])->send();
        $tahun_aktif = [];
        if ($response->isOk) {
            $tahun_aktif = $response->data['values'][0];
        }

        $model->tahun_id = $tahun_aktif['tahun_id'];

        $model->nim = $mahasiswa['nim_mhs'] ?: '';
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try 
        {
            if ($model->load(Yii::$app->request->post())) {

                $model->bukti = UploadedFile::getInstance($model,'bukti');
                $model->surat_pernyataan = UploadedFile::getInstance($model,'surat_pernyataan');

                if($model->bukti)
                {
                    $bukti = $model->bukti->tempName;
                    $mime_type = $model->bukti->type;
                    
                    $file = 'B'.$model->id.'.'.$model->bukti->extension;

                    
                    $errors = '';
                            
                    $key = 'pelanggaran/bukti/'.$model->nim.'/'.$file;
                     
                    $insert = $s3->putObject([
                         'Bucket' => 'siakad',
                         'Key'    => $key,
                         'Body'   => 'This is the Body',
                         'SourceFile' => $bukti,
                         'ContentType' => $mime_type
                    ]);

                    
                    $plainUrl = $s3->getObjectUrl('siakad', $key);
                    $model->bukti = $plainUrl;
                }

                if($model->surat_pernyataan)
                {
                    $surat_pernyataan = $model->surat_pernyataan->tempName;
                    $mime_type = $model->surat_pernyataan->type;
                    
                    $file = 'SP'.$model->id.'.'.$model->surat_pernyataan->extension;

                    
                    $errors = '';
                            
                    $key = 'pelanggaran/surat_pernyataan/'.$model->nim.'/'.$file;
                     
                    $insert = $s3->putObject([
                         'Bucket' => 'siakad',
                         'Key'    => $key,
                         'Body'   => 'This is the Body',
                         'SourceFile' => $surat_pernyataan,
                         'ContentType' => $mime_type
                    ]);

                    
                    $plainUrl = $s3->getObjectUrl('siakad', $key);
                    $model->surat_pernyataan = $plainUrl;
                }


                $model->tanggal = \app\helpers\MyHelper::dmYtoYmd($model->tanggal);
                $model->save();

                foreach($_POST['tindakan_id'] as $item)
                {
                    if(empty($item)) continue;

                    $rh = new RiwayatHukuman;
                    $rh->pelanggaran_id = $model->id;
                    $rh->hukuman_id = $item;
                    $rh->save();

                }
                

                $transaction->commit();
                return $this->redirect(['profil', 'nim' => $nim]);
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $this->render('create', [
            'model' => $model,
            'mahasiswa' => $mahasiswa,
            'kabupaten' => $kabupaten
        ]);
    }

    /**
     * Updates an existing RiwayatPelanggaran model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $bukti = $model->bukti;
        $surat_pernyataan = $model->surat_pernyataan;
        $s3config = Yii::$app->params['s3'];
        $s3 = new \Aws\S3\S3Client($s3config);

        $mahasiswa = SimakMastermahasiswa::find()->where(['nim_mhs'=>$model->nim])->one();  
        $kabupaten = SimakKabupaten::find()->where(['id'=>$mahasiswa->kabupaten])->one();
        

        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try 
        {
            if ($model->load(Yii::$app->request->post())) 
            {

                $model->bukti = UploadedFile::getInstance($model,'bukti');
                $model->surat_pernyataan = UploadedFile::getInstance($model,'surat_pernyataan');

                if($model->bukti)
                {
                    $bukti = $model->bukti->tempName;
                    $mime_type = $model->bukti->type;
                    
                    $file = 'B'.$model->id.'.'.$model->bukti->extension;

                    
                    $errors = '';
                            
                    $key = 'pelanggaran/bukti/'.$model->nim.'/'.$file;
                     
                    $insert = $s3->putObject([
                         'Bucket' => 'siakad',
                         'Key'    => $key,
                         'Body'   => 'This is the Body',
                         'SourceFile' => $bukti,
                         'ContentType' => $mime_type
                    ]);

                    
                    $plainUrl = $s3->getObjectUrl('siakad', $key);
                    $model->bukti = $plainUrl;
                }

                if (empty($model->bukti)){
                    $model->bukti = $bukti;
                }

                if($model->surat_pernyataan)
                {
                    $surat_pernyataan = $model->surat_pernyataan->tempName;
                    $mime_type = $model->surat_pernyataan->type;
                    
                    $file = 'SP'.$model->id.'.'.$model->surat_pernyataan->extension;

                    
                    $errors = '';
                            
                    $key = 'pelanggaran/surat_pernyataan/'.$model->nim.'/'.$file;
                     
                    $insert = $s3->putObject([
                         'Bucket' => 'siakad',
                         'Key'    => $key,
                         'Body'   => 'This is the Body',
                         'SourceFile' => $surat_pernyataan,
                         'ContentType' => $mime_type
                    ]);

                    
                    $plainUrl = $s3->getObjectUrl('siakad', $key);
                    $model->surat_pernyataan = $plainUrl;
                }

                if (empty($model->surat_pernyataan)){
                    $model->surat_pernyataan = $surat_pernyataan;
                }

                $model->tanggal = \app\helpers\MyHelper::dmYtoYmd($model->tanggal);
                $model->save();

                foreach ($model->riwayatHukumen as $key => $value) 
                {
                    $value->delete();
                }     
                
                foreach($_POST['tindakan_id'] as $item)
                {
                    if(empty($item)) continue;

                    $rh = new RiwayatHukuman;
                    $rh->pelanggaran_id = $model->id;
                    $rh->hukuman_id = $item;
                    $rh->save();

                }
                
                
                Yii::$app->session->setFlash("success","Data successfully saved");
                $transaction->commit();
                return $this->redirect(['profil', 'nim' => $model->nim]);
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $this->render('update', [
            'model' => $model,
            'mahasiswa' => $mahasiswa,
            'kabupaten' => $kabupaten
        ]);
    }

    /**
     * Deletes an existing RiwayatPelanggaran model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        foreach ($model->riwayatHukumen as $key => $value) 
        {
            $value->delete();
        }    

        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionDownloadSuratPernyataan($id)
    {
        $model = $this->findModel($id);
        $file = $model->surat_pernyataan;
        if(empty($model->surat_pernyataan)){
            Yii::$app->session->setFlash('danger', 'Mohon maaf, file ini tidak ada');
            return $this->redirect(['index']);
        }
        $filename = 'SP'.$model->nim.' - '.$model->nim0->nama_mahasiswa.'.pdf';

        // Header content type
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
          
        // Read the file
        @readfile($file);
        exit;
    }

    public function actionDownloadBukti($id){
        $model = RiwayatPelanggaran::findOne($id);
        if(!empty($model->bukti)){
            try{
                $image = imagecreatefromstring($this->getImage($model->bukti));

                header('Content-Type: image/png');
                imagepng($image);
            }

            catch(\Exception $e){
                   
            }
                
        }
        

        die();
    }

    function getImage($url){
        $ch = curl_init ($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $resource = curl_exec($ch);
        curl_close ($ch);

        return $resource;
    }

    /**
     * Finds the RiwayatPelanggaran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RiwayatPelanggaran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RiwayatPelanggaran::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
