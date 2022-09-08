<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\IzinHarian */

$this->title = 'Create Izin Harian';
$this->params['breadcrumbs'][] = ['label' => 'Izin Harians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="izin-harian-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
