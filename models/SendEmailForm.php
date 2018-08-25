<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SendEmailForm extends Model
{
	public $email;
	public $secret_key;

	public function rules()
	{
		return [
			['email', 'filter', 'filter' => 'trim'],
			['email', 'required'],
			['email', 'email'],
			['email', 'exist',
				'targetClass' => User::className(),
				'filter' => [
					'status' => User::STATUS_ACTIVE
				],
				'message' => 'The E-mail does not exist!'
			],
		];
	}

	public function attributeLabels()
	{
		return [
			'email' => 'E-mail',
		];
	}

	public function sendEmail()
	{
		$user = User::findOne(
			[
				'status' => User::STATUS_ACTIVE,
				'email' => $this->email,
			]
		);

		if ($user)
		{
			$user->generateSecretKey();
			if($user->save())
			{
				return Yii::$app->mailer->compose('resetPassword', ['user' => $user])
				->setFrom([Yii::$app->params['admin'] => Yii::$app->name.'(sent by admin)'])
				->setTo($this->email)
				->setSubject('Password reset'.Yii::$app->name)
				->send();
			}
		}
		return false;
	}

}

?>