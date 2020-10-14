<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrganisasiJabatan */

$this->title = 'Create Organisasi Jabatan';
$this->params['breadcrumbs'][] = ['label' => 'Organisasi Jabatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organisasi-jabatan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
