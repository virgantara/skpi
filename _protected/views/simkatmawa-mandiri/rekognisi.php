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
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Mandiri', 'url' => ['index']];
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
                    if (empty($model->sertifikat_path)) {
                        return '-';
                    }
                    return Html::a('<i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'sertifikat_path'], ['target' => '_blank', 'data-pjax' => 0]);
                }
            ],
            [
                'attribute' => 'url_kegiatan',
                'format' => 'raw',
                'hAlign' => 'center',
                'value' => function ($model) {
                    if (empty($model->url_kegiatan)) {
                        return '-';
                    }
                    return Html::a('<i class="fa fa-link"></i>', $model->url_kegiatan, ['target' => '_blank']);
                }
            ],
            [
                'attribute' => 'foto_kegiatan_path',
                'format' => 'raw',
                'hAlign' => 'center',
                'value' => function ($model) {
                    if (empty($model->foto_kegiatan_path)) {
                        return '-';
                    }
                    return Html::a('<i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'foto_kegiatan_path'], ['target' => '_blank', 'data-pjax' => 0]);
                }
            ],
            [
                'attribute' => 'surat_tugas_path',
                'label' => 'Surat undangan',
                'format' => 'raw',
                'hAlign' => 'center',
                'value' => function ($model) {
                    if (empty($model->surat_tugas_path)) {
                        return '-';
                    }
                    return Html::a('<i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'surat_tugas_path'], ['target' => '_blank', 'data-pjax' => 0]);
                }
            ],
            [
                'attribute' => 'laporan_path',
                'format' => 'raw',
                'hAlign' => 'center',
                'value' => function ($model) {
                    if (empty($model->laporan_path)) {
                        return '-';
                    }
                    return Html::a('<i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'laporan_path'], ['target' => '_blank', 'data-pjax' => 0]);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{view} {update} {delete}',
                'buttons' => [

                    'mhs' => function ($url, $model) {
                        return Html::a('<i class="fa fa-list"></i>', ['/simkatmawa-mandiri/detail-mahasiswa', 'id' => $model->id], [
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
                        return Html::a('<i class="fa fa-trash"></i>', ['/simkatmawa-mandiri/delete', 'id' => $model->id, 'jenisSimkatmawa' => $model->jenis_simkatmawa], [
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