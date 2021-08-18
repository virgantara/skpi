<?php

namespace app\controllers;
use Yii;

use app\models\SimakKegiatanHarianKategori;
use app\models\SimakKegiatanHarianMahasiswa;
use app\models\SimakTahunakademik;
use app\models\SimakKegiatanHarian;
use app\models\SimakKegiatanHarianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SimakKegiatanHarianController implements the CRUD actions for SimakKegiatanHarian model.
 */
class SimakKegiatanHarianController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'denyCallback' => function ($rule, $action) {
                        throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page');
                    },
                    'only' => ['create','update','index','view','delete','rekap'],
                    'rules' => [
                        
                        [
                            'actions' => [
                                'index','view','rekap'
                            ],
                            'allow' => true,
                            'roles' => ['operatorCabang','event'],
                        ],
                        [
                            'actions' => [
                                'index','view','update','delete','create',
                            ],
                            'allow' => true,
                            'roles' => ['theCreator','admin'],
                        ],
                        
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionRekap()
    {

        $results = [];

        $list_kategori = SimakKegiatanHarianKategori::find()->all();
        $list_kampus = [];
        if(!empty($_GET['btn-search']))
        {
            $sd = date('Y-m-d 00:00:00');
            $ed = date('Y-m-d 23:59:59');
            if(!empty($_GET['tanggal']))
            {
                $tgl = explode(" hingga ",$_GET['tanggal']);
                $sd = $tgl[0].' 00:00:00';
                $ed = $tgl[1].' 23:59:59';    
            }
            
            $query = new \yii\db\Query();
            $tmp = $query->select(['kam.nama_kampus','kam.kode_kampus', 'COUNT(*) as total'])
            ->from('simak_mastermahasiswa mas')
            ->innerJoin('simak_kampus kam', 'kam.kode_kampus = mas.kampus')
            ->where(['mas.status_aktivitas' => 'A','mas.kampus' => 1]) # siman
            ->groupBy(['kam.nama_kampus','kam.kode_kampus'])
            ->all();

            foreach($tmp as $t)
                $list_kampus[$t['kode_kampus']] = $t['total'];

            $kat = $_GET['jenis_kegiatan'];
            $query = new \yii\db\Query();
            $results = $query->select(['COUNT(*) as total','kk.nama_kegiatan','kam.nama_kampus','kk.sub_kegiatan','kam.kode_kampus','DATE(m.created_at) as tgl'])
            ->from('simak_kegiatan_harian_mahasiswa m')
            ->innerJoin('simak_kegiatan_harian h', 'm.kode_kegiatan = h.kode')
            ->innerJoin('simak_mastermahasiswa mas', 'mas.nim_mhs = m.nim')
            ->innerJoin('simak_kampus kam', 'kam.kode_kampus = mas.kampus')
            ->innerJoin('simak_kegiatan_harian_kategori k', 'k.kode = h.kategori')
            ->innerJoin('simak_kegiatan kk', 'kk.id = h.kegiatan_id')
            ->where(['k.kode' => $kat])
            ->andWhere(['BETWEEN','m.created_at',$sd, $ed])
            ->groupBy(['kk.nama_kegiatan','kk.sub_kegiatan','kam.nama_kampus','kam.kode_kampus','DATE(m.created_at)'])
            ->orderBy('tgl ASC')
          
            ->all();
        }

        return $this->render('rekap',[
            'results' => $results,
            'list_kategori' => $list_kategori,
            'list_kampus' => $list_kampus
        ]);
    }


    /**
     * Lists all SimakKegiatanHarian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SimakKegiatanHarianSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $listTahun = SimakTahunakademik::find()->select(['tahun_id','nama_tahun'])->orderBy(['tahun_id' => SORT_DESC])->limit(14)->all();
        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $id = Yii::$app->request->post('editableKey');
            $model = SimakKegiatanHarian::findOne($id);

            // store a default json response as desired by editable
            $out = json_encode(['output'=>'', 'message'=>'']);

            
            $posted = current($_POST['SimakKegiatanHarian']);
            $post = ['SimakKegiatanHarian' => $posted];

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
            'listTahun' => $listTahun
        ]);
    }

    /**
     * Displays a single SimakKegiatanHarian model.
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

    /**
     * Creates a new SimakKegiatanHarian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $listTahun = SimakTahunakademik::find()->select(['tahun_id','nama_tahun'])->orderBy(['tahun_id' => SORT_DESC])->limit(14)->all();
        $model = new SimakKegiatanHarian();
        $model->id = \app\helpers\MyHelper::gen_uuid();
        $model->kode = 'HR'.date('YmdHis').rand(0, 100);

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'listTahun' => $listTahun
        ]);
    }

    /**
     * Updates an existing SimakKegiatanHarian model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $listTahun = SimakTahunakademik::find()->select(['tahun_id','nama_tahun'])->orderBy(['tahun_id' => SORT_DESC])->limit(14)->all();
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'listTahun'=>$listTahun
        ]);
    }

    /**
     * Deletes an existing SimakKegiatanHarian model.
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
     * Finds the SimakKegiatanHarian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SimakKegiatanHarian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakKegiatanHarian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}