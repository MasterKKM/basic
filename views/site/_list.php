<?php
/* @var $model app\models\Image */

use yii\helpers\Url;
?>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <a href="<?=Url::to(['/image/load', 'name' => 'image_' . $model->id . '.png']) ?>" "rel" = "fancybox" class="thumbnail">
        <img src="<?=Url::to(['/image/load', 'name' => 'image_' . $model->id . '_1.png']) ?>" />
    </a>
</div>
