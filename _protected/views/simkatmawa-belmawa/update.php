<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaBelmawa $model */

$this->title = 'Update Simkatmawa Belmawa: ' . $model->nama_kegiatan;
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Belmawa', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama_kegiatan, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simkatmawa-belmawa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'function' => 'update'
    ]) ?>

</div>
