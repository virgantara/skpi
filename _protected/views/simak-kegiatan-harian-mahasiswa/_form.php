<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatanHarianMahasiswa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="simak-kegiatan-harian-mahasiswa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nim')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tahun_akademik')->textInput() ?>

    <?= $form->field($model, 'kode_kegiatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kegiatan_rutin_id')->textInput() ?>

    <?= $form->field($model, 'poin')->textInput() ?>

    <?= $form->field($model, 'waktu')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
