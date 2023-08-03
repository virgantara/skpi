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
        <?= Html::a('<i class="fa fa-plus"></i> Input kegiatan', ['create', 'id' => 0], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'nim',
            'nama_kegiatan',
            'simkatmawa_rekognisi_id',
            'tanggal_mulai',
            'sertifikat_path',
            'url_kegiatan:url',
            'foto_kegiatan_path',
            // 'foto_penyerahan_path',
            // 'foto_karya_path',
            'surat_tugas_path', //undangan
            'laporan_path',

            // 'penyelenggara',
            // 'tempat_pelaksanaan',
            //'level',
            //'apresiasi',
            //'tanggal_selesai',
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