<?php

use app\models\SimkatmawaMandiri;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMandiriSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Simkatmawa Mandiris';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-mandiri-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Simkatmawa Mandiri', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nim',
            'nama_kegiatan',
            'penyelenggara',
            'tempat_pelaksanaan',
            //'simkatmawa_rekognisi_id',
            //'level',
            //'apresiasi',
            //'url_kegiatan:url',
            //'tanggal_mulai',
            //'tanggal_selesai',
            //'sertifikat_path',
            //'foto_penyerahan_path',
            //'foto_kegiatan_path',
            //'foto_karya_path',
            //'surat_tugas_path',
            //'laporan_path',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SimkatmawaMandiri $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
