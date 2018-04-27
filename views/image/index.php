<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Image', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'content' => function ($data) {
                    return '<img src="' . Url::to(['/image/load', 'name' => 'image_' . $data->id . '_0.png']) . '" />';
                }
            ],
            [
                'attribute' => 'user_id',
                'content' => function ($data) {
                    return $data->user->username;
                }
            ],
            [
                'attribute' => 'free',
                'value' => function ($data) {
                    return ($data->free) ? 'Все' : 'Только зарегистрированные';
                }
            ],
            'file_name',
            'text:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
