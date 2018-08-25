<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\Security;
use yii\behaviors\TimestampBehavior;

class User extends ActiveRecord implements IdentityInterface
{
	const STATUS_DELETED = 0;
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 10;
    
	public function rules()
    {
        return [
            [['name', 'email', 'password'], 'filter', 'filter' => 'trim'],
            [['name', 'email'], 'required'],
            ['email', 'email'],
            ['name', 'string', 'min' => 2, 'max' => 255],
            ['password', 'required'],
            ['name', 'unique', 'message' => 'This nickname is in use.'],
            ['email', 'unique', 'message' => 'This E-mail is in use.'],
            ['secret_key', 'unique']
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public static function findByUsername($name)
    {
        return static::findOne([
            'name' => $name
        ]);
    }

    public function setPassword($pass)
	{
		$this->password = md5($pass);
	}

	public function validatePassword($pass)
	{
		return $this->password === md5($pass);
	}

	public function removeSecretKey()
    {
        $this->secret_key = null;
    }

    public static function findBySecretKey($key)
    {
        if (!static::isSecretKeyExpire($key))
        {
            return null;
        }
        return static::findOne(['secret_key' => $key]);
    }

    public static function isSecretKeyExpire($key)
    {
        if (empty($key))
        {
            return false;
        }
        $expire = Yii::$app->params['secretKeyExpire'];
        $parts = explode('_', $key);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

	public static function findIdentity($id)
	{
		return static::findOne([
            'id' => $id
        ]);
	}

	public function generateSecretKey()
    {
        $this->secret_key = \Yii::$app->security->generateRandomString().'_'.time();
    }

	public static function findIdentityByAccessToken($token, $type = null)
	{

	}

	public function getId()
	{
		return $this->id;
	}

	public function getAuthKey()
	{

	}

	public function validateAuthKey($authKey)
	{

	}

}

?>