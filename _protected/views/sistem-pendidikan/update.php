<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakUniv $model */

$this->title = 'Update Sistem Pendidikan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sistem Pendidikan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simak-univ-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
