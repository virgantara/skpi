<?php

namespace app\controllers;

use Yii;
use app\models\IzinHarian;
use app\models\IzinHarianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Asrama;

/**
 * IzinHarianController implements the CRUD actions for IzinHarian model.
 */
class IzinHarianController extends Controller
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

    public function actionToday()
    {   
        
        $label = 'Hari ini ';
        $query = IzinHarian::find();
        $query->select(['nim']);
        $query->where(['between','waktu',date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')]);
        $query->groupBy(['nim']);
        $list_mhs = $query->all();

        foreach($list_mhs as $mhs)
        {   
            $qry = IzinHarian::find()->where([
                'nim' => $mhs->nim,
            ]);
            $qry->select(['waktu']);
            $qry->andWhere(['between','waktu',date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')]);
            $keluar = $qry->andWhere(['status_izin'=>2])->orderBy(['waktu'=>SORT_ASC])->one();

            $qry = IzinHarian::find()->where([
                'nim' => $mhs->nim,
            ]);
            $qry->select(['waktu']);
            $qry->andWhere(['between','waktu',date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')]);
            $masuk = $qry->andWhere(['status_izin'=>1])->orderBy(['waktu'=>SORT_ASC])->one();

            $results[] = [
                'mhs' => $mhs,
                'keluar' => $keluar->waktu,
                'masuk' => $masuk->waktu
            ];
        }

        return $this->render('today', [
            'label' => $label,
            'results' => $results,
        ]);
    }

    /**
     * Lists all IzinHarian models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $asramas = ArrayHelper::map(Asrama::find()->all(),'id','nama');
        $prodis = ArrayHelper::map(\app\models\SimakMasterprogramstudi::find()->all(),'kode_prodi','nama_prodi');
        $searchModel = new IzinHarianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $label = 'Riwayat Izin Harian ';
        
        return $this->render('index', [
            'label' => $label,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'asramas' => $asramas,
            'prodis' => $prodis
        ]);
    }

    /**
     * Displays a single IzinHarian model.
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
     * Creates a new IzinHarian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new IzinHarian();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing IzinHarian model.
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
     * Deletes an existing IzinHarian model.
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
     * Finds the IzinHarian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return IzinHarian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IzinHarian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
