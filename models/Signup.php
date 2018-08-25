<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Signup extends Model
{
	public $name;
	public $email;
	public $password;
	public $gender;
	public $birthday;
	public $status;
	public $secret_key;
	//public $location;

	public function rules()
	{
		return [
			[['name', 'email', 'password', 'gender', 'birthday'], 'required'],
			//['location'],
			['email', 'email'],
			//['password', 'validatePassword'],
            ['status', 'default', 'value' => User::STATUS_ACTIVE, 'on' => 'emailActivation'],
			['status', 'default', 'value' => User::STATUS_NOT_ACTIVE, 'on' => 'default'],
            ['status', 'in', 'range' =>[
                User::STATUS_NOT_ACTIVE,
                User::STATUS_ACTIVE
            ]],

		];
	}

	public function attributeLabels()
	{
		return [
			'name' => 'Nickname',
			'email' => 'E-mail',
			'birthday' => 'Choose your birthday',
		];
	}

	public function signup()
	{
		if ($this->validate())
		{
			$user = new User();
	        $user->name = $this->name;
	        $user->setPassword($this->password);
	        $user->email = $this->email;
	        $user->gender = $this->gender;
	        $user->birthday = $this->birthday;
	        $user->status = $this->status;
	        if ($this->scenario === 'emailActivation')
	        {
	        	$user->generateSecretKey();
	        	Yii::$app->mailer->compose('activationEmail', ['user' => $user])
	            ->setFrom([Yii::$app->params['admin'] => Yii::$app->name.' (sent by admin).'])
	            ->setTo($this->email)
	            ->setSubject('Activation for '.Yii::$app->name)
	            ->send();
	        }
	        $user->save(false);

	        $auth = \Yii::$app->authManager;
	        $authorRole = $auth->getRole('user');
	        $auth->assign($authorRole, $user->getId());
	        return $user;
	    }
	    return null;
        
	}

	/*public function sendActivationEmail($user)
    {
    	$user = User::findOne(['email' => $this->email]);
    	$user->generateSecretKey();
        return Yii::$app->mailer->compose('activationEmail', ['user' => $user])
            ->setFrom([Yii::$app->params['admin'] => Yii::$app->name.' (sent by admin).'])
            ->setTo($this->email)
            ->setSubject('Activation for '.Yii::$app->name)
            ->send();
    }*/
	

}


?>