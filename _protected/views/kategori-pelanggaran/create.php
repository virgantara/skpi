<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\KategoriPelanggaran */

$this->title = 'Create Kategori Pelanggaran';
$this->params['breadcrumbs'][] = ['label' => 'Kategori Pelanggarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kategori-pelanggaran-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
