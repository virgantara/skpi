<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IzinHarianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Izin Harian ';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>NAMA</th>
                    <th>Keluar</th>
                    <th>Masuk</th>
                    <th>Durasi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($results as $q => $m)
                {
                    $mhs = $m['mhs'];
                    $keluar = $m['keluar'];
                    $masuk = $m['masuk'];
                    // $durasi_label = 'Belum Kembali';
                    // if(!empty($masuk))
                    // {
                    $date1 = new DateTime($keluar);
                    $date2 = new DateTime($masuk);
                    $durasi = $date2->diff($date1);
                    $durasi_label = $durasi->h.' jam '.$durasi->i.' menit '.$durasi->s.' detik';
                    // }
                    // $durasi = 
                ?>
                <tr>
                    <td><?=$q+1;?></td>
                    <td><?=$mhs->nim;?></td>
                    <td><?=$mhs->namaMahasiswa;?></td>
                    <td><?=$keluar;?></td>
                    <td><?=$masuk;?></td>
                    <td><?=$durasi_label;?></td>
                </tr>
                <?php 
                }
                ?>
            </tbody>
        </table>
    </div>
</div>