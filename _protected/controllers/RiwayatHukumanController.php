<?php

namespace app\controllers;

use Yii;
use app\models\KategoriHukuman;
use app\models\RiwayatHukuman;
use app\models\RiwayatPelanggaran;
use app\models\RiwayatHukumanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RiwayatHukumanController implements the CRUD actions for RiwayatHukuman model.
 */
class RiwayatHukumanController extends Controller
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

    public function actionAjaxRemove()
    {

        $results = [];

        $errors = '';
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        
        try 
        {
            $dataPost = $_POST['dataPost'];
            // $jadwal = \app\models\SimakJadwal::findOne($dataPost['jadwal_id']);

            $model = SimakJadwalPengajar::findOne($dataPost['kelas_id']);
            
            if(!empty($model)){
                $key = $model->id_aktivitas_mengajar;

                refresh:
                $token = MyHelper::getFeederToken();
                $act_feeder = FeederHelper::deleteDeleteDosenPengajarKelasKuliah($key);

                if($act_feeder['code'] == 200) {
                    if($model->delete()) {
                        $transaction->commit();
                        $results = [
                            'code' => '200',
                            'message' => 'Data Dosen Pengajar telah dihapus dari FEEDER'
                        ];
                    }   

                    else
                    {
                        $errors .= MyHelper::logError($model);
                        throw new \Exception;
                    }
                }

                else if($act_feeder['code'] == 500) {
                    if($model->delete()) {
                        $transaction->commit();
                        $results = [
                            'code' => '200',
                            'message' => 'Data Dosen Pengajar tidak ditemukan di FEEDER tapi telah dihapus dari SIAKAD'
                        ];
                    }   

                    else
                    {
                        $errors .= MyHelper::logError($model);
                        throw new \Exception;
                    }
                    
                }

                else if($act_feeder['code'] == 0 || $act_feeder['code'] == 112) {
                    throw new \Exception('ACT_PENGAJAR: '.$act_feeder['code'].' '.$act_feeder['message']);
                    
                }

                else if($act_feeder['code'] == 100) {
                    goto refresh;
                }


                else {
                    throw new \Exception($act_feeder['code'].' '.$act_feeder['message']);
                }
               
            }
        } 

        catch (\Exception $e) {
            $transaction->rollBack();
            $errors .= $e->getMessage();
            $results = [
                'code' => 500,
                'message' => $errors
            ];
            
            
        } catch (\Throwable $e) {
            $transaction->rollBack();
            $errors .= $e->getMessage();
            $results = [
                'code' => 500,
                'message' => $errors
            ];
            
        }
        echo json_encode($results);
        exit;
    }

    public function actionAjaxAdd()
    {

        $results = [];

        $errors = '';
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        
        try 
        {
            $dataPost = $_POST;
            $model = new RiwayatHukuman();
            $model->attributes = $dataPost;
            
            if(!$model->save())
            {
                $errors .= MyHelper::logError($model);
                throw new \Exception;
            }

            $transaction->commit();
            $results = [
                'code' => 200,
                'message' => 'Data successfully added'
            ];
        } 

        catch (\Exception $e) {
            $transaction->rollBack();
            $errors .= $e->getMessage();
            $results = [
                'code' => 500,
                'message' => $errors
            ];
            
            
        } catch (\Throwable $e) {
            $transaction->rollBack();
            $errors .= $e->getMessage();
            $results = [
                'code' => 500,
                'message' => $errors
            ];
            
        }
        echo json_encode($results);
        exit;
    }

    /**
     * Lists all RiwayatHukuman models.
     * @return mixed
     */
    public function actionIndex($pelanggaran_id)
    {
        $list_kategori = KategoriHukuman::find()->all();
        $searchModel = new RiwayatHukumanSearch();
        $searchModel->pelanggaran_id = $pelanggaran_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $riwayatPelanggaran = RiwayatPelanggaran::findOne($pelanggaran_id);
        return $this->render('index', [
            'riwayatPelanggaran' => $riwayatPelanggaran,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'list_kategori' => $list_kategori
        ]);
    }

    /**
     * Displays a single RiwayatHukuman model.
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
     * Creates a new RiwayatHukuman model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RiwayatHukuman();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RiwayatHukuman model.
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
     * Deletes an existing RiwayatHukuman model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the RiwayatHukuman model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RiwayatHukuman the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RiwayatHukuman::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
