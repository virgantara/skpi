<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatanHarianMahasiswa */

$this->title = 'Create Simak Kegiatan Harian Mahasiswa';
$this->params['breadcrumbs'][] = ['label' => 'Simak Kegiatan Harian Mahasiswas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-kegiatan-harian-mahasiswa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
