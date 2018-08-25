<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($login_model, 'email')->textInput(['autofocus' => true]) ?>
	<?= $form->field($login_model, 'password')->passwordInput() ?>
	<?= $form->field($login_model, 'captcha')->widget(\yii\captcha\Captcha::classname(), [

	]) ?>
	<?= Html::submitButton('Log in', ['class' => 'btn btn-success']) ?>

<?php $form = ActiveForm::end(); ?>