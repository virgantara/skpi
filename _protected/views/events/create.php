<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = 'Create Events';
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body ">
			    <?= $this->render('_form', [
			        'model' => $model,
                    'listTahun' => $listTahun
			    ]) ?>


            </div>
        </div>
    </div>

</div>