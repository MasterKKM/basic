<?php

use newerton\fancybox\FancyBox;
use \yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $selectModel app\models\ImagesSelect */

$this->title = 'My Yii Application';
?>
    <div class="site-index">

        <div>
            <?php
            if (!Yii::$app->user->isGuest) {
                echo $this->render('_imageselect', [
                    'model' => $selectModel,
                ]);
            }
            ?>
        </div>

        <div class="body-content">

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                </div>
                <?php
                echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_list',
                    'layout' => '{summary}{items}<div class="clearfix"></div>{pager}'
                ]);
                ?>
            </div>
        </div>
    </div>
<?php
echo FancyBox::widget([
    'target' => '.thumbnail',
]);
?>