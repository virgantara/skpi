<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimakMagangNilai $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simak-magang-nilai-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kriteria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nilai_angka')->textInput() ?>

    <?= $form->field($model, 'bobot')->textInput() ?>

    <?= $form->field($model, 'magang_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
