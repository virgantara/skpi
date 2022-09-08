<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrganisasiAnggota */

$this->title = 'Update Organisasi Anggota: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Organisasi Anggotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organisasi-anggota-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
