<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatanHarian */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simak Kegiatan Harians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="simak-kegiatan-harian-view">

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
            
            'kode',
            [
                'attribute' => 'kegiatan_id',
                'value' => function($data){

                    return !empty($data->kegiatan) ? $data->kegiatan->nama_kegiatan : 'Not found';
                }
            ],
            'tahun_akademik',
            
            'jam_mulai',
            'jam_selesai',
            'poin'
        ],
    ]) ?>

</div>
