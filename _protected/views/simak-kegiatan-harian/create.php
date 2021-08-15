<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatanHarian */

$this->title = 'Create Kegiatan Harian';
$this->params['breadcrumbs'][] = ['label' => 'Kegiatan Harian', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-kegiatan-harian-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listTahun' => $listTahun
    ]) ?>

</div>
