<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SyaratPenerimaan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="body">

    <?php $form = ActiveForm::begin([
    	'options' => [
            'id' => 'form_validation',
    	]
    ]); ?>



            <?= $form->field($model, 'jenjang_id')->dropDownList(ArrayHelper::map($list_pilihan,'id','label')) ?>

            <?= $form->field($model, 'keterangan')->textInput() ?>
            <?= $form->field($model, 'keterangan_en')->textInput() ?>

                <?= Html::submitButton('Save', ['class' => 'btn btn-primary waves-effect']) ?>
    
    <?php ActiveForm::end(); ?>

</div>
