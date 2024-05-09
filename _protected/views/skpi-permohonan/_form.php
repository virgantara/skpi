<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SkpiPermohonan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="body">

    <?php $form = ActiveForm::begin([
    	'options' => [
            'id' => 'form_validation',
    	]
    ]); ?>


    <?= $form->field($model, 'nim')->textInput(['maxlength' => true])?>
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary waves-effect']) ?>
    
    <?php ActiveForm::end(); ?>

</div>
