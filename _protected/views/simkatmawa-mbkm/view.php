<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMbkm $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Mbkms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="simkatmawa-mbkm-view">

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
            'jenis_simkatmawa',
            'nama_program',
            'tempat_pelaksanaan',
            'tanggal_mulai',
            'tanggal_selesai',
            'penyelenggara',
            'level',
            'apresiasi',
            'status_sks',
            'sk_penerimaan_path',
            'surat_tugas_path',
            'rekomendasi_path',
            'khs_pt_path',
            'sertifikat_path',
            'laporan_path',
            'hasil_path',
            'hasil_jenis',
            'rekognisi_id',
            'kategori_pembinaan_id',
            'kategori_belmawa_id',
            'url_berita:url',
            'foto_penyerahan_path',
            'foto_kegiatan_path',
            'foto_karya_path',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
