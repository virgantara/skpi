<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimakMagangSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simak-magang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nim') ?>

    <?= $form->field($model, 'jenis_magang_id') ?>

    <?= $form->field($model, 'nama_instansi') ?>

    <?= $form->field($model, 'alamat_instansi') ?>

    <?php // echo $form->field($model, 'telp_instansi') ?>

    <?php // echo $form->field($model, 'email_instansi') ?>

    <?php // echo $form->field($model, 'nama_pembina_instansi') ?>

    <?php // echo $form->field($model, 'jabatan_pembina_instansi') ?>

    <?php // echo $form->field($model, 'kota_instansi') ?>

    <?php // echo $form->field($model, 'is_dalam_negeri') ?>

    <?php // echo $form->field($model, 'tanggal_mulai_magang') ?>

    <?php // echo $form->field($model, 'tanggal_selesai_magang') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'pembimbing_id') ?>

    <?php // echo $form->field($model, 'status_magang_id') ?>

    <?php // echo $form->field($model, 'file_laporan') ?>

    <?php // echo $form->field($model, 'nilai_angka') ?>

    <?php // echo $form->field($model, 'nilai_huruf') ?>

    <?php // echo $form->field($model, 'matakuliah_id') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
