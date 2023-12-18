<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimakSyaratBebasAsrama $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simak-syarat-bebas-asrama-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_aktif')->radioList(['Y' => 'Aktif','N'=>'Non-Aktif']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
