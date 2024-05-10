<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SkpiPermohonan */
/* @var $form yii\widgets\ActiveForm */

$list_status_pengajuan = [
    '0' =>'BELUM DISETUJUI',
    '1' =>'DISETUJUI',
    '2' =>'DITOLAK'
];
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
