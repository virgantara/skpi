<?php

namespace app\controllers;

use Yii;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\helpers\MyHelper;
use yii\httpclient\Client;

use app\models\HukumanSearch;


/**
 * PenjualanController implements the CRUD actions for Penjualan model.
 */
class ApiController extends Controller
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

    public function actionAjaxCariMahasiswa() {

        $q = $_GET['term'];
        
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $client_token = Yii::$app->params['client_token'];
        $headers = ['x-access-token'=>$client_token];
        $response = $client->get('/m/cari', ['key' => $q],$headers)->send();
        
        $out = [];

        
        if ($response->isOk) {
            $result = $response->data['values'];
            // print_r($result);exit;
            if(!empty($result))
            {
                foreach ($result as $d) {
                    $out[] = [
                        'id' => $d['nim_mhs'],
                        'label'=> $d['nim_mhs'].' - '.$d['nama_mahasiswa'],
                      
                    ];
                }
            }

            else
            {
                $out[] = [
                    'id' => 0,
                    'label'=> 'Data mahasiswa tidak ditemukan',
                   
                ];
            }
        }
        

        echo \yii\helpers\Json::encode($out);

      
    }

    public function actionGetHukuman()
    {
        $result = [];
        // if(Yii::app()->request->isAjaxRequest)
        // {
        $q = $_GET['term'];
        $model = HukumanSearch::searchByNama($q);

        
        foreach($model as $m)
        {
            $result[] = array(
                'id' => $m->id,
                'value' => $m->nama.' - '.$m->kategori->nama,

            );
        }
        // }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; 
        \Yii::$app->response->data  =  $result;
        // echo CJSON::encode($result);
    }

}
