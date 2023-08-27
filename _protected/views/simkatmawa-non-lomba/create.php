<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaNonLomba $model */

$this->title = 'Create Simkatmawa Non Lomba';
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Non Lomba', 'url' => ['pembinaan-mental-kebangsaan']];
$this->params['breadcrumbs'][] = ['label' => 'Pembinaan Mental Kebangsaan', 'url' => ['pembinaan-mental-kebangsaan']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-non-lomba-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'function' => 'create'
    ]) ?>

</div>
