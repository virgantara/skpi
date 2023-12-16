<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakLayananSuratSetting $model */

$this->title = 'Update Setting Layanan Surat';
$this->params['breadcrumbs'][] = ['label' => 'Layanan Surat Setting', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simak-layanan-surat-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
