<?php

use Yii;
use newerton\fancybox\FancyBox;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Yii Application';
?>
    <div class="site-index">

        <div class="jumbotron">
            <h1>Галерея!</h1>

            <p class="lead"><?= (Yii::$app->user->isGuest) ? 'Зарегистрированные пользователи увидят горадо больше...' : 'Эта часть глалерееи показывается только зарегрстрированным пользователям!' ?>
                .</p>

        </div>

        <div class="body-content">

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                </div>
                <?php
                echo \yii\widgets\ListView::widget([
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