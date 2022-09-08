<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\KategoriPelanggaran */

$this->title = 'Update Kategori Pelanggaran: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kategori Pelanggarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kategori-pelanggaran-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
