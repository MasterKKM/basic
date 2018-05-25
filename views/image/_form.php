<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Image */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="image-form">

        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <?php
                if ($model->isNewRecord) {
                    $url = '\no-photo.jpg';
                } else {
                    $url = Url::to(['/image/load', 'name' => 'image_' . $model->id . '_1.png']);
                }
                echo '<img id="photo" class="img-responsive" src="' . $url . '" />';
                ?>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'file')->fileInput() ?>
                <?= $form->field($model, 'text')->textarea() ?>
                <?= $form->field($model, 'free')->dropDownList([0 => 'Только зарегистрированные пользователи', 1 => 'Все']) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
<?php
$script = <<<SCRIPT
$("#image-file").change(function () {
    var file = this.files ? this.files[0] : {name : this.value};
    var fileReader = window.FileReader ? new FileReader : null;
    fileReader.addEventListener("loadend", function(e){
        $("#photo").attr('src', e.target.result);
}, false);
fileReader.readAsDataURL(file);
});
SCRIPT;

$this->registerJs($script, \yii\web\View::POS_READY);