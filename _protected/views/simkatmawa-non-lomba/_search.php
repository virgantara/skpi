<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaNonLombaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simkatmawa-non-lomba-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nama_kegiatan') ?>

    <?= $form->field($model, 'simkatmawa_kegiatan_id') ?>

    <?= $form->field($model, 'tanggal_mulai') ?>

    <?= $form->field($model, 'tanggal_selesai') ?>

    <?php // echo $form->field($model, 'laporan_path') ?>

    <?php // echo $form->field($model, 'url_kegiatan') ?>

    <?php // echo $form->field($model, 'foto_kegiatan_path') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
