<?php

namespace app\controllers;

use app\models\SimakMasterprogramstudi;
use app\models\User;
use app\models\UserProdi;
use app\models\UserProdiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserProdiController implements the CRUD actions for UserProdi model.
 */
class UserProdiController extends Controller
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
     * Lists all UserProdi models.
     *
     * @return string
     */
    public function actionIndex()
    {

        $listProdi = SimakMasterprogramstudi::find()->all();
        $listUser = User::find()
            ->where(['access_role' => 'operatorUnit'])
            ->andWhere(['like', 'username', 'prodi'])
            ->all();

        return $this->render('index', [
            'listProdi' => $listProdi,
            'listUser' => $listUser,
        ]);
    }

    /**
     * Displays a single UserProdi model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserProdi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new UserProdi();

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
     * Updates an existing UserProdi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
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
     * Deletes an existing UserProdi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionAjaxUserProdi()
    {
        $results = [];
        $dataPost = $_POST['dataPost'];

        $relation = UserProdi::find()->where([
            'user_id' => $dataPost['user_id'],
        ])->one();

        #check data
        if (!empty($relation)) {
            $relation->attributes = $dataPost;
            if ($relation->save()) {
                $results = [
                    'code' => 200,
                    'message' => 'Data berhasil di update'
                ];
            }
        } else {
            $relation = new UserProdi();
            $relation->attributes = $dataPost;
            if ($relation->save()) {
                $results = [
                    'code' => 200,
                    'message' => 'Data berhasil di tambahkan'
                ];
            } else {
                $error = \app\helpers\MyHelper::logError($relation);
                $results = [
                    'code' => 500,
                    'message' => $error
                ];
            }
        }

        echo json_encode($results);

        exit;
    }

    /**
     * Finds the UserProdi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UserProdi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserProdi::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
