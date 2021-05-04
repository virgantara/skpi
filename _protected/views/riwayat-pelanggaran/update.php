<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RiwayatPelanggaran */

$this->title = 'Update Riwayat Pelanggaran: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Riwayat Pelanggarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="riwayat-pelanggaran-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'mahasiswa' => $mahasiswa,
        'kabupaten' => $kabupaten
    ]) ?>

</div>
