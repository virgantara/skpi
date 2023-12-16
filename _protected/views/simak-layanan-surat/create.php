<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakLayananSurat $model */

$this->title = 'Create Simak Layanan Surat';
$this->params['breadcrumbs'][] = ['label' => 'Simak Layanan Surats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-layanan-surat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
