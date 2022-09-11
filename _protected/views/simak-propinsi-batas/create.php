<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SimakPropinsiBatas */

$this->title = 'Create Simak Propinsi Batas';
$this->params['breadcrumbs'][] = ['label' => 'Simak Propinsi Batas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-propinsi-batas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
