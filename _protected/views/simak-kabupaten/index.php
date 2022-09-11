<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SimakKabupatenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Simak Kabupatens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-kabupaten-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Simak Kabupaten', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kode',
            'id',
            'kab',
            'keterangan',
            'id_provinsi',
            //'created_by',
            //'date_created',
            //'updated_by',
            //'last_updated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
