<?php

namespace app\controllers;
use Yii;
use app\models\SimakTahunakademik;
use app\models\SimakKegiatanHarian;
use app\models\SimakKegiatanHarianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


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
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
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
