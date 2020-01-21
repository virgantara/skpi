<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Asrama */

$this->title = 'Create Asrama';
$this->params['breadcrumbs'][] = ['label' => 'Asramas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asrama-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
