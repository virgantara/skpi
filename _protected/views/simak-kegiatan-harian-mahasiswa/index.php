<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SimakKegiatanHarianMahasiswaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kegiatan Harian Mahasiswa';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-kegiatan-harian-mahasiswa-index">

    <h1><?= Html::encode($this->title) ?></h1>

  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'kode_kegiatan',
                    'value' => function ($data){
                        return !empty($data->kodeKegiatan) && !empty($data->kodeKegiatan->kegiatan) ? $data->kodeKegiatan->kegiatan->nama_kegiatan : '-';
                    }
                ],
                'nim',
                'namaMahasiswa',
                'namaProdi',
                'semester',
                'tahun_akademik',

                'poin',
                'waktu',
                'created_at',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
