<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AppsCountriesDetailedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apps Countries Detaileds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apps-countries-detailed-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Apps Countries Detailed', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'countryCode',
            'countryName',
            'currencyCode',
            'fipsCode',
            //'isoNumeric',
            //'north',
            //'south',
            //'east',
            //'west',
            //'capital',
            //'continentName',
            //'continent',
            //'languages',
            //'isoAlpha3',
            //'geonameId',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
