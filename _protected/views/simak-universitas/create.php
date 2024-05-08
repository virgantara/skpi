<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakUniversitas $model */

$this->title = 'Create Simak Universitas';
$this->params['breadcrumbs'][] = ['label' => 'Simak Universitas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-universitas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
