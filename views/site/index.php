<?php

use newerton\fancybox\FancyBox;
use \yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Yii Application';
?>
    <div class="site-index">

        <div class="jumbotron">
            <h1>Галерея!</h1>
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