<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimakMagangCatatan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simak-magang-catatan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'magang_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal')->textInput() ?>

    <?= $form->field($model, 'rincian_kegiatan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'evaluasi')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tindak_lanjut')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'catatan_pembimbing')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_approved')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
