<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimakUniversitasSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simak-universitas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'rektor') ?>

    <?= $form->field($model, 'alamat') ?>

    <?= $form->field($model, 'telepon') ?>

    <?= $form->field($model, 'fax') ?>

    <?php // echo $form->field($model, 'website') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'sk_rektor') ?>

    <?php // echo $form->field($model, 'tgl_sk_rektor') ?>

    <?php // echo $form->field($model, 'periode') ?>

    <?php // echo $form->field($model, 'status_aktif') ?>

    <?php // echo $form->field($model, 'catatan_resmi') ?>

    <?php // echo $form->field($model, 'catatan_resmi_en') ?>

    <?php // echo $form->field($model, 'deskripsi_skpi') ?>

    <?php // echo $form->field($model, 'deskripsi_skpi_en') ?>

    <?php // echo $form->field($model, 'nama_institusi') ?>

    <?php // echo $form->field($model, 'nama_institusi_en') ?>

    <?php // echo $form->field($model, 'sk_pendirian') ?>

    <?php // echo $form->field($model, 'tanggal_sk_pendirian') ?>

    <?php // echo $form->field($model, 'peringkat_akreditasi') ?>

    <?php // echo $form->field($model, 'nomor_sertifikat_akreditasi') ?>

    <?php // echo $form->field($model, 'lembaga_akreditasi') ?>

    <?php // echo $form->field($model, 'persyaratan_penerimaan') ?>

    <?php // echo $form->field($model, 'persyaratan_penerimaan_en') ?>

    <?php // echo $form->field($model, 'sistem_penilaian') ?>

    <?php // echo $form->field($model, 'sistem_penilaian_en') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
