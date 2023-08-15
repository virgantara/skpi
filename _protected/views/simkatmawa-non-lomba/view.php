<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaNonLomba $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Non Lombas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="simkatmawa-non-lomba-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (!Yii::$app->user->isGuest) :
        ?>
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
    <?php
    endif;
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama_kegiatan',
            'simkatmawa_kegiatan_id',
            'tanggal_mulai',
            'tanggal_selesai',
            'laporan_path',
            'url_kegiatan:url',
            'foto_kegiatan_path',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>