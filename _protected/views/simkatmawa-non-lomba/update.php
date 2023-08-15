<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaNonLomba $model */

$this->title = 'Update Simkatmawa Non Lomba: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Non Lombas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simkatmawa-non-lomba-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'function' => 'update'
    ]) ?>

</div>
