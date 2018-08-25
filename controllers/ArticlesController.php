<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use app\models\ArticleForm;
use app\models\Article;

class ArticleController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                    //'signup' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
    $model = new ArticleForm();

    if ($model->load(Yii::$app->request->post())) {
        if ($model->validate()) {
            if ($model->createArticle())
            {
                Yii::$app->getSession()->setFlash('success', 'You created an article.');
                return $this->redirect(Url::to(['/site/index']));
            }
        }
    }

    return $this->render('index', [
        'model' => $model,
    ]);
	}

}
