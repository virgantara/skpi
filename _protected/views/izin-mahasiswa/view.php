<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\IzinMahasiswa */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Izin Mahasiswas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="izin-mahasiswa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nim',
            'tahun_akademik',
            'semester',
            'kota_id',
            'keperluan_id',
            'alasan:ntext',
            'tanggal_berangkat',
            'tanggal_pulang',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
