<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SimakMagang */
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
            <label class="col-sm-3 control-label no-padding-right">Jenis magang</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'jenis_magang_id')->textInput()->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Nama instansi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'nama_instansi')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Alamat instansi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'alamat_instansi')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Telp instansi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'telp_instansi')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Email instansi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'email_instansi')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Nama pembina instansi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'nama_pembina_instansi')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Jabatan pembina instansi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'jabatan_pembina_instansi')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Kota instansi</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'kota_instansi')->textInput()->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Is dalam negeri</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'is_dalam_negeri')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Tanggal mulai magang</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'tanggal_mulai_magang')->textInput()->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Tanggal selesai magang</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'tanggal_selesai_magang')->textInput()->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Status</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'status')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Keterangan</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'keterangan')->textarea(['rows' => 6])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Pembimbing</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'pembimbing_id')->textInput()->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Status magang</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'status_magang_id')->textInput()->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">File laporan</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'file_laporan')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Nilai angka</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'nilai_angka')->textInput()->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Nilai huruf</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'nilai_huruf')->textInput(['maxlength' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Matakuliah</label>
        <div class="col-sm-9">
            <?= $form->field($model, 'matakuliah_id')->textInput()->label(false) ?>

            
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
