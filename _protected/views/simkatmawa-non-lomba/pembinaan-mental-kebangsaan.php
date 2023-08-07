<?php

use app\models\SimkatmawaKegiatan;
use app\models\SimkatmawaNonLomba;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaNonLombaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pembinaan Mental Kebangsaan';
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Non Lomba', 'url' => ['pembinaan-mental-kebangsaan']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-non-lomba-index">

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
            'nama_kegiatan',
            'simkatmawaKegiatan.nama',
            [
                'label' => Yii::t('app', 'Tahun'),
                'hAlign' => 'center',
                'value' => function ($model) {
                    $dateTime = new DateTime($model->tanggal_mulai);
                    $year = $dateTime->format('Y');

                    return $year;
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
                'class' => ActionColumn::className(),
                'contentOptions' => ['class' => 'text-center'],
                'visible' => !Yii::$app->user->isGuest,
                'urlCreator' => function ($action, SimkatmawaNonLomba $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>