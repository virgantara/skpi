<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakUniv $model */

$this->title = 'Create KKNI';
$this->params['breadcrumbs'][] = ['label' => 'KKNI', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-univ-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
