<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Organisasi */

$this->title = 'Create Organisasi';
$this->params['breadcrumbs'][] = ['label' => 'Organisasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organisasi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
