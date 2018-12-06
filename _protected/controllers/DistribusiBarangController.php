<?php

namespace app\controllers;

use Yii;
use app\models\DistribusiBarang;
use app\models\DistribusiBarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;



use yii\data\ActiveDataProvider;


/**
 * DistribusiBarangController implements the CRUD actions for DistribusiBarang model.
 */
class DistribusiBarangController extends Controller
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

    public function actionApprove($id,$kode)
    {
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try 
        {
            $model = $this->findModel($id);
            $model->is_approved = $kode;

            $model->save();

            // \app\models\RequestOrder::updateStok($id);

            if($kode==1)
            {

                $deptTujuan = $model->departemen_id;
                foreach($model->distribusiBarangItems as $item)
                {


                    $stokCabang = \app\models\DepartemenStok::find()->where(
                        [
                            'barang_id'=> $item->stok->id_barang,
                            'departemen_id' => $deptTujuan
                        ]
                    )->one();
                    if(empty($stokCabang)){
                        $stokCabang = new \app\models\DepartemenStok;
                        $stokCabang->barang_id = $item->stok->id_barang;
                        $stokCabang->departemen_id = $deptTujuan;
                        $stokCabang->stok_awal = $item->qty;
                        $stokCabang->stok_akhir = $item->qty;
                        $stokCabang->tanggal = $model->tanggal;
                        $stokCabang->stok_bulan_lalu = 0;
                        $stokCabang->stok = $item->qty;
                        $stokCabang->ro_item_id = $item->id;
                        $stokCabang->exp_date = $item->stok->exp_date;
                        $stokCabang->batch_no = $item->stok->batch_no;
                        $tahun = date("Y",strtotime($stokCabang->tanggal));
                        $bulan = date("m",strtotime($stokCabang->tanggal));
                        $stokCabang->bulan = $bulan;
                        $stokCabang->tahun = $tahun;
                        $stokCabang->save();
                        
                    }

                    else
                    {

                        $datestring=$model->tanggal.' first day of last month';
                        $dt=date_create($datestring);
                        $lastMonth = $dt->format('m'); //2011-02
                        $lastYear = $dt->format('Y');
                        $stokLalu = \app\models\DepartemenStok::find()->where(
                        [
                            'barang_id'=> $item->item_id,
                            'departemen_id' => $deptTujuan,
                            'bulan' => $lastMonth,
                            'tahun' => $lastYear
                        ])->one();
                        $stokCabang->barang_id = $item->stok->id_barang;
                        $stokCabang->departemen_id = $deptTujuan;
                        $stokCabang->stok_awal = $stokCabang->stok + $item->qty;
                        $stokCabang->stok_akhir = $stokCabang->stok + $item->qty;
                        $stokCabang->tanggal = $item->ro->tanggal_penyetujuan;
                        $stokCabang->stok_bulan_lalu = !empty($stokLalu) ? $stokLalu->stok : 0;
                        $stokCabang->stok = $stokCabang->stok + $item->qty;
                        $stokCabang->exp_date = $item->stok->exp_date;
                        $stokCabang->batch_no = $item->stok->batch_no;
                        $stokCabang->save();    
                    }

                   
                }
            }

            $transaction->commit();
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['view','id'=>$id]);
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Lists all DistribusiBarang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DistribusiBarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DistribusiBarang model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = $model->getDistribusiBarangItems();

        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel,
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new DistribusiBarang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DistribusiBarang();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DistribusiBarang model.
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
     * Deletes an existing DistribusiBarang model.
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
     * Finds the DistribusiBarang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DistribusiBarang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DistribusiBarang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}