<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMahasiswa $model */

$this->title = 'Create Simkatmawa Mahasiswa';
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Mahasiswas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-mahasiswa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
