<?php
namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\httpclient\Client;
use Yii;

/**
 * AppController extends Controller and implements the behaviors() method
 * where you can specify the access control ( AC filter + RBAC ) for your controllers and their actions.
 */
class AppController extends Controller
{
    
    public function refreshToken()
    {

        $api_baseurl = Yii::$app->params['invoke_token_uri'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $headers = ['x-jwt-token'=>$token];

        $params = [];
        $response = $client->get($api_baseurl, $params,$headers)->send();
        if ($response->isOk) {
            $res = $response->data;
            if($res['code'] != '200')
            {
                $session->remove('token');
                throw new \Exception;
                
            }
        }
    }

    public function beforeAction($action)
    {
        
        $session = Yii::$app->session;
        
        if($session->has('token'))
        {

            try
            {

                $token = $session->get('token');
                $key = Yii::$app->params['jwt_key'];
                $decoded = \Firebase\JWT\JWT::decode($token, base64_decode(strtr($key, '-_', '+/')), ['HS256']);

            }

            catch(\Exception $e) 
            {
                // print_r($e);exit;
                $session = Yii::$app->session;
                
                $api_baseurl = Yii::$app->params['invoke_token_uri'];
                $client = new Client(['baseUrl' => $api_baseurl]);
                $headers = ['x-jwt-token'=>$token];

                $params = [
                    'uuid' => Yii::$app->user->identity->uuid
                ];
                
                $response = $client->get($api_baseurl, $params,$headers)->send();
                if ($response->isOk) {
                    $res = $response->data;

                    if($res['code'] != '200')
                    {
                        return $this->redirect(Yii::$app->params['sso_login']);
                    }

                    else{
                        $session->set('token',$res['token']);
                    }
                }
                // 
            }
            
            if (!parent::beforeAction($action)) {
                return false;
            } 
        }

        else
        {
            
            return $this->redirect(Yii::$app->params['sso_login']);
        }


        if(Yii::$app->user->identity->access_role == 'Mahasiswa' && Yii::$app->user->identity->is_accept_term == '0' && $action->id != 'update-profil')
        {
            if(!Yii::$app->request->isPost)
                return $this->redirect(['simak-mastermahasiswa/update-profil']);
        }
        // other custom code here

        return true; // or false to not run the action
    }
} // AppController
