<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="body">

    <?php $form = ActiveForm::begin([
    	'options' => [
            'id' => 'form_validation',
    	]
    ]); ?>



        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Nama kegiatan</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'nama_kegiatan')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Sub kegiatan</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'sub_kegiatan')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Nilai</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'nilai')->textInput()->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Sk unida siman</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'sk_unida_siman')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Sk unida cabang</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'sk_unida_cabang')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Id jenis kegiatan</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'id_jenis_kegiatan')->textInput()->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Is active</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'is_active')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Created at</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'created_at')->textInput()->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Updated at</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'updated_at')->textInput()->label(false) ?>

            
            </div>
        </div>
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary waves-effect']) ?>
    
    <?php ActiveForm::end(); ?>

</div>
