<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakKampusKoordinator $model */

$this->title = 'Update Simak Kampus Koordinator: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simak Kampus Koordinators', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simak-kampus-koordinator-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
