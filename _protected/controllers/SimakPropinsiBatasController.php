<?php

namespace app\controllers;

use app\models\SimakPropinsi;
use app\models\SimakPropinsiBatas;
use app\models\SimakPropinsiBatasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SimakPropinsiBatasController implements the CRUD actions for SimakPropinsiBatas model.
 */
class SimakPropinsiBatasController extends Controller
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

    public function actionAjaxListBatas()
    {
        $tmp_name = \Yii::getAlias('@app').'/indogeo.json';
        $string = file_get_contents($tmp_name);
        $json_a = json_decode($string, true);
        $results['type'] = 'FeatureCollection';
        $results['features'] = [];
        
        foreach($json_a['features'] as $feature)
        {
            $feat = $feature;
            $p = SimakPropinsi::find()->where(['id'=>$feature['properties']['kode']])->one();
            if(!empty($p))
            {

                $feat['properties']['density'] = count($p->simakMastermahasiswas);
                
            }

            $results['features'][] = $feat;
            
        }
     

        // echo '<pre>';
        // print_r($results);
        // echo '</pre>';
        // exit;
        // echo header('Content-Type:application/json');
        echo json_encode($results);
        exit;
    }

    /**
     * Lists all SimakPropinsiBatas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SimakPropinsiBatasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimakPropinsiBatas model.
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
     * Creates a new SimakPropinsiBatas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SimakPropinsiBatas();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SimakPropinsiBatas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SimakPropinsiBatas model.
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
     * Finds the SimakPropinsiBatas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SimakPropinsiBatas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimakPropinsiBatas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
