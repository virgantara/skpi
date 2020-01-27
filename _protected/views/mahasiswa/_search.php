<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MahasiswaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="simak-mastermahasiswa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kode_pt') ?>

    <?= $form->field($model, 'kode_fakultas') ?>

    <?= $form->field($model, 'kode_prodi') ?>

    <?= $form->field($model, 'kode_jenjang_studi') ?>

    <?php // echo $form->field($model, 'nim_mhs') ?>

    <?php // echo $form->field($model, 'nama_mahasiswa') ?>

    <?php // echo $form->field($model, 'tempat_lahir') ?>

    <?php // echo $form->field($model, 'tgl_lahir') ?>

    <?php // echo $form->field($model, 'jenis_kelamin') ?>

    <?php // echo $form->field($model, 'tahun_masuk') ?>

    <?php // echo $form->field($model, 'semester_awal') ?>

    <?php // echo $form->field($model, 'batas_studi') ?>

    <?php // echo $form->field($model, 'asal_propinsi') ?>

    <?php // echo $form->field($model, 'tgl_masuk') ?>

    <?php // echo $form->field($model, 'tgl_lulus') ?>

    <?php // echo $form->field($model, 'status_aktivitas') ?>

    <?php // echo $form->field($model, 'status_awal') ?>

    <?php // echo $form->field($model, 'jml_sks_diakui') ?>

    <?php // echo $form->field($model, 'nim_asal') ?>

    <?php // echo $form->field($model, 'asal_pt') ?>

    <?php // echo $form->field($model, 'nama_asal_pt') ?>

    <?php // echo $form->field($model, 'asal_jenjang_studi') ?>

    <?php // echo $form->field($model, 'asal_prodi') ?>

    <?php // echo $form->field($model, 'kode_biaya_studi') ?>

    <?php // echo $form->field($model, 'kode_pekerjaan') ?>

    <?php // echo $form->field($model, 'tempat_kerja') ?>

    <?php // echo $form->field($model, 'kode_pt_kerja') ?>

    <?php // echo $form->field($model, 'kode_ps_kerja') ?>

    <?php // echo $form->field($model, 'nip_promotor') ?>

    <?php // echo $form->field($model, 'nip_co_promotor1') ?>

    <?php // echo $form->field($model, 'nip_co_promotor2') ?>

    <?php // echo $form->field($model, 'nip_co_promotor3') ?>

    <?php // echo $form->field($model, 'nip_co_promotor4') ?>

    <?php // echo $form->field($model, 'photo_mahasiswa') ?>

    <?php // echo $form->field($model, 'semester') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'status_bayar') ?>

    <?php // echo $form->field($model, 'telepon') ?>

    <?php // echo $form->field($model, 'hp') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'alamat') ?>

    <?php // echo $form->field($model, 'berat') ?>

    <?php // echo $form->field($model, 'tinggi') ?>

    <?php // echo $form->field($model, 'ktp') ?>

    <?php // echo $form->field($model, 'rt') ?>

    <?php // echo $form->field($model, 'rw') ?>

    <?php // echo $form->field($model, 'dusun') ?>

    <?php // echo $form->field($model, 'kode_pos') ?>

    <?php // echo $form->field($model, 'desa') ?>

    <?php // echo $form->field($model, 'kecamatan') ?>

    <?php // echo $form->field($model, 'kecamatan_feeder') ?>

    <?php // echo $form->field($model, 'jenis_tinggal') ?>

    <?php // echo $form->field($model, 'penerima_kps') ?>

    <?php // echo $form->field($model, 'no_kps') ?>

    <?php // echo $form->field($model, 'provinsi') ?>

    <?php // echo $form->field($model, 'kabupaten') ?>

    <?php // echo $form->field($model, 'status_warga') ?>

    <?php // echo $form->field($model, 'warga_negara') ?>

    <?php // echo $form->field($model, 'warga_negara_feeder') ?>

    <?php // echo $form->field($model, 'status_sipil') ?>

    <?php // echo $form->field($model, 'agama') ?>

    <?php // echo $form->field($model, 'gol_darah') ?>

    <?php // echo $form->field($model, 'masuk_kelas') ?>

    <?php // echo $form->field($model, 'tgl_sk_yudisium') ?>

    <?php // echo $form->field($model, 'no_ijazah') ?>

    <?php // echo $form->field($model, 'status_mahasiswa') ?>

    <?php // echo $form->field($model, 'kampus') ?>

    <?php // echo $form->field($model, 'jur_thn_smta') ?>

    <?php // echo $form->field($model, 'is_synced') ?>

    <?php // echo $form->field($model, 'kode_pd') ?>

    <?php // echo $form->field($model, 'va_code') ?>

    <?php // echo $form->field($model, 'is_eligible') ?>

    <?php // echo $form->field($model, 'kamar_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
