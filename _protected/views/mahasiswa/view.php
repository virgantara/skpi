<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SimakMastermahasiswa */

$this->title = $model->nama_mahasiswa;
$this->params['breadcrumbs'][] = ['label' => 'Master Mahasiswas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="simak-mastermahasiswa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [           
            'nama_mahasiswa',
            'nim_mhs',
            'tempat_lahir',
            'tgl_lahir',
            'jenis_kelamin',
            'hp',
            'email:email',
            'kampus0.nama_kampus',
            'kodeFakultas.nama_fakultas',
            'kodeProdi.nama_prodi',
            'status_aktivitas',
            // 'status_mahasiswa',            
            // 'kampus',
            // 'kode_fakultas',
            // 'kode_prodi',
            // 'id',
            //'kode_pt',
            //'kode_jenjang_studi',
            // 'tahun_masuk',
            // 'semester_awal',
            // 'batas_studi',
            // 'asal_propinsi',
            // 'tgl_masuk',
            // 'tgl_lulus',            
            // 'status_awal',
            // 'jml_sks_diakui',
            // 'nim_asal',
            // 'asal_pt',
            // 'nama_asal_pt',
            // 'asal_jenjang_studi',
            // 'asal_prodi',
            // 'kode_biaya_studi',
            // 'kode_pekerjaan',
            // 'tempat_kerja',
            // 'kode_pt_kerja',
            // 'kode_ps_kerja',
            // 'nip_promotor',
            // 'nip_co_promotor1',
            // 'nip_co_promotor2',
            // 'nip_co_promotor3',
            // 'nip_co_promotor4',
            // 'photo_mahasiswa',
            // 'semester',
            // 'keterangan:ntext',
            // 'status_bayar',
            // 'telepon',          
            // 'alamat',
            // 'berat',
            // 'tinggi',
            // 'ktp',
            // 'rt',
            // 'rw',
            // 'dusun',
            // 'kode_pos',
            // 'desa',
            // 'kecamatan',
            // 'kecamatan_feeder',
            // 'jenis_tinggal',
            // 'penerima_kps',
            // 'no_kps',
            // 'provinsi',
            // 'kabupaten',
            // 'status_warga',
            // 'warga_negara',
            // 'warga_negara_feeder',
            // 'status_sipil',
            // 'agama',
            // 'gol_darah',
            // 'masuk_kelas',
            // 'tgl_sk_yudisium',
            // 'no_ijazah',
            // 'jur_thn_smta',
            // 'is_synced',
            // 'kode_pd',
            // 'va_code',
            // 'is_eligible',
            // 'kamar_id',
            // 'created_at',
            // 'updated_at',
        ],
    ]) ?>

</div>
