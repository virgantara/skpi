<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Countries */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="countries-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iso3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iso2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phonecode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'capital')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'native')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emoji')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emojiU')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'flag')->textInput() ?>

    <?= $form->field($model, 'wikiDataId')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
