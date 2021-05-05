<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="simak-kegiatan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nama_kegiatan') ?>

    <?= $form->field($model, 'sub_kegiatan') ?>

    <?= $form->field($model, 'nilai') ?>

    <?= $form->field($model, 'sk_unida_siman') ?>

    <?php // echo $form->field($model, 'sk_unida_cabang') ?>

    <?php // echo $form->field($model, 'id_jenis_kegiatan') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
