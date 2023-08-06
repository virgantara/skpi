<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMandiri $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Mandiri', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="simkatmawa-mandiri-view">

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
            'nama_kegiatan',
            'penyelenggara',
            'tempat_pelaksanaan',
            'simkatmawa_rekognisi_id',
            'level',
            'apresiasi',
            'url_kegiatan:url',
            'tanggal_mulai',
            'tanggal_selesai',
            'sertifikat_path',
            'foto_penyerahan_path',
            'foto_kegiatan_path',
            'foto_karya_path',
            'surat_tugas_path',
            'laporan_path',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>