<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CapaianPembelajaranLulusanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="capaian-pembelajaran-lulusan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kode') ?>

    <?= $form->field($model, 'jenis') ?>

    <?= $form->field($model, 'kode_prodi') ?>

    <?= $form->field($model, 'deskripsi') ?>

    <?php // echo $form->field($model, 'deskripsi_en') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'urutan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
