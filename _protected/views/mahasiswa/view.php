<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\MyHelper;
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
            'semester',
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
<div class="row">
      <div class="col-xs-12">
            <div class="space-20"></div>

                    <div class="widget-box transparent">
                        <div class="widget-header widget-header-small">
                            <h4 class="widget-title blue smaller">
                                <i class="ace-icon fa fa-rss orange"></i>
                                Recent Violations
                            </h4>

                            <div class="widget-toolbar action-buttons">
                                <a href="#" data-action="reload">
                                    <i class="ace-icon fa fa-refresh blue"></i>
                                </a>
&nbsp;
                                <a href="#" class="pink">
                                    <i class="ace-icon fa fa-trash-o"></i>
                                </a>
                            </div>
                        </div>
                        <?php 
                        foreach ($riwayat as $key => $value) {
                            # code...
                        
                        ?>
                        <div class="widget-body">
                            <div class="widget-main padding-8">
                                <div id="profile-feed-1" class="profile-feed">
                                    <div class="profile-activity clearfix">
                                        <div>
                                            <img class="pull-left" alt="<?=$mahasiswa['nama_mahasiswa'];?>'s avatar" src="<?=$this->theme->baseUrl;?>/images/avatars/avatar5.png" />
                                           <a class="user" href="#"><?=$model->nama_mahasiswa;?></a>
                                            melakukan pelanggaran <?=$value->pelanggaran->kategori->nama;?>
                                            yaitu <?=$value->pelanggaran->nama;?> pada tanggal <?=MyHelper::YmdtodmY($value->tanggal);?>

                                            <div class="time">
                                                <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                                <?=\app\helpers\MyHelper::hitungDurasi(date('Y-m-d H:i:s'),$value->created_at);?> yang lalu
                                            </div>
                                        </div>

                                        <div class="tools action-buttons">
                                            <a href="#" class="blue">
                                                <i class="ace-icon fa fa-pencil bigger-125"></i>
                                            </a>

                                            <a href="#" class="red">
                                                <i class="ace-icon fa fa-times bigger-125"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                         ?>

                    </div>
                    <div class="widget-box transparent">
                        <div class="widget-header widget-header-small">
                            <h4 class="widget-title blue smaller">
                                <i class="ace-icon fa fa-rss orange"></i>
                                Recent Payment
                            </h4>

                            <div class="widget-toolbar action-buttons">
                                <a href="#" data-action="reload">
                                    <i class="ace-icon fa fa-refresh blue"></i>
                                </a>
&nbsp;
                                <a href="#" class="pink">
                                    <i class="ace-icon fa fa-trash-o"></i>
                                </a>
                            </div>
                        </div>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pembayaran</th>
                                    <th>Tahun</th>
                                    <th>Status Pembayaran</th>
                                    <th>Last update</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php 
                        foreach ($riwayatPembayaran as $key => $value) 
                        {
                            # code...
                        
                        ?>
                        <tr>
                            <td><?=$key+1;?></td>
                            <td><?=$value['nama'];?></td>
                            <td><?=$value['tahun'];?></td>
                            <td><?php
                            $nilai = $value['nilai'];
                            $terbayar = $value['terbayar'];
                            $nilai_minimal = $value['nilai_minimal'];
                            if($terbayar >= $nilai)
                            {
                                echo '<button class="btn btn-success">LUNAS</button>';
                            }

                            else if($terbayar >= $nilai_minimal && $terbayar > 0)
                            {
                                echo '<button class="btn btn-success">CICILAN</button>';
                            }

                            else{
                                echo '<button class="btn btn-danger">BELUM LUNAS</button>';
                            }
                            
                             ?>
                                
                            </td>
                            <td><?=date('d/m/Y H:i:s',strtotime($value['updated_at']));?></td>
                        </tr>
                        
                        <?php
                    }
                         ?>
                     </tbody>
                     </table>
                    </div>
                         <div class="widget-box transparent">
                        <div class="widget-header widget-header-small">
                            <h4 class="widget-title blue smaller">
                                <i class="ace-icon fa fa-rss orange"></i>
                                Recent Dormitory Migrations
                            </h4>

                            <div class="widget-toolbar action-buttons">
                                <a href="#" data-action="reload">
                                    <i class="ace-icon fa fa-refresh blue"></i>
                                </a>
&nbsp;
                                <a href="#" class="pink">
                                    <i class="ace-icon fa fa-trash-o"></i>
                                </a>
                            </div>
                        </div>
                        <?php 
                        foreach ($riwayatKamar as $key => $value) {
                            # code...
                        
                        ?>
                        <div class="widget-body">
                            <div class="widget-main padding-8">
                                <div id="profile-feed-1" class="profile-feed">
                                    <div class="profile-activity clearfix">
                                        <div>
                                            <img class="pull-left" alt="<?=$mahasiswa['nama_mahasiswa'];?>'s avatar" src="<?=$this->theme->baseUrl;?>/images/avatars/avatar5.png" />
                                           <a class="user" href="#"><?=$model->nama_mahasiswa;?></a>
                                            pindah dari <?=$value->dariKamar->namaAsrama;?>
                                            kamar <?=$value->dariKamar->nama;?> ke <?=$value->kamar->namaAsrama;?>
                                            kamar <?=$value->kamar->nama;?> pada tanggal <?=MyHelper::YmdtodmY($value->created_at);?>

                                            <div class="time">
                                                <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                                <?=\app\helpers\MyHelper::hitungDurasi(date('Y-m-d H:i:s'),$value->created_at);?> yang lalu
                                            </div>
                                        </div>

                                       
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                         ?>

                    </div>
      </div>
</div>