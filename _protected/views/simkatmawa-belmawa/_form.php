<?php

use app\helpers\MyHelper;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaBelmawa $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simkatmawa-belmawa-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'simkatmawa_belmawa_kategori_id')->widget(Select2::classname(), [
        'data' => MyHelper::listSimkatmawaBelmawaKategori(),
        'options' => ['placeholder' => Yii::t('app', '- Pilih Kategori Kegiatan -')],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'nama_kegiatan')->textInput(['maxlength' => true, 'placeholder' => 'Masukkan nama kegiatan']) ?>

    <?= $form->field($model, 'peringkat')->textInput(['maxlength' => true, 'placeholder' => 'Masukkan peringkat']) ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'laporan_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control']) ?>
    <small>File: pdf Max size: 5 MB</small>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>