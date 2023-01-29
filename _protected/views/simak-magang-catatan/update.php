<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakMagangCatatan $model */

$this->title = 'Update Simak Magang Catatan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simak Magang Catatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simak-magang-catatan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
