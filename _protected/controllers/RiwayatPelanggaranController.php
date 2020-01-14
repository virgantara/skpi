<?php

namespace app\controllers;

use Yii;
use app\models\RiwayatPelanggaran;
use app\models\RiwayatPelanggaranSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\httpclient\Client;
use app\models\RiwayatHukuman;

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
            $response = $client->get('/m/profil/nim', ['nim' => $nim])->send();
            
            if ($response->isOk) {
                $mahasiswa = $response->data['values'][0];
            }    
        }

        $query = RiwayatPelanggaran::find()->where([
            'nim'=> $nim
        ]);

        $query->orderBy(['created_at'=>SORT_DESC]);

        $riwayat = $query->all();
            
        return $this->render('profil',[
            'model' => $model,
            'mahasiswa' => $mahasiswa,
            'riwayat' => $riwayat
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
        $searchModel = new RiwayatPelanggaranSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        if(!empty($model->nim))
        {
            $api_baseurl = Yii::$app->params['api_baseurl'];
            $client = new Client(['baseUrl' => $api_baseurl]);
            $response = $client->get('/m/profil/nim', ['nim' => $model->nim])->send();
            
            if ($response->isOk) {
                $mahasiswa = $response->data['values'][0];
            }    
        }

        $query = RiwayatPelanggaran::find()->where([
            'nim'=> $model->nim
        ]);

        $query->orderBy(['created_at'=>SORT_DESC]);

        $riwayat = $query->all();
            
        return $this->render('view',[
            'model' => $model,
            'mahasiswa' => $mahasiswa,
            'riwayat' => $riwayat
        ]);
    }

    /**
     * Creates a new RiwayatPelanggaran model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($nim)
    {
        $model = new RiwayatPelanggaran();
        $mahasiswa = [];
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        if(!empty($nim))
        {
        
            $response = $client->get('/m/profil/nim', ['nim' => $nim])->send();
            
            if ($response->isOk) {
                $mahasiswa = $response->data['values'][0];
            }    
        }

        $response = $client->get('/tahun/aktif')->send();
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
            if ($model->load(Yii::$app->request->post())) 
            {
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

       

        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try 
        {
            if ($model->load(Yii::$app->request->post())) 
            {
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

        return $this->redirect(['cariMahasiswa']);
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
