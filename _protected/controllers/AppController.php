<?php
namespace app\controllers;

use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

/**
 * AppController extends Controller and implements the behaviors() method
 * where you can specify the access control ( AC filter + RBAC ) for your controllers and their actions.
 */
class AppController extends Controller
{

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
                return $this->redirect(Yii::$app->params['sso_login']);
            }
            
            if (!parent::beforeAction($action)) {
                return false;
            } 
        }

        else
        {
            
            return $this->redirect(Yii::$app->params['sso_login']);
        }

        

        // other custom code here

        return true; // or false to not run the action
    }
    

} // AppController
