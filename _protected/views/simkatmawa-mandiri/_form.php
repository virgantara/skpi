<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMandiri $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simkatmawa-mandiri-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nim')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_kegiatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'penyelenggara')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tempat_pelaksanaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'simkatmawa_rekognisi_id')->textInput() ?>

    <?= $form->field($model, 'level')->textInput() ?>

    <?= $form->field($model, 'apresiasi')->textInput() ?>

    <?= $form->field($model, 'url_kegiatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_mulai')->textInput() ?>

    <?= $form->field($model, 'tanggal_selesai')->textInput() ?>

    <?= $form->field($model, 'sertifikat_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'foto_penyerahan_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'foto_kegiatan_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'foto_karya_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surat_tugas_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'laporan_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
