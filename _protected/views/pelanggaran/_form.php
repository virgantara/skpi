<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;

use app\models\KategoriPelanggaran;
/* @var $this yii\web\View */
/* @var $model app\models\Pelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pelanggaran-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kategori_id')->dropDownList(ArrayHelper::map(KategoriPelanggaran::find()->all(),'id','nama')) ?>
    <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
