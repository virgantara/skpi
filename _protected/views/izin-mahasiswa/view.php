<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\IzinMahasiswa */

$this->title = $model->namaMahasiswa;
$this->params['breadcrumbs'][] = ['label' => 'Izin Mahasiswa', 'url' => ['index']];
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
            // 'id',
            'nim',
            'namaMahasiswa',
            'namaFakultas',
            'namaProdi',
            [
                'attribute' =>'Kamar dan Asrama',
                'value' => function($data){
                    return !empty($data->nim0->kamar) ? $data->nim0->kamar->nama.' - '.$data->nim0->kamar->asrama->nama : '';
                }
            ],
            'tahun_akademik',
            'semester',
            'kota.kab',
            'namaKeperluan',
            'alasan:ntext',
            'tanggal_berangkat',
            'tanggal_pulang',
            'statusIzin',
            [
                'attribute'=>'BAAK Approval',
                'format' => 'raw',
                'value' => function($data){
                    return $model->baak_approved == '1' ? '<label class="label label-success">Disetujui</label>' : '<label class="label label-danger">Belum disetujui</label>';
                }
            ],
            [
                'attribute'=>'Kaprodi Approval',
                'format' => 'raw',
                'value' => function($data){
                    return $model->prodi_approved == '1' ? '<label class="label label-success">Disetujui</label>' : '<label class="label label-danger">Belum disetujui</label>';
                }
            ],
            [
                'attribute'=>'Kepengasuhan Approval',
                'format' => 'raw',
                'value' => function($data){
                    return $model->approved == '1' ? '<label class="label label-success">Disetujui</label>' : '<label class="label label-danger">Belum disetujui</label>';
                }
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
