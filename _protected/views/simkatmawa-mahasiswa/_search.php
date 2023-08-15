<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMahasiswaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simkatmawa-mahasiswa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'simkatmawa_mbkm_id') ?>

    <?= $form->field($model, 'simkatmawa_mandiri_id') ?>

    <?= $form->field($model, 'simkatmawa_belmawa_id') ?>

    <?= $form->field($model, 'nim') ?>

    <?php // echo $form->field($model, 'simkatmawa_non_lomba_id') ?>

    <?php // echo $form->field($model, 'nama') ?>

    <?php // echo $form->field($model, 'prodi') ?>

    <?php // echo $form->field($model, 'kampus') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
