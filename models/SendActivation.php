<?php
namespace app\models;

use Yii;
use yii\base\Model;

class SendActivation extends Model
{
	private $name;
	private $email;
	public $status;
	public $secret_key;

	public function getUser()
	{
		return User::findOne(['email' => $this->email]);
	}

	public function getName()
	{
		return User::findOne(['name' => $this->name]);
	}

	public function sendActivationEmail()
    {
    	$user = User::findOne([
    		'email' => Yii::$app->user->identity['email'],
    		'status' => Yii::$app->user->identity['status'] === User::STATUS_NOT_ACTIVE
    	]);
    	if ($user)
    	{
    		$user->generateSecretKey();
    		if ($user->save())
    		{
		        return Yii::$app->mailer->compose('activationEmail', ['user' => $user])
		            ->setFrom([Yii::$app->params['admin'] => Yii::$app->user->identity['name'].' (sent by admin).'])
		            ->setTo(Yii::$app->user->identity['email'])
		            ->setSubject('Activation for '.Yii::$app->user->identity['name'])
		            ->send();
	        }
    	}
    }
}