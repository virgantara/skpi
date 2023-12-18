<?php

use app\models\SimakSyaratBebasAsrama;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SimakSyaratBebasAsramaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Syarat Bebas Asrama';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-syarat-bebas-asrama-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Syarat Bebas Asrama', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'nama',
            'is_aktif',
            [
                'template' => '{view} {update}',
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SimakSyaratBebasAsrama $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
