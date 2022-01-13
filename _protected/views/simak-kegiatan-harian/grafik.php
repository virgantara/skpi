<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

setlocale(LC_TIME, 'id_ID.utf8');
/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatanHarian */


$jenis_kegiatan = !empty($_GET['jenis_kegiatan']) ? $_GET['jenis_kegiatan'] : '';
$bulan = !empty($_GET['bulan']) ? $_GET['bulan'] : date('m');

 $bulans = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember',
];

$this->title = 'Rekap Kegiatan Bulan '.$bulans[$bulan].' '.date('Y');
$this->params['breadcrumbs'][] = ['label' => 'Kegiatan Harian', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


?>

<div class="row">
    <div class="col-md-12">
        
    </div>
</div>