<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakMagangCatatan $model */

$this->title = 'Create Simak Magang Catatan';
$this->params['breadcrumbs'][] = ['label' => 'Simak Magang Catatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-magang-catatan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
