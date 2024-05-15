<?php

namespace app\controllers;

use Yii;
use app\helpers\MyHelper;
use app\models\SimakPrestasi;
use app\models\SimakKegiatanMahasiswa;
use app\models\SimakKegiatan;
use app\models\SimakPrestasiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PrestasiController implements the CRUD actions for SimakPrestasi model.
 */
class PrestasiController extends Controller
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
                'only' => ['create','update','delete','index','view','klaim-multiple','validasi','ajax-get'],
                'rules' => [
                    [
                        'actions' => ['delete','index','validasi','view','ajax-get'],
                        'allow' => true,
                        'roles' => ['akpamPusat','admin','sekretearis','fakultas'],
                    ],
                    [
                        'actions' => ['create','update','delete','index','view','klaim-multiple','ajax-get'],
                        'allow' => true,
                        'roles' => ['Mahasiswa'],
                    ],
                    [
                        'actions' => [
                            'create','update','delete','index','view','ajax-get'
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

    public function actionAjaxGet()
    {
        $results = [
            'code' => 406,
            'message' => 'Bad Request'
        ] ;
        if (Yii::$app->request->isPost && !empty($_POST['dataPost']) && !empty($_POST['dataPost']['nim'])) 
        {
            $nim = $_POST['dataPost']['nim'];
            
            $list = SimakPrestasi::find()->where(['nim'=> $nim,'status_validasi' => '1'])->all();
            $items = [];
            foreach($list as $data){
                $label = '';
                if(!empty($data->kegiatan) && !empty($data->kegiatan->kegiatan)){

                    $label .= $data->kegiatan->tema.' - '.$data->kegiatan->kegiatan->nama_kegiatan.' - '.$data->kegiatan->instansi;

                    if(!empty($data->kegiatan->jenisKegiatan))
                        $label .= ' - '.$data->kegiatan->jenisKegiatan->nama_jenis_kegiatan;
                }
                $items[] = [
                    'nama' => $label,
                    'id' => $data->id
                ]; 
            }

            $results = [
                'code' => 200,
                'message' => 'Success',
                'items' => $items
            ];
            
        }

        echo json_encode($results);
        die();
            
    }

    public function actionValidasi($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post())) {

            $model->approved_by = Yii::$app->user->identity->id;
            if($model->save()){
                Yii::$app->session->setFlash('success', "Data updated");
                return $this->redirect(['view', 'id' => $model->id]);    
            }        
            
        }

        return $this->render('validasi', [
            'model' => $model,
        ]);
    }

    public function actionKlaimMultiple()
    {
        $dataPost = $_POST['dataPost'];
        $errors = '';
        $results = [];
        if (!empty($dataPost['keys'])) {
            $connection = \Yii::$app->db;
            $counter = 0;
            $transaction = $connection->beginTransaction();
            try {
                foreach ($dataPost['keys'] as $id) {
                    $model = SimakKegiatanMahasiswa::findOne($id);
                    if (!empty($model)) {
                        $prestasi = SimakPrestasi::findOne(['kegiatan_id' => $id,'nim' => Yii::$app->user->identity->nim]);

                        if(empty($prestasi)){
                            $prestasi = new SimakPrestasi;
                            $prestasi->id = MyHelper::gen_uuid();
                        }

                        $prestasi->nim = Yii::$app->user->identity->nim;
                        $prestasi->kegiatan_id = $id;
                        if($prestasi->save())
                            $counter++;
                        else
                            throw new \Exception(MyHelper::logError($prestasi));


                        // else{
                        //     
                        // }
                    }
                }

                $transaction->commit();

                $results = [
                    'code' => 200,
                    'message' => $counter.' data successfully claimed'
                ];
            } catch (\Exception $e) {
                $errors .= $e->getMessage();
                $transaction->rollBack();
                $results = [
                    'code' => 500,
                    'message' => $errors
                ];
            }
        }

        echo json_encode($results);
        die();
    }

    /**
     * Lists all SimakPrestasi models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest)
            return $this->redirect(['site/logout']);

        $searchModel = new SimakPrestasiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        
        ]);
    }

    /**
     * Displays a single SimakPrestasi model.
     * @param string $id ID
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
     * Creates a new SimakPrestasi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SimakPrestasi();
        $model->id = MyHelper::gen_uuid();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SimakPrestasi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
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
     * Deletes an existing SimakPrestasi model.
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
     * Finds the SimakPrestasi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return SimakPrestasi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakPrestasi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
