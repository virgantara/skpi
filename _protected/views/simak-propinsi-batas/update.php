<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SimakPropinsiBatas */

$this->title = 'Update Simak Propinsi Batas: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simak Propinsi Batas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simak-propinsi-batas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
