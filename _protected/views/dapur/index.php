<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DapurSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dapur';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dapur-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Dapur', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kampus',
            'nama',
            'kapasitas',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
