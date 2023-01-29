<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimakMagangCatatanSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simak-magang-catatan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'magang_id') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'rincian_kegiatan') ?>

    <?= $form->field($model, 'evaluasi') ?>

    <?php // echo $form->field($model, 'tindak_lanjut') ?>

    <?php // echo $form->field($model, 'catatan_pembimbing') ?>

    <?php // echo $form->field($model, 'is_approved') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
