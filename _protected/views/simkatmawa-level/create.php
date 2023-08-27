<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaLevel $model */

$this->title = Yii::t('app', 'Create Simkatmawa Level');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Simkatmawa Levels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-level-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
