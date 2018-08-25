<?php
/**

 * @var $this yii\web\View
 * @var $user app\models\User
 */
use yii\helpers\Html;
echo 'Hello, '.Html::encode($user->name).'.';
echo Html::a('For activation follow this link.',
    Yii::$app->urlManager->createAbsoluteUrl(
        [
            '/site/activate-account',
            "key" => $user->secret_key
        ]
    ));