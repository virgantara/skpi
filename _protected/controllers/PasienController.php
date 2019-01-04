<?php

namespace app\controllers;

use Yii;

use app\models\Pasien;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\helpers\MyHelper;


/**
 * PenjualanController implements the CRUD actions for Penjualan model.
 */
class PasienController extends Controller
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

    public function actionAjaxPasien($q = null) {

        // $list = Pasien::find()->addFilterWhere(['like',])
        $query = new \yii\db\Query;
        $result = Yii::$app->dbSimrs->createCommand((new \yii\db\Query)
            ->select('*')
            ->from('a_pasien')
            ->where('(NAMA LIKE "%' . $q .'%" OR NoMedrec LIKE "%' . $q .'%")')
            ->orderBy('NAMA')
            ->limit(20)
        )->queryAll();
        // $query->select('NoMedrec, NAMA')
        //     ->from('a_pasien')
        //     ->where('(NAMA LIKE "%' . $q .'%" OR NoMedrec LIKE "%' . $q .'%")')
        //     ->orderBy('NAMA')
        //     // ->groupBy(['kode'])
        //     ->limit(20);
        // $command = $query->createCommand();
        // $data = $command->queryAll();
        $out = [];
        foreach ($result as $d) {
            $out[] = [
                'id' => $d['NoMedrec'],
                'label'=> $d['NAMA']
            ];
        }
        echo \yii\helpers\Json::encode($out);

      
    }
    /**
     * Lists all Penjualan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PenjualanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Penjualan model.
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
     * Creates a new Penjualan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Penjualan();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Penjualan model.
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
     * Deletes an existing Penjualan model.
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
     * Finds the Penjualan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Penjualan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Penjualan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}