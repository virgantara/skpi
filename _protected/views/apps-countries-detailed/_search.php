<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AppsCountriesDetailedSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apps-countries-detailed-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'countryCode') ?>

    <?= $form->field($model, 'countryName') ?>

    <?= $form->field($model, 'currencyCode') ?>

    <?= $form->field($model, 'fipsCode') ?>

    <?php // echo $form->field($model, 'isoNumeric') ?>

    <?php // echo $form->field($model, 'north') ?>

    <?php // echo $form->field($model, 'south') ?>

    <?php // echo $form->field($model, 'east') ?>

    <?php // echo $form->field($model, 'west') ?>

    <?php // echo $form->field($model, 'capital') ?>

    <?php // echo $form->field($model, 'continentName') ?>

    <?php // echo $form->field($model, 'continent') ?>

    <?php // echo $form->field($model, 'languages') ?>

    <?php // echo $form->field($model, 'isoAlpha3') ?>

    <?php // echo $form->field($model, 'geonameId') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
