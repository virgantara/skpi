<?php

use app\models\SimkatmawaBelmawa;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaBelmawaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Simkatmawa Belmawa';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-belmawa-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (!Yii::$app->user->isGuest) :
    ?>
        <p>
            <?= Html::a('<i class="fa fa-plus"></i> Input Kegiatan', ['create'], ['class' => 'btn btn-success']) ?>
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
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'simkatmawa_belmawa_kategori_id',
                'label' => 'Kategori Kegiatan',
                'value' => 'simkatmawaBelmawaKategori.nama'
            ],
            'nama_kegiatan',
            'peringkat',
            'keterangan',
            [
                'attribute' => 'laporan_path',
                'format' => 'raw',
                'hAlign' => 'center',
                'value' => function ($model) {
                    if (empty($model->laporan_path)) {
                        return '-';
                    }
                    return Html::a('Download <i class="fa fa-download"></i>', ['download', 'id' => $model->id, 'file' => 'laporan_path'], ['target' => '_blank', 'data-pjax' => 0]);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{view} {update} {delete}',
                'buttons' => [

                    'mhs' => function ($url, $model) {
                        return Html::a('<i class="fa fa-list"></i>', ['/simkatmawa-mbkm/detail-mahasiswa', 'id' => $model->id], [
                            'title' => Yii::t('app', 'Detail Mahasiswa'),
                            'data-pjax' => 0,
                        ]);
                    },
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fa fa-list"></i>', $url, [
                            'title' => Yii::t('app', 'Detail Data'),
                            'data-pjax' => 0,
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-pencil"></i>', $url, [
                            'title' => Yii::t('app', 'Update Kegiatan'),
                            'data-pjax' => 0,
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fa fa-trash"></i>', ['/simkatmawa-belmawa/delete', 'id' => $model->id, 'jenisSimkatmawa' => $model->jenis_simkatmawa], [
                            'title' => Yii::t('app', 'Hapus Kegiatan'),
                            'data-pjax' => 0,
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                    },

                ],
                'visibleButtons' => [

                    'update' => function ($data) {
                        return !Yii::$app->user->isGuest;
                    },

                    'delete' => function ($data) {
                        return !Yii::$app->user->isGuest;
                    }
                ]
            ],
        ],
    ]); ?>


</div>