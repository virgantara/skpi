<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SimakKegiatanHarianKategoriSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Simak Kegiatan Harian Kategoris';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-kegiatan-harian-kategori-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Simak Kegiatan Harian Kategori', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kode',
            'nama',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
