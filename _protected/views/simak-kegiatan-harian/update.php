<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatanHarian */

$this->title = 'Update Kegiatan Harian: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kegiatan Harian', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simak-kegiatan-harian-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listTahun' => $listTahun
    ]) ?>

</div>
