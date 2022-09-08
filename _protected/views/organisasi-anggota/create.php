<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\OrganisasiAnggota */

$this->title = 'Create Organisasi Anggota';
$this->params['breadcrumbs'][] = ['label' => 'Organisasi Anggotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organisasi-anggota-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
