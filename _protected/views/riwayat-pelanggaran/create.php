<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RiwayatPelanggaran */

$this->title = 'Create Riwayat Pelanggaran';
$this->params['breadcrumbs'][] = ['label' => 'Riwayat Pelanggarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="riwayat-pelanggaran-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
