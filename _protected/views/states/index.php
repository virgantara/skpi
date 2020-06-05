<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'States';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="states-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create States', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name',
            [
                'attribute'=>'country_id',
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\Countries::find()->all(),'id','name'),
                'value' => function ($data) {
                    return $data->name;
                },
               
            ],
            'country_code',
            'fips_code',
            //'iso2',
            //'created_at',
            //'updated_at',
            //'flag',
            //'wikiDataId',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
