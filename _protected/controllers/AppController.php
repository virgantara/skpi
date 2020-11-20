<?php
namespace app\controllers;

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
        // $session->remove('token');
        if($session->has('token'))
        {
            if (!parent::beforeAction($action)) {
                return false;
            }

        }

        else
        {
            $time = time();
            $token = Yii::$app->jwt->getBuilder()
                        ->issuedBy(Url::home(true)) // Configures the issuer (iss claim)
                        ->permittedFor($model->url) // Configures the audience (aud claim)
                        ->identifiedBy('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
                        ->issuedAt($time) // Configures the time that the token was issue (iat claim)
                        ->canOnlyBeUsedAfter($time) // Configures the time that the token can be used (nbf claim)
                        ->expiresAt($time + 3600) // Configures the expiration time of the token (exp claim)
                        ->withClaim('uid', Yii::$app->user->identity->uuid) // Configures a new claim, called "uid"
                        ->getToken(); // Retrieves the generated token


            $token->getHeaders(); // Retrieves the token headers
            $token->getClaims(); // Retrieves the token claims

            return $this->redirect($model->url.'/'.$model->success_callback.'/?token='.$token);
            return $this->redirect(Yii::$app->params['sso_login']);
        }

        

        // other custom code here

        return true; // or false to not run the action
    }
    

} // AppController
