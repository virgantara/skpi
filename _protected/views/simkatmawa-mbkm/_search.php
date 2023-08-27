<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMbkmSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simkatmawa-mbkm-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'jenis_simkatmawa') ?>

    <?= $form->field($model, 'nama_program') ?>

    <?= $form->field($model, 'tempat_pelaksanaan') ?>

    <?php // echo $form->field($model, 'tanggal_mulai') ?>

    <?php // echo $form->field($model, 'tanggal_selesai') ?>

    <?php // echo $form->field($model, 'penyelenggara') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'judul_penelitian') ?>

    <?php // echo $form->field($model, 'status_sks') ?>

    <?php // echo $form->field($model, 'sk_penerimaan_path') ?>

    <?php // echo $form->field($model, 'surat_tugas_path') ?>

    <?php // echo $form->field($model, 'rekomendasi_path') ?>

    <?php // echo $form->field($model, 'khs_pt_path') ?>

    <?php // echo $form->field($model, 'sertifikat_path') ?>

    <?php // echo $form->field($model, 'laporan_path') ?>

    <?php // echo $form->field($model, 'hasil_path') ?>

    <?php // echo $form->field($model, 'hasil_jenis') ?>

    <?php // echo $form->field($model, 'rekognisi_id') ?>

    <?php // echo $form->field($model, 'kategori_pembinaan_id') ?>

    <?php // echo $form->field($model, 'kategori_belmawa_id') ?>

    <?php // echo $form->field($model, 'url_berita') ?>

    <?php // echo $form->field($model, 'foto_penyerahan_path') ?>

    <?php // echo $form->field($model, 'foto_kegiatan_path') ?>

    <?php // echo $form->field($model, 'foto_karya_path') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
