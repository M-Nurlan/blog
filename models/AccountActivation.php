<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;

class AccountActivation extends Model
{
    /* @var $user \app\models\User */
    private $_user;
    public function __construct($key, $config = [])
    {
        if(empty($key) || !is_string($key))
            throw new InvalidParamException('Ключ не может быть пустым!');
        $this->_user = User::findBySecretKey($key);
        if(!$this->_user)
            throw new InvalidParamException('Не верный ключ!');
        parent::__construct($config);
    }
    public function activateAccount()
    {
        $user = $this->_user;
        $user->status = User::STATUS_ACTIVE;
        $user->removeSecretKey();
        return $user->save();
    }
    public function getUsername($name)
    {
        $user = User::findByUsername($name);
        return $user;
    }
}