<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatanHarianKategori */

$this->title = 'Update Simak Kegiatan Harian Kategori: ' . $model->kode;
$this->params['breadcrumbs'][] = ['label' => 'Simak Kegiatan Harian Kategoris', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode, 'url' => ['view', 'id' => $model->kode]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simak-kegiatan-harian-kategori-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
