<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;

class LoginForm extends Model
{
	public $email;
	public $password;
	public $status;
	public $captcha;

	public function rules()
	{
		return [
			[['email', 'password'], 'required'],
			//['email', 'email'],
			['password', 'validatePassword'],
		];
	}

	public function attributeLabels()
	{
		return [
			'email' => 'E-mail',
		];
	}

	public function getUser()
	{
		return User::findOne(['email' => $this->email]);
	}

	public function validatePassword($attribute, $params)
	{
		if (!$this->hasErrors())
		{
			$user = $this->getUser();
			if (!$user || !$user->validatePassword($this->password))
			{
				$this->addError($attribute, 'Wrong E-mail or password!');
			}
		}
		
	}

	public function login()
    {
        if ($this->validate()):
            $this->status = ($user = $this->getUser()) ? $user->status : User::STATUS_NOT_ACTIVE;
            return Yii::$app->user->login($user);
            /*if ($this->status === User::STATUS_ACTIVE):
                return Yii::$app->user->login($user);
            else:
                return Yii::$app->getSession()->setFlash('warning', 'Incorrect E-mail or password.');
            endif;*/
        else:
            return false;
        endif;
    }

}

?>