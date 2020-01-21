<?php

namespace app\controllers;

use Yii;
use app\models\Asrama;
use app\models\AsramaSearch;

use app\models\SimakMastermahasiswa;
use app\models\SimakMasterprogramstudi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


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
                $cat_id = $parents['fakultas_id'];
                $selected_id = $parents['selected_id'];
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

    public function actionMahasiswa()
    {
        $model = new SimakMastermahasiswa;
        $model->setScenario('asrama');
        $listAsrama = Asrama::find()->all();
        $results = [];
        if($model->load(Yii::$app->request->post()))
        {
            
            $results = SimakMastermahasiswa::find()->where([
                'kampus' => $model->kampus,
                'kode_prodi' => $model->kode_prodi,
                'kode_fakultas' => $model->kode_fakultas,
                'status_aktivitas' => 'A'
            ])->all();          
            if(!empty($_POST['btn-submit']))
            {
                foreach($results as $item)
                {
                    if(!empty($_POST['kamar_id_'.$item->nim_mhs]))
                    {
                        $item->kamar_id = $_POST['kamar_id_'.$item->nim_mhs];
                        $item->save(false,['kamar_id']);

                    }
                }
            }
        }


        return $this->render('mahasiswa',[
            'model' => $model,
            'results' => $results,
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
