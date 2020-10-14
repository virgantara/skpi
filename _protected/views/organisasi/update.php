<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Organisasi */

$this->title = 'Update Organisasi: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Organisasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organisasi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
