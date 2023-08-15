<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMahasiswa $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Mahasiswas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="simkatmawa-mahasiswa-view">

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
            'simkatmawa_mbkm_id',
            'simkatmawa_mandiri_id',
            'simkatmawa_belmawa_id',
            'nim',
            'simkatmawa_non_lomba_id',
            'nama',
            'prodi',
            'kampus',
        ],
    ]) ?>

</div>
