<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\IzinMahasiswa */

$this->title = 'Update Izin Mahasiswa: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Izin Mahasiswas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="izin-mahasiswa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_status', [
        'model' => $model,
    ]) ?>

</div>
