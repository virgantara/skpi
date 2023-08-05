<?php

use app\models\SimkatmawaMandiri;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMandiriSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Rekognisi';
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Mandiri', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-mandiri-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (!Yii::$app->user->isGuest) :
    ?>
        <p>
            <?= Html::a('<i class="fa fa-plus"></i> Input Kegiatan', ['create-rekognisi'], ['class' => 'btn btn-sm btn-success']) ?>
        </p>
    <?php
    endif;
    ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nama_kegiatan',
            [
                'attribute' => 'simkatmawa_rekognisi_id',
                'label' => 'Nama Rekognisi',
                'value' => 'simkatmawaRekognisi.nama'
            ],
            'tanggal_mulai',
            'tanggal_selesai',
            [
                'attribute' => 'sertifikat_path',
                'format' => 'raw',
                'hAlign' => 'center',
                'value' => function ($model) {
                    return Html::a('<i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'sertifikat_path'], ['target' => '_blank', 'data-pjax' => 0]);
                }
            ],
            [
                'attribute' => 'url_kegiatan',
                'format' => 'raw',
                'hAlign' => 'center',
                'value' => function ($model) {
                    return Html::a('<i class="fa fa-link"></i>', $model->url_kegiatan, ['target' => '_blank']);
                }
            ],
            [
                'attribute' => 'foto_kegiatan_path',
                'format' => 'raw',
                'hAlign' => 'center',
                'value' => function ($model) {
                    return Html::a('<i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'foto_kegiatan_path'], ['target' => '_blank', 'data-pjax' => 0]);
                }
            ],
            [
                'attribute' => 'surat_tugas_path',
                'label' => 'Surat undangan',
                'format' => 'raw',
                'hAlign' => 'center',
                'value' => function ($model) {
                    return Html::a('<i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'surat_tugas_path'], ['target' => '_blank', 'data-pjax' => 0]);
                }
            ],
            [
                'attribute' => 'laporan_path',
                'format' => 'raw',
                'hAlign' => 'center',
                'value' => function ($model) {
                    return Html::a('<i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'laporan_path'], ['target' => '_blank', 'data-pjax' => 0]);
                }
            ],
            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['class' => 'text-center'],
                'visible' => !Yii::$app->user->isGuest,
                'urlCreator' => function ($action, SimkatmawaMandiri $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>