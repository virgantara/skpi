<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatanHarianKategori */

$this->title = 'Create Simak Kegiatan Harian Kategori';
$this->params['breadcrumbs'][] = ['label' => 'Simak Kegiatan Harian Kategoris', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-kegiatan-harian-kategori-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
