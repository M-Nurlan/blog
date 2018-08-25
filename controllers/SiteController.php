<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use app\models\ContactForm;
use app\models\Signup;
use app\models\LoginForm;
use yii\captcha\Captcha;
use app\models\SendEmailForm;
use app\models\ResetPasswordForm;
use app\models\AccountActivation;
use app\models\SendActivation;

class SiteController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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
                    //'signup' => ['post'],
                ],
            ],
        ];
    }

    
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
        /*$mail = new SendActivation();
            if (!Yii::$app->user->isGuest)
            {
                $mail->sendActivationEmail();
            }*/
        return $this->render('index');
    }

    public function actionSignup()
    {
        $emailActivation = Yii::$app->params['emailActivation'];
        if (!Yii::$app->user->isGuest) return $this->goHome();
        $model = new Signup();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $user = $emailActivation ? new Signup(['scenario' => 'emailActivation']) : new Signup();
            $user->name = Html::encode($model->name);
            $user->password = Html::encode($model->password);
            $user->email = Html::encode($model->email);
            $user->gender = Html::encode($model->gender);
            $user->birthday = Html::encode($model->birthday);
            $user->status = $model->status;
            
            //$user->location = Html::encode($model->location);
            //$user->reg_date = Html::encode($model->reg_date);
            if ($user->signup())
            {
                Yii::$app->getSession()->setFlash('success', 'You have been succesfully signed up! Check your E-mail for activation.');
                return $this->goHome();
            }
        }

        return $this->render('signup', ['model' => $model]);
    }

    public function actionActivateAccount($key)
    {
        try {
            $user = new AccountActivation($key);
        }
        catch(InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if($user->activateAccount()):
            Yii::$app->session->setFlash('success', 'Account has been successfully activated.<strong>'.Html::encode($user->getUsername($user)).'</strong>!!!');
        else:
            Yii::$app->session->setFlash('error', 'Activation error.');
            Yii::error('Activation error.');
        endif;
        if (!Yii::$app->user->isGuest) Yii::$app->user->logout();
        return $this->redirect(Url::to(['/site/login']));
    }

    public function actionSendEmail()
    {
        $model = new SendEmailForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if($model->sendEmail()):
                    Yii::$app->getSession()->setFlash('warning', 'Check the E-mail.');
                    return $this->goHome();
                else:
                    Yii::$app->getSession()->setFlash('error', 'Can not reset password.');
                endif;
            }
        }
        return $this->render('sendEmail', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($key)
{
    try {
        $model = new ResetPasswordForm($key);
    }
    catch (InvalidParamException $e) {
        throw new BadRequestHttpException($e->getMessage);
    }
    if ($model->load(Yii::$app->request->post())) {
        if ($model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('warning', 'The password has been changed.');
            return $this->redirect(['/site/login']);
        }
    }

    return $this->render('resetPassword', [
        'model' => $model,
    ]);
}

    public function actionLogin()
    {
        $login_model = new LoginForm();
        if (Yii::$app->request->post('LoginForm'))
        {
            $login_model->attributes = Yii::$app->request->post('LoginForm');
            //header('Location: http://www.example.com/');
            if ($login_model->validate() && $login_model->login())
            {
                //Yii::$app->user->login($login_model->getUser());
                return $this->goHome();
            } elseif (!$login_model->validate())
            {
                return $this->render('verify', ['login_model' => $login_model]);
            }
        }

        return $this->render('login', ['login_model' => $login_model]);
    }

    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest)
        {
            Yii::$app->user->logout();
            return $this->redirect(['login']);
        }
    }

    /*public function actionRole()
    {
            $admin = Yii::$app->authManager->createRole('admin');
            $admin->description = 'Administrator';
            Yii::$app->authManager->add($admin);

            $user = Yii::$app->authManager->createRole('user');
            $user->description = 'user';
            Yii::$app->authManager->add($user);

            $moderator = Yii::$app->authManager->createRole('moderator');
            $moderator->description = 'moderator';
            Yii::$app->authManager->add($moderator);

            $delete  = Yii::$app->authManager->createPermission('delete');
            $delete->description = 'Permission to delete';
            Yii::$app->authManager->add($delete);
            $auth = Yii::$app->authManager;

            // add the rule
            $rule = new \app\rbacrules\UserRule;
            $auth->add($rule);

            return $this->redirect(['index']);
    }*/
    
}
