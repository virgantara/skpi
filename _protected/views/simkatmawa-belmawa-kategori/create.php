<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaBelmawaKategori $model */

$this->title = 'Create Simkatmawa Belmawa Kategori';
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Belmawa Kategoris', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-belmawa-kategori-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
