<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakLayananSuratSetting $model */

$this->title = 'Create Simak Layanan Surat Setting';
$this->params['breadcrumbs'][] = ['label' => 'Simak Layanan Surat Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-layanan-surat-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
