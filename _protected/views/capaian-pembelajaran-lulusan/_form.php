<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CapaianPembelajaranLulusan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="body">

    <?php $form = ActiveForm::begin([
    	'options' => [
            'id' => 'form_validation',
    	]
    ]); ?>



        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Id</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'id')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Kode</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'kode')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Jenis</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'jenis')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Kode prodi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'kode_prodi')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Deskripsi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'deskripsi')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Deskripsi en</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'deskripsi_en')->textarea(['rows' => 6])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">State</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'state')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Urutan</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'urutan')->textInput()->label(false) ?>

            
            </div>
        </div>
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary waves-effect']) ?>
    
    <?php ActiveForm::end(); ?>

</div>
