<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrganisasiMahasiswaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Organisasi Mahasiswas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organisasi-mahasiswa-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Organisasi Mahasiswa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nim',
            'organisasi_id',
            'jabatan_id',
            'peran:ntext',
            //'is_aktif',
            //'tanggal_mulai',
            //'tanggal_selesai',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
