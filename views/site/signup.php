<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

$items = [
        'male' => 'Male',
        'female' => 'Female',
    ];
    $params = [
        'prompt' => 'Choose gender...'
    ];

?>
<?php $form = ActiveForm::begin() ?>

	<?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
	<?= $form->field($model, 'password')->passwordInput() ?>
	<?= $form->field($model, 'email')->textInput() ?>
	<?= $form->field($model, 'gender')->dropDownList($items,$params) ?>
	<?= $form->field($model, 'birthday')->widget(
	    DatePicker::className(), [
	        // inline too, not bad
	         'inline' => true, 
	         // modify template for custom rendering
	        'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
	        'clientOptions' => [
	            'autoclose' => true,
	            'format' => 'yyyy-MM-dd'
	        ]
		]) ?>
	<?= Html::submitButton('Sign up', ['class' => 'btn btn-primary']) ?>

<?php $form = ActiveForm::end() ?>