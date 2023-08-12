<?php

use app\helpers\MyHelper;
use app\models\SimkatmawaMandiri;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMandiriSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kegiatan Mandiri';
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Mandiri', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-mandiri-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (!Yii::$app->user->isGuest) :
    ?>
        <p>
            <?= Html::a('<i class="fa fa-plus"></i> Input Kegiatan', ['create-kegiatan-mandiri'], ['class' => 'btn btn-sm btn-success']) ?>
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
            [
                'attribute' => 'level',
                'label' => 'Kategori Kegiatan',
                'value' => function ($model) {
                    return MyHelper::listSimkatmawaLevel()[0][$model->level];
                }
            ],
            'nama_kegiatan',
            [
                'label' => 'Tahun Kegiatan',
                'value' => function ($model) {
                    return date('Y', strtotime($model->tanggal_mulai));
                }
            ],
            [
                'attribute' => 'sertifikat_path',
                'label' => 'Sertifikat/Piala/Medali',
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
                'label' => 'Foto Kegiatan',
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
                'label' => 'Surat Tugas/Undangan',
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
                'attribute' => 'penyelenggara',
                'label' => 'Nama PT',
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