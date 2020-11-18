<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MahasiswaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Mahasiswas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-mastermahasiswa-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nim_mhs',
            'nama_mahasiswa',
            'tempat_lahir',
            'tgl_lahir',
            [
                'attribute' => 'jenis_kelamin',
                'label' => 'JK',
                'format' => 'raw',
                'filter'=>['L'=>'Laki-laki','P'=>'Perempuan'],
                'value'=>function($model,$url){
                    return $model->jenis_kelamin;
                    
                },
            ],
            [
                'attribute' => 'namaKampus',
                'label' => 'Kelas',
                'format' => 'raw',
                'filter'=>$listKampus,
                'value'=>function($model,$url){
                    return $model->namaKampus;
                    
                },
            ],
            [
        'attribute' => 'namaFakultas',
        'label' => 'Fakultas',
        'format' => 'raw',
        'filter'=>$fakultas,
        'value'=>function($model,$url){
            return $model->namaFakultas;
            
        },
    ],
   [
        'attribute' => 'namaProdi',
        'label' => 'Prodi',
        'format' => 'raw',
        'filter'=>$prodis,
        'value'=>function($model,$url){
            return $model->namaProdi;
            
        },
    ],
             [
        'attribute' => 'status_aktivitas',
        'label' => 'Status Aktif',
        'format' => 'raw',
        'filter'=>$status_aktif,
        'value'=>function($model,$url){
            return $model->status_aktivitas;
            
        },
    ],
            'semester',
            
            // 'kampus',
            // 'kode_fakultas',
            // 'kode_prodi',
            // 'id',
            // 'kode_pt',         
            // 'kode_jenjang_studi',
            //'tahun_masuk',
            //'semester_awal',
            //'batas_studi',
            //'asal_propinsi',
            //'tgl_masuk',
            //'tgl_lulus',
            //'status_aktivitas',
            //'status_awal',
            //'jml_sks_diakui',
            //'nim_asal',
            //'asal_pt',
            //'nama_asal_pt',
            //'asal_jenjang_studi',
            //'asal_prodi',
            //'kode_biaya_studi',
            //'kode_pekerjaan',
            //'tempat_kerja',
            //'kode_pt_kerja',
            //'kode_ps_kerja',
            //'nip_promotor',
            //'nip_co_promotor1',
            //'nip_co_promotor2',
            //'nip_co_promotor3',
            //'nip_co_promotor4',
            //'photo_mahasiswa',
            //'semester',
            //'keterangan:ntext',
            //'status_bayar',
            //'telepon',
            //'hp',
            //'email:email',
            //'alamat',
            //'berat',
            //'tinggi',
            //'ktp',
            //'rt',
            //'rw',
            //'dusun',
            //'kode_pos',
            //'desa',
            //'kecamatan',
            //'kecamatan_feeder',
            //'jenis_tinggal',
            //'penerima_kps',
            //'no_kps',
            //'provinsi',
            //'kabupaten',
            //'status_warga',
            //'warga_negara',
            //'warga_negara_feeder',
            //'status_sipil',
            //'agama',
            //'gol_darah',
            //'masuk_kelas',
            //'tgl_sk_yudisium',
            //'no_ijazah',
            //'status_mahasiswa',
            //'jur_thn_smta',
            //'is_synced',
            //'kode_pd',
            //'va_code',
            //'is_eligible',
            //'kamar_id',
            //'created_at',
            //'updated_at',

            [
                'class'     => 'yii\grid\ActionColumn',
                'template'  => '{view} {update}',
            ],
        ],
    ]); ?>
</div>
    <?php Pjax::end(); ?>   

</div>
