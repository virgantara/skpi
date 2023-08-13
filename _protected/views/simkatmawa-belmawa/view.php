<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaBelmawa $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Belmawas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="simkatmawa-belmawa-view">

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
            'user_id',
            'simkatmawa_belmawa_kategori_id',
            'jenis_simkatmawa',
            'nama_kegiatan',
            'peringkat',
            'keterangan',
            'tahun',
            'url_kegiatan:url',
            'laporan_path',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
