<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($login_model, 'email')->textInput(['autofocus' => true]) ?>
	<?= $form->field($login_model, 'password')->passwordInput() ?>
	<?= Html::submitButton('Log in', ['class' => 'btn btn-success']) ?>

	<?= Html::a('Forgot your password?', ['/site/send-email']) ?>

<?php $form = ActiveForm::end(); ?>