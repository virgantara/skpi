<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaKegiatan $model */

$this->title = 'Update Simkatmawa Kegiatan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Kegiatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simkatmawa-kegiatan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
