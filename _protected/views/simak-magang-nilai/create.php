<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakMagangNilai $model */

$this->title = 'Create Simak Magang Nilai';
$this->params['breadcrumbs'][] = ['label' => 'Simak Magang Nilais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-magang-nilai-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
