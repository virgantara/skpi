<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimakMagang $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simak-magang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nim')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jenis_magang_id')->textInput() ?>

    <?= $form->field($model, 'nama_instansi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat_instansi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telp_instansi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_instansi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_pembina_instansi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jabatan_pembina_instansi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kota_instansi')->textInput() ?>

    <?= $form->field($model, 'is_dalam_negeri')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_mulai_magang')->textInput() ?>

    <?= $form->field($model, 'tanggal_selesai_magang')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pembimbing_id')->textInput() ?>

    <?= $form->field($model, 'status_magang_id')->textInput() ?>

    <?= $form->field($model, 'file_laporan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nilai_angka')->textInput() ?>

    <?= $form->field($model, 'nilai_huruf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'matakuliah_id')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
