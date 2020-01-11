<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\KategoriHukuman;
/* @var $this yii\web\View */
/* @var $model app\models\Hukuman */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hukuman-form">

    <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'kategori_id')->dropDownList(ArrayHelper::map(KategoriHukuman::find()->all(),'id','nama')) ?>
    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
