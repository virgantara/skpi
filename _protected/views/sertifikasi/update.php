<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SimakSertifikasi */

$this->title = 'Update Sertifikasi: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simak Sertifikasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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
    ]) ?>
           </div>
        </div>
    </div>
</div>
