<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\IzinHarian */

$this->title = 'Update Izin Harian: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Izin Harians', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="izin-harian-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
