<?php

use app\models\SimkatmawaNonLomba;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaNonLombaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Simkatmawa Non Lomba - Pembinaan Mental Kebangsaan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-non-lomba-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i> Input Kegiatan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'nama_kegiatan',
            'simkatmawa_kegiatan_id',
            'tanggal_mulai',
            'tanggal_selesai',
            'laporan_path',
            'url_kegiatan:url',
            'foto_kegiatan_path',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SimkatmawaNonLomba $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>