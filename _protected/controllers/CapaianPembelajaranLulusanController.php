<?php

namespace app\controllers;

use Yii;
use app\models\CapaianPembelajaranLulusan;
use app\models\CapaianPembelajaranLulusanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CapaianPembelajaranLulusanController implements the CRUD actions for CapaianPembelajaranLulusan model.
 */
class CapaianPembelajaranLulusanController extends Controller
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
                'only' => ['create','update','delete'],
                'rules' => [
                    [
                        'actions' => ['create','update','delete'],
                        'allow' => true,
                        'roles' => ['akpamPusat','admin'],
                    ],
                    [
                        'actions' => [
                            'create','update','delete','index','view'
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
        if (Yii::$app->request->isPost && !empty($_POST['dataPost']) && !empty($_POST['dataPost']['kode_prodi'])) 
        {
            $kode_prodi = $_POST['dataPost']['kode_prodi'];
            $list_item = CapaianPembelajaranLulusan::find()->where([
                'kode_prodi' => $kode_prodi,
                'state' => '1'
            ])->orderBy(['urutan' => SORT_ASC])->all();

            $items = [];
            foreach($list_item as $item){
                $items[] = [
                    'kode' => $item->kode,
                    'deskripsi' => $item->deskripsi,
                    'deskripsi_en' => ($item->deskripsi_en ?: '-'),
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

    /**
     * Lists all CapaianPembelajaranLulusan models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $kode_prodi = '';
        $kode_fakultas = '';
        $searchModel = new CapaianPembelajaranLulusanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $list_fakultas = [];
        if (!Yii::$app->user->isGuest) {
            $kode_prodi = '';
            $kode_fakultas = '';
            if(Yii::$app->user->identity->access_role == 'sekretearis'){
                $kode_prodi = Yii::$app->user->identity->prodi;
                $prodi = \app\models\SimakMasterprogramstudi::findOne(['kode_prodi' => $kode_prodi]);

                if(!empty($prodi)){
                    $kode_fakultas = $prodi->kode_fakultas;

                    $list_fakultas = \app\models\SimakMasterfakultas::find()->where(['kode_fakultas' => $kode_fakultas])->orderBy(['nama_fakultas'=>SORT_ASC])->all();
                }            
            }   

            else if(Yii::$app->user->identity->access_role == 'fakultas'){
                $kode_fakultas = Yii::$app->user->identity->fakultas;
                $list_fakultas = \app\models\SimakMasterfakultas::find()->where(['kode_fakultas' => Yii::$app->user->identity->fakultas])->orderBy(['nama_fakultas'=>SORT_ASC])->all();
            }

            else{
                $list_fakultas = \app\models\SimakMasterfakultas::find()->orderBy(['nama_fakultas'=>SORT_ASC])->all();
            }
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'kode_prodi' => $kode_prodi,
            'list_fakultas' =>$list_fakultas,
            'kode_fakultas' => $kode_fakultas
        ]);
    }

    /**
     * Displays a single CapaianPembelajaranLulusan model.
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
     * Creates a new CapaianPembelajaranLulusan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CapaianPembelajaranLulusan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CapaianPembelajaranLulusan model.
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
     * Deletes an existing CapaianPembelajaranLulusan model.
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
     * Finds the CapaianPembelajaranLulusan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return CapaianPembelajaranLulusan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CapaianPembelajaranLulusan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
