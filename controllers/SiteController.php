<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Users;
use app\models\UserIdentity;
use app\models\PasswordForm;
use DateTime;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','logout', 'import', 'about'],
                'rules' => [
                    [
                        'actions' => ['index', 'logout', 'import', 'about','changepassword'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                        [
                            'actions' => ['index'],
                    'allow' => true,
                    'roles' => ['?'],
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
     * {@inheritdoc}
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


       public static function isToday($date)
        {
        return date('Y-m-d', $date) == date('Y-m-d', time());
        }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $model = new LoginForm();

    /**
     * parameter $period_expire
     *
     *  string
     */
        $period_expire = '+3 day';

        $dateUpdate = new DateTime(Yii::$app->user->identity->dateUpdateEntry);
        $dateUpdate->modify($period_expire);
        $dateUpdateAccount = $dateUpdate->format('Y-m-d');  

        if (!Yii::$app->user->isGuest) {
          
            return $this->goHome();
        }

        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

           if($dateUpdateAccount <= date('Y-m-d', time())){
        
        Yii::$app->getSession()->setFlash('error', $dateUpdateAccount.' Your Password expired');
        Yii::$app->user->logout();
        return $this->redirect(['changepassword']);
        
    }
   
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays Import Users page.
     *
     * @return string
     */
    public function actionImport(){
        $modelImport = new \yii\base\DynamicModel([
                    'fileImport'=>'File Import',
                ]);
        $modelImport->addRule(['fileImport'],'required');
        $modelImport->addRule(['fileImport'],'file',['extensions'=>'ods,xls,xlsx']);//,['maxSize'=>1024*1024]);

        if(Yii::$app->request->post()){
            $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport,'fileImport');
            if($modelImport->fileImport && $modelImport->validate()){
                $inputFileType = \PHPExcel_IOFactory::identify($modelImport->fileImport->tempName);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                $baseRow = 2;// 1 row is header

                while(!empty($sheetData[$baseRow]['A'])){
                    $model = new Users();
                    $idUser = $model->id_User;
                    $username_entry = (string)$sheetData[$baseRow]['A'];
                    $model->username = $username_entry;
                    $model->email = (string)$sheetData[$baseRow]['C'];
                    $model->birthdate = (string)$sheetData[$baseRow]['D'];
                    $model->firstname = (string)$sheetData[$baseRow]['A'];
                    $model->surname = (string)$sheetData[$baseRow]['B'];
                    $user_password_rnd = ( bin2hex(openssl_random_pseudo_bytes(4)));
                    //$model->password = md5("1111");
                    $model->password = md5($user_password_rnd);

                    $model->save(false);

                    $date = new DateTime($model->dateOnCreate);
					$timeCreateAccont = $date->format('Y-m-d H:i:s');
					$textBodyMess = 'Account was created for user:'.$username_entry.
									', Password:'.$user_password_rnd.
									' Time create: '.$timeCreateAccont;

     /**
     * Send E-mail
     * 'useFileTransport' => true;
     *  body Mail-->runtime/mail;
     */
					Yii::$app->mailer->compose()
    				->setFrom('gmx@gmail.com')
    				->setTo('gmxppp@gmail.com')
    				->setSubject(' Account  '.$username_entry)
    				->setTextBody($textBodyMess)
    				->setHtmlBody('<b>HTML content</b>')
    				->send();						
                    $baseRow++;
                }
               Yii::$app->getSession()->setFlash('success',  ($baseRow-2).' Record(s) is created');

            }else{
                Yii::$app->getSession()->setFlash('error','Error');
            }
        }

        return $this->render('import',[
                'modelImport' => $modelImport,
            ]);
    }

    /**
     * Displays Change password page.
     * http://localhost/basic/web/index.php?r=site%2Fchangepassword
     * @return string
     */

    public function actionChangepassword(){
        $model = new PasswordForm;
        $modeluser = UserIdentity::find()->where([
            'username'=>Yii::$app->user->identity->username
        ])->one();
     if(Yii::$app->user->isGuest){
        /*
        $date = new DateTime(Yii::$app->user->identity->dateUpdateEntry);
        $date->modify($period_expire);
        $dateUpdateAccont = $date->format('Y-m-d');
        Yii::$app->getSession()->setFlash('error','Password is expired : '.$dateUpdateAccont);
        */
        Yii::$app->getSession()->setFlash('error','Password is expired !');
     }
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                try{
                    $modeluser->password = md5($_POST['PasswordForm']['newpass']);
                    if($modeluser->save(false)){
                        Yii::$app->getSession()->setFlash(
                            'success','Password changed'
                        );
                        return $this->redirect(['changepassword']);
                    }else{
                        Yii::$app->getSession()->setFlash(
                            'error','Password not changed'
                        );
                        return $this->redirect(['changepassword']);
                    }
                }catch(Exception $e){
                    Yii::$app->getSession()->setFlash(
                        'error',"{$e->getMessage()}"
                    );
                    return $this->render('changepassword',[
                        'model'=>$model
                    ]);
                }
            }else{
                return $this->render('changepassword',[
                    'model'=>$model
                ]);
            }
        }else{
            return $this->render('changepassword',[
                'model'=>$model
            ]);
        }
    }


}
