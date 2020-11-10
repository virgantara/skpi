<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IzinHarianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Perizinan Keluar-Masuk Hari Ini tanggal '.date('d M Y');
$this->params['breadcrumbs'][] = $this->title;
?>
<h3><?=$this->title;?></h3>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>NAMA</th>
                    <th>Smt</th>
                    <th>Prodi / Asrama</th>
                    <th>Waktu Keluar</th>
                    <th>Waktu Masuk</th>
                    <th>Durasi</th>
                    <th>Total Izin</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($results as $q => $m)
                {
                    $mhs = $m['mhs'];

                    $rows = count($m['izin']);

                    $izin = $m['izin'][0];
                    $date1 = new DateTime($izin->waktu_masuk);
                    $date2 = new DateTime($izin->waktu_keluar);
                    $durasi = $date2->diff($date1);
                    $durasi_label = $durasi->h.' jam '.$durasi->i.' menit '.$durasi->s.' detik';
                ?>
                <tr>
                    <td  rowspan="<?=$rows;?>"><?=$q+1;?></td>
                    <td rowspan="<?=$rows;?>"><?=$mhs->nim_mhs;?></td>
                    <td  rowspan="<?=$rows;?>"><?=$mhs->nama_mahasiswa;?></td>
                    <td  rowspan="<?=$rows;?>"><?=$mhs->semester;?></td>
                    <td  rowspan="<?=$rows;?>">
                        <?=$mhs->namaProdi;?>
                        <br><?=$mhs->kamar->asrama->nama;?> (<?=$mhs->kamar->nama;?>)
                    </td>
                    <td><?=$izin->waktu_keluar;?></td>
                    <td><?=$izin->waktu_masuk;?></td>
                    <td><?=$durasi_label;?></td>
                    <td rowspan="<?=$rows;?>"><?=$rows;?> kali</td>
                </tr>
                <?php 
                    for($i=1;$i<$rows;$i++)
                    {
                        $izin = $m['izin'][$i];
                        $date1 = new DateTime($izin->waktu_masuk);
                        $date2 = new DateTime($izin->waktu_keluar);
                        $durasi = $date2->diff($date1);
                        $durasi_label = $durasi->h.' jam '.$durasi->i.' menit '.$durasi->s.' detik';
                    ?>
                    <tr>
                    <?php 
                    if($rows == 1){
                    ?>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <?php 
                    }
                    ?>
                    <td><?=$izin->waktu_keluar;?></td>
                    <td><?=$izin->waktu_masuk;?></td>
                    <td><?=$durasi_label;?></td>
                </tr>
                    <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>