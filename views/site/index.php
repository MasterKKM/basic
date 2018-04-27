<?php

use yii\helpers\Html;
use newerton\fancybox\FancyBox;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Yii Application';
?>
    <div class="site-index">

        <div class="jumbotron">
            <h1>Галерея!</h1>

            <p class="lead">Это глалерея она показывается только зарегрстрированным пользователям!.</p>

        </div>

        <div class="body-content">

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                </div>
                <?php
                $dataProvider = new \yii\data\ActiveDataProvider([
                    'query' => \app\models\Image::find(),
                    'pagination' => [
                        'pageSize' => 6,
                    ],
                ]);
                echo \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_list',
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