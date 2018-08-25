<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ArticleForm extends Model
{
	public $title;
	public $user_id;

	public function rules()
	{
		return [
			[['title'], 'required']
		];
	}

	public function createArticle()
	{
		$article = new Article();
		$article->title = $this->title;
		$article->user_id = Yii::$app->user->identity['id'];
		return $article->save();
	}
}