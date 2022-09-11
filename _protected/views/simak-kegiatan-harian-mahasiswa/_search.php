<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatanHarianMahasiswaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="simak-kegiatan-harian-mahasiswa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nim') ?>

    <?= $form->field($model, 'tahun_akademik') ?>

    <?= $form->field($model, 'kode_kegiatan') ?>

    <?= $form->field($model, 'kegiatan_rutin_id') ?>

    <?php // echo $form->field($model, 'poin') ?>

    <?php // echo $form->field($model, 'waktu') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
