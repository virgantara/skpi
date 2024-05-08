<?php

use app\models\SimakUniversitas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SimakUniversitasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Simak Universitas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-universitas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Simak Universitas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'rektor',
            'alamat',
            'telepon',
            'fax',
            //'website',
            //'email:email',
            //'sk_rektor',
            //'tgl_sk_rektor',
            //'periode',
            //'status_aktif',
            //'catatan_resmi:ntext',
            //'catatan_resmi_en:ntext',
            //'deskripsi_skpi:ntext',
            //'deskripsi_skpi_en:ntext',
            //'nama_institusi',
            //'nama_institusi_en',
            //'sk_pendirian',
            //'tanggal_sk_pendirian',
            //'peringkat_akreditasi',
            //'nomor_sertifikat_akreditasi',
            //'lembaga_akreditasi',
            //'persyaratan_penerimaan:ntext',
            //'persyaratan_penerimaan_en:ntext',
            //'sistem_penilaian:ntext',
            //'sistem_penilaian_en:ntext',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SimakUniversitas $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
