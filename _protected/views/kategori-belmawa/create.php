<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KategoriBelmawa $model */

$this->title = 'Create Kategori Belmawa';
$this->params['breadcrumbs'][] = ['label' => 'Kategori Belmawas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kategori-belmawa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
