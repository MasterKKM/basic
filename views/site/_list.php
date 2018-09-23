<?php
/* @var $model app\models\Image */

use yii\helpers\Url;

?>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 6px;">
    <a href="<?= Url::to(['/image/load', 'name' => 'image_' . $model->id . '.png']) ?>" class="thumbnail">
        <img src="<?= Url::to(['/image/load', 'name' => 'image_' . $model->id . '_1.png']) ?>"/>
    </a>
    <div class="bg-primary cards_element_date"><?= $model->event_date ?></div>
    <div class="bg-primary cards_element_image"><a
                href="<?= Url::to(['/image/load', 'name' => 'image_' . $model->id . '.png']) ?>"
                class="btn btn-success btn-xs btn-block">Скачать</a></div>
    <div class="cards_element_info cards_element_bg"><?= $model->text ?></div>
    <div class="cards_element_bg"></div>
</div>
