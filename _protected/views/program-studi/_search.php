<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProgramStudiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="program-studi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kode_fakultas') ?>

    <?= $form->field($model, 'kode_jurusan') ?>

    <?= $form->field($model, 'kode_prodi') ?>

    <?= $form->field($model, 'kode_prodi_dikti') ?>

    <?php // echo $form->field($model, 'kode_jenjang_studi') ?>

    <?php // echo $form->field($model, 'gelar_lulusan') ?>

    <?php // echo $form->field($model, 'gelar_lulusan_en') ?>

    <?php // echo $form->field($model, 'gelar_lulusan_short') ?>

    <?php // echo $form->field($model, 'nama_prodi') ?>

    <?php // echo $form->field($model, 'nama_prodi_en') ?>

    <?php // echo $form->field($model, 'domain_email') ?>

    <?php // echo $form->field($model, 'semester_awal') ?>

    <?php // echo $form->field($model, 'no_sk_dikti') ?>

    <?php // echo $form->field($model, 'tgl_sk_dikti') ?>

    <?php // echo $form->field($model, 'tgl_akhir_sk_dikti') ?>

    <?php // echo $form->field($model, 'jml_sks_lulus') ?>

    <?php // echo $form->field($model, 'kode_status') ?>

    <?php // echo $form->field($model, 'tahun_semester_mulai') ?>

    <?php // echo $form->field($model, 'email_prodi') ?>

    <?php // echo $form->field($model, 'tgl_pendirian_program_studi') ?>

    <?php // echo $form->field($model, 'no_sk_akreditasi') ?>

    <?php // echo $form->field($model, 'tgl_sk_akreditasi') ?>

    <?php // echo $form->field($model, 'tgl_akhir_sk_akreditasi') ?>

    <?php // echo $form->field($model, 'kode_status_akreditasi') ?>

    <?php // echo $form->field($model, 'frekuensi_kurikulum') ?>

    <?php // echo $form->field($model, 'pelaksanaan_kurikulum') ?>

    <?php // echo $form->field($model, 'nidn_ketua_prodi') ?>

    <?php // echo $form->field($model, 'telp_ketua_prodi') ?>

    <?php // echo $form->field($model, 'fax_prodi') ?>

    <?php // echo $form->field($model, 'nama_operator') ?>

    <?php // echo $form->field($model, 'hp_operator') ?>

    <?php // echo $form->field($model, 'telepon_program_studi') ?>

    <?php // echo $form->field($model, 'singkatan') ?>

    <?php // echo $form->field($model, 'kode_feeder') ?>

    <?php // echo $form->field($model, 'kode_nim') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
