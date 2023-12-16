<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimakLayananSuratSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simak-layanan-surat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'jenis_surat') ?>

    <?= $form->field($model, 'nim') ?>

    <?= $form->field($model, 'tahun_id') ?>

    <?= $form->field($model, 'keperluan') ?>

    <?php // echo $form->field($model, 'bahasa') ?>

    <?php // echo $form->field($model, 'tanggal_diajukan') ?>

    <?php // echo $form->field($model, 'tanggal_disetujui') ?>

    <?php // echo $form->field($model, 'nomor_surat') ?>

    <?php // echo $form->field($model, 'nama_pejabat') ?>

    <?php // echo $form->field($model, 'nip') ?>

    <?php // echo $form->field($model, 'status_ajuan') ?>

    <?php // echo $form->field($model, 'file_path') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
