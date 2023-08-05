<?php

use app\models\SimkatmawaMahasiswa;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMahasiswaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Simkatmawa Mahasiswas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-mahasiswa-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Simkatmawa Mahasiswa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'simkatmawa_mandiri_id',
            'nim',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SimkatmawaMahasiswa $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
