<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakSyaratBebasAsramaMahasiswa $model */

$this->title = 'Create Simak Syarat Bebas Asrama Mahasiswa';
$this->params['breadcrumbs'][] = ['label' => 'Simak Syarat Bebas Asrama Mahasiswas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-syarat-bebas-asrama-mahasiswa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
