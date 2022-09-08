<?php

namespace app\controllers;

use Yii;
use app\models\States;
use app\models\Countries;
use app\models\Cities;
use app\models\CitiesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CitiesController implements the CRUD actions for Cities model.
 */
class CitiesController extends Controller
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

    public function actionAjaxGetKota(){
        $cid = $_POST['cid'];

        $results = [];

        $kota = Cities::findOne($cid);

        if(!empty($kota))
        {


            $results = [
                'id' => $kota->id,
                'name' => $kota->name,
                'lat' => $kota->latitude,
                'lng' => $kota->longitude
            ];  
        }

        echo json_encode($results);
        exit;
    }

    public function actionAjaxListKota(){
        $nama_kota = $_POST['nama_kota'];

        $results = [];

        $list_kota = Cities::find()->where(['country_code' => 'ID'])->andFilterWhere(['like','name',$nama_kota])->orderBy(['id'=>SORT_ASC])->all();

        foreach($list_kota as $kota)
        {
            $results[] = [
                'id' => $kota->id,
                'name' => $kota->name.' - '.$kota->state->name,
                'lat' => $kota->latitude,
                'lng' => $kota->longitude,
            ];  
        }

        echo json_encode($results);
        exit;
    }

    private function getCitiesList($id){
        $list = Cities::find()->where(['state_id'=>$id])->orderBy('name')->all();
        $result = [];
        foreach($list as $item)
        {
            $result[] = [
                'id' => $item->id,
                'name' => $item->name
            ];
        }

        return $result;
    }

    public function actionCitiesList() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $state_id = $_POST['sid'];
        $out = self::getCitiesList($state_id); 
        return $out;
    }

    /**
     * Lists all Cities models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CitiesSearch();
        // $searchModel->state_id =
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single Cities model.
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
     * Creates a new Cities model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cities();

        if ($model->load(Yii::$app->request->post())) {

            $state = States::findOne($model->state_id);
            $country = Countries::findOne($model->country_id);
            $model->state_code = $state->iso2;
            $model->country_code = $country->iso2;
            if($model->validate())
            {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cities model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $state = States::findOne($model->state_id);
            $country = Countries::findOne($model->country_id);
            $model->state_code = $state->iso2;
            $model->country_code = $country->iso2;
            if($model->validate())
            {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cities model.
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
     * Finds the Cities model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cities the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cities::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
