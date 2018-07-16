<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\models\Section;

/* @var $this yii\web\View */
/* @var $model app\models\ImagesSelect */
/* @var $form ActiveForm */
?>
<div class="imageselect">

    <?php $form = ActiveForm::begin([
        'id' => 'select_form',
        'options' => ['class' => 'form-horizontal'],
        'method' => 'get',
        'action' => ['/site/index'],
    ]); ?>
    <label class="control-label">Дата события</label>
    <?php
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'selectDate',
        'options' => ['placeholder' => 'Выбериьте дату когда сделан снимок ...'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
    ]);
    ?>

    <?= $form->field($model, 'selectSection', ['options' => ['class' => '']])->dropDownList(['' => 'Все'] + Section::getAllSections()) ?>

    <div class="">
        <?= Html::submitButton('Отобрать', ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- imageselect -->
