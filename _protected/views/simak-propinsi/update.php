<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SimakPropinsi */

$this->title = 'Update Simak Propinsi: ' . $model->kode;
$this->params['breadcrumbs'][] = ['label' => 'Simak Propinsis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode, 'url' => ['view', 'id' => $model->kode]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simak-propinsi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
