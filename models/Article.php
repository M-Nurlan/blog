<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\Security;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "article".
 *
 * @property int $article_id
 * @property string $title
 * @property int $user_id
 */
class Article extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'user_id', 'user_name'], 'required'],
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function setUserId()
    {
        return $this->user_id = Yii::$app->user->identity['id'];
    }

    public function setUserName()
    {
        return $this->user_name = Yii::$app->user->identity['name'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'article_id' => 'Article ID',
            'title' => 'Title',
            'user_id' => 'User ID',
            'user_name' => 'Nickname',
        ];
    }

    public static function findIdentity($article_id)
    {
        return static::findOne(['article_id' => $article_id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {

    }

    public function getId()
    {
        return $this->article_id;
    }

    public static function getUserId()
    {
        return static::findOne(['user_id' => $user_id]);
    }

    public function getAuthKey()
    {

    }

    public function validateAuthKey($authKey)
    {

    }
}
