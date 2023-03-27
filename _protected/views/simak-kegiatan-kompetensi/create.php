<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakKegiatanKompetensi $model */

$this->title = 'Create Simak Kegiatan Kompetensi';
$this->params['breadcrumbs'][] = ['label' => 'Simak Kegiatan Kompetensis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-kegiatan-kompetensi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
