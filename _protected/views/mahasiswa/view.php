<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\MyHelper;
use app\models\SimakPropinsi;
use app\models\SimakKabupaten;

/* @var $this yii\web\View */
/* @var $model app\models\SimakMastermahasiswa */

$this->title = $model->nama_mahasiswa;
$this->params['breadcrumbs'][] = ['label' => 'Master Mahasiswas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


$kabupaten = SimakKabupaten::find()->where(['id'=>$model->kabupaten])->one();
$provinsi = SimakPropinsi::find()->where(['id'=>$model->provinsi])->one();
?>
<div class="simak-mastermahasiswa-view">

    <h1><?= Html::encode($this->title) ?></h1>
     <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

<p>        
<div class="row">
    <div class="col-xs-12 text-center">
        <img width="300px" height="400px" src="<?=$model->foto_path;?>"/>
    </div>
</div>
</p>
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
            [
                'attribute' => 'konsulat',
                'value' => function($data){
                    return !empty($data->konsulat0) ? $data->konsulat0->name.' - '.$data->konsulat0->state->name.' - '.$data->konsulat0->country->name : 'not set';
                }
            ],  
            [
                'attribute' => 'kamar_id',
                'value' => function($data){
                    return !empty($data->kamar) ? $data->kamar->asrama->nama.' - '.$data->kamar->nama : 'not set';
                }
            ],            
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
                                            <img class="pull-left" alt="<?=$model->nama_mahasiswa;?>'s avatar" src="<?=$this->theme->baseUrl;?>/images/avatars/avatar5.png" />
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
                                            <img class="pull-left" alt="<?=$model['nama_mahasiswa'];?>'s avatar" src="<?=$this->theme->baseUrl;?>/images/avatars/avatar5.png" />
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

                    <div class="widget-box transparent">
                        <div class="widget-header widget-header-small">
                            <h4 class="widget-title blue smaller">
                                <i class="ace-icon fa fa-rss orange"></i>
                                Nilai Raport Kesantrian
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
                        <div class="kesantrian table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <h3><strong>NILAI RAPORT KEMAHASISWAAN</strong></h3>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">
                                            <h4><strong>A. Data Pribadi Mahasiswa</strong></h4>
                                        </td>                                    
                                    </tr>
                                    <tr class="success">
                                        <td>1.</td>
                                        <td>Nama</td>
                                        <td><?= $model->nama_mahasiswa?></td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Nama Arab</td>
                                        <td><?= $model->nama_mahasiswa?></td>
                                    </tr>
                                    <tr class="success">
                                        <td>3.</td>
                                        <td>No KTP</td>
                                        <td><?= $model->ktp?></td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Kewarganegaraan</td>
                                        <td><?= $model->labelNegara()?></td>
                                    </tr>
                                    <tr class="success">
                                        <td>5.</td>
                                        <td colspan="2">Alamat Lengkap</td>
                                    </tr>
                                    <tr>
                                        <td class="center">a.</td>
                                        <td>Jalan</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="center">b.</td>
                                        <td>No Rumah</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="center">c.</td>
                                        <td>RT / RW</td>
                                        <td>RT <?= $model->rt ?> RW <?= $model->rw ?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">d.</td>
                                        <td>Desa/Kel/Dusun</td>
                                        <td>DUSUN <?= strtoupper($model->dusun)?> DESA <?= strtoupper($model->desa)?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">e.</td>
                                        <td>Kecamatan</td>
                                        <td><?= $model->kecamatan?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">f.</td>
                                        <td>Kab/Kodya</td>
                                        <td><?= !empty($kabupaten) ? $kabupaten->kab : ''?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">g.</td>
                                        <td>Provinsi</td>
                                        <td><?= !empty($provinsi) ? $provinsi->prov : ''?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">h.</td>
                                        <td>Kode POS</td>
                                        <td><?= $model->kode_pos?></td>
                                    </tr>
                                    <tr class="success">
                                        <td>6.</td>
                                        <td>Contact</td>
                                        <td><?= $model->hp?> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <h4><strong>B. Data Keluarga</strong></h4>
                                        </td>
                                    </tr>
                                <?php foreach ($model->ortuAyah as $row) { ?>
                                    <tr class="success">
                                        <td>1.</td>
                                        <td colspan="2">Ayah</td>  
                                    </tr>
                                    <tr>
                                        <td class="center">a.</td>
                                        <td>Nama</td>
                                        <td><?= strtoupper($row['nama']) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">b.</td>
                                        <td>Pekerjaan</td>
                                        <td><?= $row['namaPekerjaan']->label ?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">c.</td>
                                        <td>Pendidikan Terakhir</td>
                                        <td><?= $row['namaPendidikan']->label ?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">d.</td>
                                        <td>Kewarganegaraan</td>
                                        <td><?= strtoupper($row['negara']) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">e.</td>
                                        <td>Kedudukan di Masyarakat</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="center">f.</td>
                                        <td>Contact</td>
                                        <td>TELP : <?= $row['telepon'] ?> / HP : <?= $row['hp'] ?></td>
                                    </tr>
                                <?php } ?>
                                    <tr class="success">
                                        <td>2.</td>
                                        <td colspan="2">Ibu</td>
                                    </tr>
                                <?php foreach ($model->ortuIbu as $row) { ?>
                                    <tr>
                                        <td class="center">a.</td>
                                        <td>Nama</td>
                                        <td><?= strtoupper($row['nama']) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">b.</td>
                                        <td>Pekerjaan</td>
                                        <td><?= $row['namaPekerjaan']->label ?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">c.</td>
                                        <td>Pendidikan Terakhir</td>
                                        <td><?= $row['namaPendidikan']->label ?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">d.</td>
                                        <td>Kewarganegaraan</td>
                                        <td><?= strtoupper($row['negara']) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">e.</td>
                                        <td>Kedudukan di Masyarakat</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="center">f.</td>
                                        <td>Contact</td>
                                        <td>TELP : <?= $row['telepon'] ?> / HP : <?= $row['hp'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">g.</td>
                                        <td>Anak ke</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="center">h.</td>
                                        <td>Yang Membiayai Pendidikan</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="center">i.</td>
                                        <td>Kesanggupan Membiayai</td>
                                        <td></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($model->ortuWali)) { ?>
                                    <tr class="success">
                                        <td>1.</td>
                                        <td colspan="2">Wali</td>  
                                    </tr>
                                    <tr>
                                        <td class="center">a.</td>
                                        <td>Nama</td>
                                        <td><?= $row['nama'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">b.</td>
                                        <td>Pekerjaan</td>
                                        <td><?= $row['namaPekerjaan']->label ?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">c.</td>
                                        <td>Pendidikan Terakhir</td>
                                        <td><?= $row['namaPendidikan']->label ?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">d.</td>
                                        <td>Kewarganegaraan</td>
                                        <td><?= strtoupper($row['negara']) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="center">e.</td>
                                        <td>Kedudukan di Masyarakat</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="center">f.</td>
                                        <td>Contact</td>
                                        <td>TELP : <?= $row['telepon'] ?> / HP : <?= $row['hp'] ?></td>
                                    </tr>
                                <?php }
                                else{
                                ?>
                                    <tr class="success">
                                        <td>3.</td>
                                        <td>Wali</td>
                                        <td> Tidak Ada Wali</td>
                                    </tr>
                                <?php 
                                }

                                ?>
                                </tbody>
                            </table>
   
                            <table class="table table-bordered">
                                <h4><strong>D. Riwayat Perkulihan</strong></h4>
                                <?php if (!empty($dataKrs)) { ?>
                                <thead>
                                    
                                     <tr align="center" class="success">
                                        <td><strong>SEMESTER</strong></td>
                                        <td><strong>TAHUN AKADEMIK</strong></td>
                                        <td><strong>SKS</strong></td>
                                        <td><strong>IPS</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $a = 1;
                                foreach ($dataKrs as $value) { ?>
                                    <tr class="center">
                                        <td><?= $a ?></td>
                                        <td><?= $value['tahun'] ?></td>
                                        <td><?= $value['jumlah'] ?></td>
                                        <td><?= number_format($value['ip'], 2) ?></td>
                                    </tr>

                                <?php $a++; } ?>
                                    <tr class="center">
                                        <td colspan="3" class="info"><strong>IPK</strong></td>
                                        <td class="info"><strong>
                                            <?php 
                                                $b = 0;
                                                $c = 0;
                                                foreach ($dataKrs as $value) {
                                                    $b += $value['jumlah'];
                                                    $c += $value['nilai'];
                                                }
                                                $d = $c/$b;
                                                echo number_format($d, 2);
                                            ?>
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr class="center">
                                        <td colspan="3" class="info"><strong>STATUS MAHASISWA</strong></td>
                                        <td class="info">
                                            <strong><?= $model->labelStatus() ?></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            <?php } else{ ?>
                                <tbody>
                                    <tr>
                                        <td><strong>TIDAK ADA RECORD</strong></td>
                                    </tr>
                                </tbody>
                            <?php } ?>
                            </table>
                        </div>

                    </div>
      </div>
</div>