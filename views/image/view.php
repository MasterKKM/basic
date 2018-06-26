<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Image */

$this->title = $model->file_name;
$this->params['breadcrumbs'][] = ['label' => 'Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить это изображение?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <?php
            echo '<img class="img-responsive" src="' . Url::to(['/image/load', 'name' => 'image_' . $model->id . '_1.png']) . '" />';
            ?>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'event_date',
                    [
                        'attribute' => 'user_id',
                        'value' => function ($data) {
                            return $data->user->username;
                        }
                    ],
                    'file_name',
                    [
                        'attribute' => 'free',
                        'value' => function ($data) {
                            return ($data->free) ? 'Все' : 'Только зарегистрированные';
                        }
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="text-left top-3"><?= $model->text ?></div>
</div>
