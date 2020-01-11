<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RiwayatHukuman */

$this->title = 'Create Riwayat Hukuman';
$this->params['breadcrumbs'][] = ['label' => 'Riwayat Hukumen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="riwayat-hukuman-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
