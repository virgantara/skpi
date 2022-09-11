<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Hukuman */

$this->title = 'Create Hukuman';
$this->params['breadcrumbs'][] = ['label' => 'Hukumen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hukuman-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
