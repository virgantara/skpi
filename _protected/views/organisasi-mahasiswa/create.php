<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrganisasiMahasiswa */

$this->title = 'Create Organisasi Mahasiswa';
$this->params['breadcrumbs'][] = ['label' => 'Organisasi Mahasiswas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organisasi-mahasiswa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
