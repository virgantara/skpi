<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SimakSertifikasi */

$this->title = 'Validasi Tes: ' . $model->nama_tes;
$this->params['breadcrumbs'][] = ['label' => 'Sertifikasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h3><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="x_content">
    <?= $this->render('_validasi', [
        'model' => $model,
    ]) ?>
           </div>
        </div>
    </div>
</div>
