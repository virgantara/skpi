<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SimakLayananSuratSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="body">

    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'form_validation',
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>

    <div class="alert alert-danger">
        <h3>Perhatian</h3>
        <ul>
            <li>Usahakan ukuran resolusi KOP Surat adalah lebar 980 pixel, tinggi 150 pixel</li>
            <li>Usahakan ukuran resolusi Tanda Tangan Digital Dekan/Direktur adalah lebar 260 pixel, tinggi 132 pixel</li>
            <li>Tipe file: JPG, JPEG, atau PNG</li>
        </ul>
    </div>

    <?= $form->field($model, 'file_header_path')->fileInput(['class' => 'form-control', 'maxlength' => true, 'accept' => 'image/png, image/jpg, image/jpeg']) ?>
    <?= $form->field($model, 'file_footer_path')->fileInput(['class' => 'form-control', 'maxlength' => true, 'accept' => 'image/png, image/jpg, image/jpeg']) ?>
    <?= $form->field($model, 'file_sign_path')->fileInput(['class' => 'form-control', 'maxlength' => true, 'accept' => 'image/png, image/jpg, image/jpeg']) ?>



    <?= Html::submitButton('Save', ['class' => 'btn btn-primary waves-effect']) ?>

    <?php ActiveForm::end(); ?>

</div>