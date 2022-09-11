<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SimakPropinsiBatas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="simak-propinsi-batas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode_prop')->textInput() ?>

    <?= $form->field($model, 'latitude')->textInput() ?>

    <?= $form->field($model, 'longitude')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
