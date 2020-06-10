<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dapur */

$this->title = 'Create Dapur';
$this->params['breadcrumbs'][] = ['label' => 'Dapurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dapur-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
