<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaBelmawa $model */

$this->title = 'Create Simkatmawa Belmawa';
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Belmawa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-belmawa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'function' => 'update'
    ]) ?>

</div>