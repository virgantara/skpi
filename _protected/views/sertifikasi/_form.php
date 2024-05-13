<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SimakSertifikasi */
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
            <label class="col-sm-3 control-label no-padding-right">Nim</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'nim')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Jenis sertifikasi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'jenis_sertifikasi')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Lembaga sertifikasi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'lembaga_sertifikasi')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Nomor registrasi sertifikasi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'nomor_registrasi_sertifikasi')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Nomor sk sertifikasi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'nomor_sk_sertifikasi')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Tahun sertifikasi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'tahun_sertifikasi')->textInput()->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Tmt sertifikasi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'tmt_sertifikasi')->textInput()->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Tst sertifikasi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'tst_sertifikasi')->textInput()->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">File path</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'file_path')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Status validasi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'status_validasi')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Approved by</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'approved_by')->textInput()->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Catatan</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'catatan')->textarea(['rows' => 6])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Updated at</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'updated_at')->textInput()->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Created at</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'created_at')->textInput()->label(false) ?>

            
            </div>
        </div>
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary waves-effect']) ?>
    
    <?php ActiveForm::end(); ?>

</div>
