<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaBelmawaKategori $model */

$this->title = 'Update Simkatmawa Belmawa Kategori: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Belmawa Kategoris', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simkatmawa-belmawa-kategori-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
