<?php

use app\models\SimkatmawaKegiatan;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaNonLomba $model */
/** @var yii\widgets\ActiveForm $form */
?>


<div class="simkatmawa-non-lomba-form">

    <div class="row">
        <div class="col-sm-12">

            <div class="widget-box widget-color-blue2">
                <div class="widget-header">
                    <h4 class="widget-title lighter smaller">Pembinaan Mental Kebangsaan</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'nama_kegiatan')->textInput(['maxlength' => true, 'placeholder' => 'Masukkan nama kegiatan']) ?>

                        <?= $form->field($model, 'simkatmawa_kegiatan_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(SimkatmawaKegiatan::find()->all(), 'id', 'nama'),

                            'options' => ['id' => 'kampus_id', 'placeholder' => Yii::t('app', '- Pilih Kategori Kegiatan -')],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label('Kategori Kegiatan') ?>

                        <?= $form->field($model, 'tanggal_mulai')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Input tanggal mulai ...', 'autocomplete' => 'off'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy'
                            ]
                        ]);
                        ?>

                        <?= $form->field($model, 'tanggal_selesai')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Input tanggal selesai ...', 'autocomplete' => 'off'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy'
                            ]
                        ]);
                        ?>
                        <?= $form->field($model, 'laporan_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control']) ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?= $form->field($model, 'url_kegiatan')->textInput(['maxlength' => true, 'placeholder' => 'Masukkan url kegiatan']) ?>

                        <?= $form->field($model, 'foto_kegiatan_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control']) ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>