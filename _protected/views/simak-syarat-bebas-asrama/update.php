<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakSyaratBebasAsrama $model */

$this->title = 'Update Simak Syarat Bebas Asrama: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simak Syarat Bebas Asramas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simak-syarat-bebas-asrama-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
