<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CountriesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="countries-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'iso3') ?>

    <?= $form->field($model, 'iso2') ?>

    <?= $form->field($model, 'phonecode') ?>

    <?php // echo $form->field($model, 'capital') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'native') ?>

    <?php // echo $form->field($model, 'emoji') ?>

    <?php // echo $form->field($model, 'emojiU') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <?php // echo $form->field($model, 'wikiDataId') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
