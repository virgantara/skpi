<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Asrama */

$this->title = 'Update Asrama: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Asramas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="asrama-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
