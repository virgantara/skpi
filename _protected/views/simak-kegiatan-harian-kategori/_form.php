<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatanHarianKategori */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="simak-kegiatan-harian-kategori-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
