<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SimakKabupaten */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="simak-kabupaten-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_provinsi')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\SimakPropinsi::find()->orderBy(['id'=>SORT_ASC])->all(),'id',function($data){
        return $data->id.' - '.$data->prov;
    })) ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kab')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>

    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
