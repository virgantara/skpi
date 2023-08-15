<?php

namespace app\controllers;

use app\models\SimkatmawaBelmawa;
use app\models\SimkatmawaBelmawaSearch;
use app\models\SimkatmawaMahasiswa;
use DateTime;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SimkatmawaController implements the CRUD actions for SimkatmawaBelmawa model.
 */
class SimkatmawaController extends Controller
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

    public function actionIndex()
    {
        $searchModel = new SimkatmawaBelmawaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new SimkatmawaBelmawa();

        $dataPost   = $_POST;
        if (!empty($dataPost)) {
            $insert = $this->insertSimkatmawa($dataPost, 'belmawa');

            if ($insert->id) {
                Yii::$app->session->setFlash('success', "Data tersimpan");
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('danger', $insert);
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

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
     * Deletes an existing SimkatmawaBelmawa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete() && SimkatmawaMahasiswa::deleteAll(['simkatmawa_belmawa_id' => $id])) {
            Yii::$app->session->setFlash('success', "Data Berhasil Dihapus");
            return $this->redirect(['index']);
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the SimkatmawaBelmawa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SimkatmawaBelmawa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimkatmawaBelmawa::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
