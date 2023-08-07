<?php

use app\models\SimkatmawaMbkm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMbkmSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Simkatmawa Mbkms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-mbkm-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Simkatmawa Mbkm', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'jenis_simkatmawa',
            'nama_program',
            'tempat_pelaksanaan',
            'tanggal_mulai',
            //'tanggal_selesai',
            //'penyelenggara',
            //'level',
            //'apresiasi',
            //'status_sks',
            //'sk_penerimaan_path',
            //'surat_tugas_path',
            //'rekomendasi_path',
            //'khs_pt_path',
            //'sertifikat_path',
            //'laporan_path',
            //'hasil_path',
            //'hasil_jenis',
            //'rekognisi_id',
            //'kategori_pembinaan_id',
            //'kategori_belmawa_id',
            //'url_berita:url',
            //'foto_penyerahan_path',
            //'foto_kegiatan_path',
            //'foto_karya_path',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SimkatmawaMbkm $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
