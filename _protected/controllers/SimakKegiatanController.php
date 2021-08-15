<?php

namespace app\controllers;

use Yii;
use app\models\SimakKegiatanMahasiswa;
use app\models\SimakKegiatan;
use app\models\SimakKegiatanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SimakKegiatanController implements the CRUD actions for SimakKegiatan model.
 */
class SimakKegiatanController extends Controller
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
                'only' => ['update','index','view','delete','start','bulk-registration'],
                'rules' => [
                    
                    [
                        'actions' => [
                            'update','index','view','start','delete','bulk-registration'
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

    public function actionAjaxGetKegiatan()
    {
        $results = [] ;
        if (Yii::$app->request->isPost) 
        {
            $dataPost = $_POST['dataPost'];
            
            $model = SimakKegiatan::findOne($dataPost['id']);

            if(!empty($model)){
                $results = $model->attributes;
            }

            
            echo json_encode($results);

              
        }

        die();
    }


    public function actionBulkRegistration($id)
    {

        $kegiatan = $this->findModel($id);
        $model = new \app\models\SimakMastermahasiswa;
        
        $results = [];
        $params = [];

        if (!empty($_GET['btn-search'])) {
            if(!empty($_GET['SimakMastermahasiswa']))
            {
                $params = $_GET['SimakMastermahasiswa'];
                $query = \app\models\SimakMastermahasiswa::find()->where([
                    'kampus' => $params['kampus'],
                    'kode_prodi' => !empty($params['kode_prodi']) ?$params['kode_prodi'] : '-',
                    
                    'status_aktivitas' => $params['status_aktivitas']
                ]);

                if(!empty($params['tahun_masuk']))
                {
                    $query->andWhere(['tahun_masuk'=>$params['tahun_masuk']]);
                }

                if(Yii::$app->user->identity->access_role == 'operatorCabang')
                {
                    $query->andWhere(['kampus'=>Yii::$app->user->identity->kampus]);    
                }
                
                $query->orderBy(['semester'=>SORT_ASC,'nama_mahasiswa'=>SORT_ASC]);          
                $results = $query->all();


            }
        }

        return $this->render('bulk_registration',[
            'model' => $model,
            'kegiatan' => $kegiatan,
            'results' => $results,
            'params' => $params,
        ]);
    } 

    public function actionAjaxUnregister()
    {
        $dataPost = $_POST['dataPost'];
        $model = SimakKegiatan::findOne($dataPost['kegiatan_id']);
        $nim = $dataPost['nim'];
        $tahun_akademik = $dataPost['tahun_akademik'];
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        
        $errors = '';
        $results = [];
        
        try 
        {

            
            $mhs = \app\models\SimakMastermahasiswa::find()->where(['nim_mhs'=>$nim])->one();
            if(!empty($model))
            {
                $keg = SimakKegiatanMahasiswa::find()->where([
                    'nim' => $nim,
                    'id_kegiatan' => $model->id,
                    'tahun_akademik' => $tahun_akademik
                ])->one();

                if(!empty($keg))
                {
                    $keg->delete();
                    $results = [
                        'code' => 200,
                        'message' => 'Participant deleted'
                    ];

                    $transaction->commit();
                }
                else
                {
                    $results = [
                        'code' => 404,
                        'message' => 'Participant not found'
                    ];
                }
            }

            else
            {
                $errors .= 'Oops, Kegiatan does not exist';
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

    public function actionAjaxRegister()
    {
        $dataPost = $_POST['dataPost'];
        $model = SimakKegiatan::findOne($dataPost['kegiatan_id']);
        $nim = $dataPost['nim'];
        $tahun_akademik = $dataPost['tahun_akademik'];
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        
        $errors = '';
        $results = [];
        
        try 
        {

            
            $mhs = \app\models\SimakMastermahasiswa::find()->where(['nim_mhs'=>$nim])->one();
            if(!empty($model))
            {
                $keg = SimakKegiatanMahasiswa::find()->where([
                    'nim' => $nim,
                    'id_kegiatan' => $model->id,
                    'tahun_akademik' => $tahun_akademik
                ])->one();

                if(empty($keg))
                {
                    $keg = new SimakKegiatanMahasiswa;
                    $keg->nim =  $nim;
                    $keg->tahun_akademik = $tahun_akademik;
                    $keg->id_kegiatan = $model->id;
                    $keg->id_jenis_kegiatan = $model->id_jenis_kegiatan;
                    $keg->nilai = $model->nilai;
                    $keg->semester = (string)$mhs->semester;
                    $keg->waktu = date('Y-m-d H:i:s');
                    $keg->instansi = 'DKP';
                    $keg->tema = 'DKP';
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
                $errors .= 'Oops, Kegiatan does not exist';
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

    public function actionAjaxListKegiatan()
    {
        $results = [] ;
        if (Yii::$app->request->isPost) 
        {
            $dataPost = $_POST['dataPost'];
            
            $query = SimakKegiatan::find();
            $query->where(['id_jenis_kegiatan'=>$dataPost['id'],'is_active'=>'1']);
            $query->select(['id','CONCAT(nama_kegiatan, " - ",sub_kegiatan, " - [", nilai,"]") as name']);
            $query->orderBy(['nama_kegiatan'=>SORT_ASC]); 
            $results = $query->asArray()->all();
            echo json_encode($results);

              
        }

        die();
    }

    /**
     * Lists all SimakKegiatan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SimakKegiatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimakKegiatan model.
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
     * Creates a new SimakKegiatan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SimakKegiatan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SimakKegiatan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SimakKegiatan model.
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
     * Finds the SimakKegiatan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SimakKegiatan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakKegiatan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
