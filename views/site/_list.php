<?php
/* @var $model app\models\Image */

use yii\helpers\Url;

?>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <a href="<?= Url::to(['/image/load', 'name' => 'image_' . $model->id . '.png']) ?>" class="thumbnail">
        <img src="<?= Url::to(['/image/load', 'name' => 'image_' . $model->id . '_1.png']) ?>"/>
    </a>
    <div class="bg-primary"
         style="position: absolute; left: 20px; top: 5px; width: 85px;"><?= $model->event_date ?></div>
    <div class="bg-primary"
         style="position: absolute; right: 20px; top: 5px; width: 85px;"><a href="<?= Url::to(['/image/load', 'name' => 'image_' . $model->id . '.png']) ?>" class="btn btn-success btn-xs btn-block">Скачать</a></div>
    <div style="height: 60px;margin-top: -15px">
        <?= $model->text ?>
    </div>
</div>
