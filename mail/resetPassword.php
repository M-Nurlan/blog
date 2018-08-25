<?php

use yii\helpers\Html;

echo 'Hello '.Html::encode($user->name).'. ';

echo Html::a('For password reset follow this link. ',
	Yii::$app->urlManager->createAbsoluteUrl(
		[
			'/site/reset-password',
			'key' => $user->secret_key,
		]
	));

?>