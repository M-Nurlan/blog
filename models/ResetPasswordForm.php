<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 05.08.2015
 * Time: 15:46
 */
namespace app\models;
use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;

class ResetPasswordForm extends Model
{
    public $password;
    private $_user;
    public function rules()
    {
        return [
            ['password', 'required']
        ];
    }
    public function attributeLabels()
    {
        return [
            'password' => 'Password'
        ];
    }

    public function __construct($key, $config = [])
    {
        if(empty($key) || !is_string($key))
            throw new InvalidParamException('The key can not be empty.');
        $this->_user = User::findBySecretKey($key);
        if(!$this->_user)
            throw new InvalidParamException('Incorrect key.');
        parent::__construct($config);
    }

    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removeSecretKey();
        return $user->save();
    }

}

?>