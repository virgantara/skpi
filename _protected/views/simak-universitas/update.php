<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakUniversitas $model */

$this->title = 'Data Universitas';
$this->params['breadcrumbs'][] = ['label' => 'Simak Universitas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simak-universitas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
