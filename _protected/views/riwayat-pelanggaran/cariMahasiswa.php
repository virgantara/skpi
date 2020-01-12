<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\RiwayatPelanggaran */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', Yii::$app->name);
?>
<div class="row">
<div class="col-xs-12">

    <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>

    <?= $form->field($model, 'nim')->textInput(['width' => 40]) ?>

    <div class="form-group">
        <button type="submit" name="btn-cari" class="btn btn-info"><i class="fa fa-search"></i> Cari</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>