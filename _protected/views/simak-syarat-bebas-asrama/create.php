<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakSyaratBebasAsrama $model */

$this->title = 'Create Simak Syarat Bebas Asrama';
$this->params['breadcrumbs'][] = ['label' => 'Simak Syarat Bebas Asramas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-syarat-bebas-asrama-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
