<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaRekognisi $model */

$this->title = 'Create Simkatmawa Rekognisi';
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Rekognisis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-rekognisi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
