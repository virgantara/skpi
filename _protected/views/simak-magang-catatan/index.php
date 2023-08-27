<?php

use app\models\SimakMagangCatatan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SimakMagangCatatanSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Simak Magang Catatans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-magang-catatan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Simak Magang Catatan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'magang_id',
            'tanggal',
            'rincian_kegiatan:ntext',
            'evaluasi:ntext',
            //'tindak_lanjut:ntext',
            //'catatan_pembimbing:ntext',
            //'is_approved',
            //'updated_at',
            //'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SimakMagangCatatan $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
