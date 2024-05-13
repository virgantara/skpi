<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SkpiPermohonan */
/* @var $form yii\widgets\ActiveForm */

$list_status_pengajuan = \app\helpers\MyHelper::getStatusPengajuan();
?>

<div class="body">

    <?php $form = ActiveForm::begin([
    	'options' => [
            'id' => 'form_validation',
    	]
    ]); ?>


    <?= $form->field($model, 'status_pengajuan')->dropDownList($list_status_pengajuan)?>
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary waves-effect']) ?>
    
    <?php ActiveForm::end(); ?>

</div>
