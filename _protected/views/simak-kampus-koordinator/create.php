<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimakKampusKoordinator $model */

$this->title = 'Create Simak Kampus Koordinator';
$this->params['breadcrumbs'][] = ['label' => 'Simak Kampus Koordinators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-kampus-koordinator-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
