<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMbkm $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simkatmawa-mbkm-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'jenis_simkatmawa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_program')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tempat_pelaksanaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_mulai')->textInput() ?>

    <?= $form->field($model, 'tanggal_selesai')->textInput() ?>

    <?= $form->field($model, 'penyelenggara')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'level')->textInput() ?>

    <?= $form->field($model, 'apresiasi')->textInput() ?>

    <?= $form->field($model, 'status_sks')->textInput() ?>

    <?= $form->field($model, 'sk_penerimaan_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surat_tugas_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rekomendasi_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'khs_pt_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sertifikat_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'laporan_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hasil_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hasil_jenis')->textInput() ?>

    <?= $form->field($model, 'rekognisi_id')->textInput() ?>

    <?= $form->field($model, 'kategori_pembinaan_id')->textInput() ?>

    <?= $form->field($model, 'kategori_belmawa_id')->textInput() ?>

    <?= $form->field($model, 'url_berita')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'foto_penyerahan_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'foto_kegiatan_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'foto_karya_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
