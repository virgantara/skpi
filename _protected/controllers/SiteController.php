<?php
namespace app\controllers;

use app\models\User;
use app\models\LoginForm;
use app\models\AccountActivation;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\ContactForm;
use yii\httpclient\Client;
use yii\helpers\Html;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \Firebase\JWT\JWT;
use Yii;

/**
 * Site controller.
 * It is responsible for displaying static pages, logging users in and out,
 * sign up and account activation, and password reset.
 */
class SiteController extends Controller
{

    public $successUrl = '';
    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Declares external actions for the controller.
     *
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
                'successUrl' => $this->successUrl
            ],
        ];
    }

    public function beforeAction($action)
    {
        
        return true; // or false to not run the action
    }


    
//------------------------------------------------------------------------------------------------//
// OAUTH2 CALLBACK
//------------------------------------------------------------------------------------------------//
    public function actionAuthCallback()
    {


        // $input = json_decode(file_get_contents('php://input'),true);
        // header('Content-type:application/json;charset=utf-8');

        $results = [];
         

        try
        {
            $session = Yii::$app->session;
            $access_token = Yii::$app->request->get('access_token');
            $refresh_token = Yii::$app->request->get('refresh_token');

            $result = Yii::$app->tokenManager->validateTokenFromOtherApps($access_token);
                
            if(isset($result['error'])){

                throw new \Exception($result['error'], 401);
                
            }
            // echo '<pre>';
            // print_r($result);exit;
            $token = $result['token'];
            
            $accessTokenExpiresAt = $token['accessTokenExpiresAt'];
            $uuid = $token['user']['uuid'];
            

            $user = \app\models\User::find()->where([
                'uuid'=>$uuid,
            ])
            ->one();

            $session->set('access_token', $access_token);
            $session->set('refresh_token', $refresh_token ?? null);
            $session->set('expires_in',$accessTokenExpiresAt);

            if(!empty($user)){
                
                Yii::$app->user->login($user);

                $hasil = Yii::$app->aplikasi->getAllowedAplikasi($access_token, $refresh_token);               
                
                // $session->set('apps',$hasil['apps']);

                return $this->redirect(['site/index']);
            }

            else{
                throw new \Exception("User with ".$decoded->uuid." not found SIAKAD", 404);
                
            }
            
        }
        catch(\Exception $e) 
        {

            $results = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            
            http_response_code($e->getCode());
            header('Content-type: application/json');
            Yii::$app->session->setFlash("danger",$e->getMessage());
            Yii::$app->tokenManager->handleTokenFailure();
            // return $this->redirect(['site/index']);
        }

        echo json_encode($results);

        die();
        
       
    }


    public function actionCallback()
    {
        $session = Yii::$app->session;  

        $receivedJwt = Yii::$app->request->get('state');
        
        $secretKey = Yii::$app->params['jwt_key'];
        $decoded = JWT::decode($receivedJwt, new Key($secretKey, 'HS256'));

        if ($decoded->iss !== Yii::$app->params['oauth']['redirectUri']) {
            throw new BadRequestHttpException('Invalid issuer.');
        }

        if ($decoded->exp < time()) {
            throw new BadRequestHttpException('Token has expired.');
            
        }
      
        try {

            $authCode = Yii::$app->request->get('code');
            $accessToken = Yii::$app->tokenManager->fetchAccessTokenWithAuthCode($authCode);
            
            Yii::$app->session->set('jwt_token', $accessToken);

            $jwtSecretKey = Yii::$app->params['jwt_key'];
            $decoded = JWT::decode($accessToken, new Key($jwtSecretKey, 'HS256'));
            $uuid = $decoded->uuid;
            $user = \app\models\User::find()->where([
                'uuid'=>$uuid,
            ])
            ->one();

            Yii::$app->session->set('access_token', $decoded->accessToken);
            Yii::$app->session->set('refresh_token', $decoded->refreshToken ?? null);
            Yii::$app->session->set('expires_in',$decoded->accessTokenExpiresAt);

            if(!empty($user)){
                
                Yii::$app->user->login($user);

                $hasil = Yii::$app->aplikasi->getAllowedAplikasi($decoded->accessToken,$decoded->refreshToken);               
            
                $session->set('token',$hasil['token']);
                $session->set('apps',$hasil['apps']);

                return $this->redirect(['site/index']);
            }

            else{
                throw new \Exception("User with ".$decoded->uuid." not found SIAKAD");
                
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('danger',$e->getMessage());
            return $this->redirect(['site/index']);
        }
    }


    public function actionLogoutCallback(){
        Yii::$app->user->logout();
        $url = Yii::$app->params['sso_url'];
        return $this->redirect($url);
    }

    public function actionLoginSso($token)
    {
        $key = Yii::$app->params['jwt_key'];
        $decoded = JWT::decode($token, base64_decode(strtr($key, '-_', '+/')), ['HS256']);
        
        $uuid = $decoded->uuid; // will print "1"
        $user = \app\models\User::find()
            ->where([
                'uuid'=>$uuid,
            ])
            ->one();

        if(!empty($user)){
            $session = Yii::$app->session;
            $session->set('token',$token);
            Yii::$app->user->login($user);
            return $this->redirect(['index']);
        }
        else{
            //Simpen disession attribute user dari Google
            return $this->redirect($decoded->iss.'/site/sso-callback?code=302')->send();
        }   
    }

    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
        $user = \app\models\User::find()
            ->where([
                'email'=>$attributes['email'],
            ])
            ->one();
        if(!empty($user)){
            Yii::$app->user->login($user);
        }
        else{
            //Simpen disession attribute user dari Google
            $session = Yii::$app->session;
            $session['attributes']=$attributes;
            // redirect ke form signup, dengan mengset nilai variabell global successUrl
            $this->successUrl = \yii\helpers\Url::to(['site/index']);
        }   
    }

//------------------------------------------------------------------------------------------------//
// STATIC PAGES
//------------------------------------------------------------------------------------------------//

    public function actionLulusan()
    {
        if(Yii::$app->user->can('theCreator'))
        {
            $model = new \app\models\LulusanForm;
            $notes = '';
            if (Yii::$app->request->isPost) 
            {
                $uploadedFile = \yii\web\UploadedFile::getInstance($model, 'dataLulusan');
                $extension =$uploadedFile->extension;
                if($extension=='xlsx')
                {
                    $inputFileType = 'Xlsx';
                }

                else if($extension=='xls')
                {
                    $inputFileType = 'Xls';
                }
                else
                {
                    $inputFileType = 'Csv';
                }

                
                $sheetname =$model->dataLulusan;
                $inputFileName = $uploadedFile->tempName;
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
    /**  Create a new Reader of the type that has been identified  **/
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

                $reader->setLoadSheetsOnly($sheetname);
                // print_r($sheetname);exit;
                $spreadsheet = $reader->load($uploadedFile->tempName);
                $worksheet = $spreadsheet->getActiveSheet();
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
                  
                $connection = \Yii::$app->db;
                $transaction = $connection->beginTransaction();

               
                try 
                {

                    $api_baseurl = Yii::$app->params['api_baseurl'];
                    $client = new Client(['baseUrl' => $api_baseurl]);
                    
                    for ($row = 1; $row <= $highestRow; ++$row) 
                    { 
                        $nim = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $tgl_lulus = $worksheet->getCellByColumnAndRow(2, $row)->getValue(); 
                        $no_sk = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $tgl_sk = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $mhs = \app\models\SimakMastermahasiswa::find()->where(['nim_mhs'=>$nim])->one();

                        if(!empty($mhs))
                        {
                            // echo $mhs->nim_mhs.' '.$mhs->tgl_lulus;
                            $mhs->status_aktivitas = 'L';
                            $mhs->tgl_lulus = $tgl_lulus;
                            $mhs->no_sk_yudisium = $no_sk;
                            $mhs->tgl_sk_yudisium = $tgl_sk;
                            $mhs->save(false,['status_aktivitas','tgl_lulus','no_sk_yudisium','tgl_sk_yudisium']);
                        }

                        else{


                            // $logs = 'NIM '.$nim.' tidak ada di dalam database siakad';
                            $notes .= $nim.', ';
                            // throw new \Exception($logs);
                            
                        }
                    }

                    $transaction->commit();
                    if(!empty($notes))
                    {
                        $notes .= ' tidak ada di dalam database SIAKAD';
                        Yii::$app->session->setFlash('warning', $notes);
                    }
                    else{
                        Yii::$app->session->setFlash('success', 'Data updated');
                    }
                    return $this->redirect(['site/lulusan']);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    $model->addError('dataLulusan',$e->getMessage());
                    // print_r($e->getMessage());
                    // exit;
                    // throw $e;
                } catch (\Throwable $e) {
                    // print_r($e->getMessage());
                    $transaction->rollBack();
                    $model->addError('dataLulusan',$e->getMessage());
                    // exit;
                    // throw $e;
                }

                // return;

            }



            return $this->render('lulusan',[
                'model'=>$model
            ]);
        }
    }

    /**
     * Displays the index (home) page.
     * Use it in case your home page contains static content.
     *
     * @return string
     */
    public function actionIndex()
    {

        // if (Yii::$app->user->isGuest) {
        //     $this->redirect(['/site/login']);
        // }

        // else
        // {
            // $api_baseurl = Yii::$app->params['api_baseurl'];
            // $client = new Client(['baseUrl' => $api_baseurl]);

            // $tahun = $_POST['tahun'] ?: date('Y');
            // $tahun = $_POST['tahun'] ?: date('Y');
            // $semester = $_POST['semester'] ?: 1;
            // $ta = $tahun.$semester;

            // $response = $client->get('/ekd/univ', ['tahun' => $ta])->send();
            
            $out = [];
            // if ($response->isOk) {

            //     $out = $response->data['values'][0];
                
            // }
            $results = [];

            if(!Yii::$app->user->isGuest){
                    
                
                $query = new \yii\db\Query();   
                $query = $query->select(['konsulat', 'c.name','c.latitude','c.longitude', 'count(*) as total'])
                ->from('simak_mastermahasiswa m')
                ->innerJoin('cities c', 'm.konsulat = c.id');
                if(Yii::$app->user->identity->access_role == 'operatorCabang')
                {
                    $query->where(['m.kampus'=>Yii::$app->user->identity->kampus]);

                }

                $query->groupBy(['m.konsulat', 'c.name','c.latitude','c.longitude'])
                ->orderBy('total DESC');
                // ->limit(10)
                $results = $query->all();
            }
            

            return $this->render('index',[
                'data'=>$out,
                'results' => $results
            ]);
        // }
    }

    /**
     * Displays the about static page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays the contact static page and sends the contact email.
     *
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            return $this->render('contact', ['model' => $model]);
        }

        if (!$model->sendEmail(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'There was some error while sending email.'));
            return $this->refresh();
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 
            'Thank you for contacting us. We will respond to you as soon as possible.'));
        
        return $this->refresh();
    }

//------------------------------------------------------------------------------------------------//
// LOG IN / LOG OUT / PASSWORD RESET
//------------------------------------------------------------------------------------------------//

    /**
     * Logs in the user if his account is activated,
     * if not, displays appropriate message.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
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
                \app\helpers\MyHelper::refreshToken($token);
            }
            
             
        }

        else
        {
            return $this->redirect(Yii::$app->params['sso_login']);
        }

        $this->layout = 'default';
        // user is logged in, he doesn't need to login
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // get setting value for 'Login With Email'
        $lwe = Yii::$app->params['lwe'];

        // if 'lwe' value is 'true' we instantiate LoginForm in 'lwe' scenario
        $model = $lwe ? new LoginForm(['scenario' => 'lwe']) : new LoginForm();

        // monitor login status
        $successfulLogin = true;

        // posting data or login has failed
        if (!$model->load(Yii::$app->request->post()) || !$model->login()) {
            $successfulLogin = false;
        }



        // if user's account is not activated, he will have to activate it first
        if ($model->status === User::STATUS_INACTIVE && $successfulLogin === false) {
            Yii::$app->session->setFlash('error', Yii::t('app', 
                'You have to activate your account first. Please check your email.'));
            return $this->refresh();
        } 

        // if user is not denied because he is not active, then his credentials are not good
        if ($successfulLogin === false) {
            return $this->render('login', ['model' => $model]);
        }

        // login was successful, let user go wherever he previously wanted
        return $this->goBack();
    }

    /**
     * Logs out the user.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        
        $session = Yii::$app->session;
        $session->remove('token');
        Yii::$app->user->logout();
        $url = Yii::$app->params['sso_logout'];
        return $this->redirect($url);
    }

/*----------------*
 * PASSWORD RESET *
 *----------------*/

    /**
     * Sends email that contains link for password reset action.
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'default';
        $model = new PasswordResetRequestForm();

        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            return $this->render('requestPasswordResetToken', ['model' => $model]);
        }

        if (!$model->sendEmail()) {
            Yii::$app->session->setFlash('error', Yii::t('app', 
                'Sorry, we are unable to reset password for email provided.'));
            return $this->refresh();
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 'Silakan cek inbox email Anda. Jika tidak ada, mohon cek spam Anda'));

        return $this->goHome();
    }

    /**
     * Resets password.
     *
     * @param  string $token Password reset token.
     * @return string|\yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (!$model->load(Yii::$app->request->post()) || !$model->validate() || !$model->resetPassword()) {
            return $this->render('resetPassword', ['model' => $model]);
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 'New password was saved.'));

        return $this->goHome();      
    }    

//------------------------------------------------------------------------------------------------//
// SIGN UP / ACCOUNT ACTIVATION
//------------------------------------------------------------------------------------------------//

    /**
     * Signs up the user.
     * If user need to activate his account via email, we will display him
     * message with instructions and send him account activation email with link containing account activation token. 
     * If activation is not necessary, we will log him in right after sign up process is complete.
     * NOTE: You can decide whether or not activation is necessary, @see config/params.php
     *
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {  
        // get setting value for 'Registration Needs Activation'
        $rna = Yii::$app->params['rna'];

        // if 'rna' value is 'true', we instantiate SignupForm in 'rna' scenario
        $model = $rna ? new SignupForm(['scenario' => 'rna']) : new SignupForm();

        // if validation didn't pass, reload the form to show errors
        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            return $this->render('signup', ['model' => $model]);  
        }

        // try to save user data in database, if successful, the user object will be returned
        $user = $model->signup();

        if (!$user) {
            // display error message to user
            Yii::$app->session->setFlash('error', Yii::t('app', 'We couldn\'t sign you up, please contact us.'));
            return $this->refresh();
        }

        // user is saved but activation is needed, use signupWithActivation()
        if ($user->status === User::STATUS_INACTIVE) {
            $this->signupWithActivation($model, $user);
            return $this->refresh();
        }

        // now we will try to log user in
        // if login fails we will display error message, else just redirect to home page
    
        if (!Yii::$app->user->login($user)) {
            // display error message to user
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Please try to log in.'));

            // log this error, so we can debug possible problem easier.
            Yii::error('Login after sign up failed! User '.Html::encode($user->username).' could not log in.');
        }
                      
        return $this->goHome();
    }

    /**
     * Tries to send account activation email.
     *
     * @param $model
     * @param $user
     */
    private function signupWithActivation($model, $user)
    {
        // sending email has failed
        if (!$model->sendAccountActivationEmail($user)) {
            // display error message to user
            Yii::$app->session->setFlash('error', Yii::t('app', 
                'We couldn\'t send you account activation email, please contact us.'));

            // log this error, so we can debug possible problem easier.
            Yii::error('Signup failed! User '.Html::encode($user->username).' could not sign up. 
                Possible causes: verification email could not be sent.');
        }

        // everything is OK
        Yii::$app->session->setFlash('success', Yii::t('app', 'Hello').' '.Html::encode($user->username). '. ' .
            Yii::t('app', 'To be able to log in, you need to confirm your registration. 
                Please check your email, we have sent you a message.'));
    }

/*--------------------*
 * ACCOUNT ACTIVATION *
 *--------------------*/

    /**
     * Activates the user account so he can log in into system.
     *
     * @param  string $token
     * @return \yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionActivateAccount($token)
    {
        try {
            $user = new AccountActivation($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (!$user->activateAccount()) {
            Yii::$app->session->setFlash('error', Html::encode($user->username). Yii::t('app', 
                ' your account could not be activated, please contact us!'));
            return $this->goHome();
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 'Success! You can now log in.').' '.
            Yii::t('app', 'Thank you').' '.Html::encode($user->username).' '.Yii::t('app', 'for joining us!'));

        return $this->redirect('login');
    }
}
