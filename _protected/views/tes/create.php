<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SimakTes */

$this->title = 'Create Simak Tes';
$this->params['breadcrumbs'][] = ['label' => 'Simak Tes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h3><?= Html::encode($this->title) ?></h3>
<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body ">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	   </div>
        </div>
    </div>
</div>