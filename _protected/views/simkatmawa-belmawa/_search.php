<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaBelmawaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simkatmawa-belmawa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'simkatmawa_belmawa_kategori_id') ?>

    <?= $form->field($model, 'jenis_simkatmawa') ?>

    <?= $form->field($model, 'nama_kegiatan') ?>

    <?php // echo $form->field($model, 'peringkat') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'tahun') ?>

    <?php // echo $form->field($model, 'url_kegiatan') ?>

    <?php // echo $form->field($model, 'laporan_path') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
