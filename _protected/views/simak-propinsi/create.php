<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SimakPropinsi */

$this->title = 'Create Simak Propinsi';
$this->params['breadcrumbs'][] = ['label' => 'Simak Propinsis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-propinsi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
