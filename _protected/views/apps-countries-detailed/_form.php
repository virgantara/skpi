<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AppsCountriesDetailed */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apps-countries-detailed-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'countryCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'countryName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currencyCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fipsCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isoNumeric')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'north')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'south')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'east')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'west')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'capital')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'continentName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'continent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'languages')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isoAlpha3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'geonameId')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
