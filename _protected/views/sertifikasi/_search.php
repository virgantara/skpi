<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SimakSertifikasiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="simak-sertifikasi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nim') ?>

    <?= $form->field($model, 'jenis_sertifikasi') ?>

    <?= $form->field($model, 'lembaga_sertifikasi') ?>

    <?= $form->field($model, 'nomor_registrasi_sertifikasi') ?>

    <?php // echo $form->field($model, 'nomor_sk_sertifikasi') ?>

    <?php // echo $form->field($model, 'tahun_sertifikasi') ?>

    <?php // echo $form->field($model, 'tmt_sertifikasi') ?>

    <?php // echo $form->field($model, 'tst_sertifikasi') ?>

    <?php // echo $form->field($model, 'file_path') ?>

    <?php // echo $form->field($model, 'status_validasi') ?>

    <?php // echo $form->field($model, 'approved_by') ?>

    <?php // echo $form->field($model, 'catatan') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
