<?php

use app\models\SimakSyaratBebasAsramaMahasiswa;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SimakSyaratBebasAsramaMahasiswaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Simak Syarat Bebas Asrama Mahasiswas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-syarat-bebas-asrama-mahasiswa-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Simak Syarat Bebas Asrama Mahasiswa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'syarat_id',
            'mhs_id',
            'file_path',
            'updated_at',
            //'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SimakSyaratBebasAsramaMahasiswa $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
