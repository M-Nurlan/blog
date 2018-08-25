<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Article;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'user_name',
            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                'visible' => [
                    'update' => !Yii::$app->user->can('update', ['user_id' => Yii::$app->user->identity['id']]),
                    'delete' => !Yii::$app->user->can('delete', ['user_id' => Yii::$app->user->identity['id']]),
                ],
            ],
        ],
    ]); ?>
</div>
<?php 
$mod = Article::find()->asArray()->all();
for ($i = 0; $i<count($mod); $i++)
{
    echo $mod[$i]['user_id'];
}