<?php

use app\helpers\MyHelper;
use app\models\SimkatmawaRekognisi;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use richardfan\widget\JSRegister;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMandiri $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simkatmawa-mandiri-form">
    <div class="row">
        <div class="col-sm-12">

            <div class="widget-box widget-color-blue2">
                <div class="widget-header">
                    <h4 class="widget-title lighter smaller">Rekognisi</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'nama_kegiatan')->textInput(['maxlength' => true, 'placeholder' => "Masukkan nama kegiatan"]) ?>

                        <?= $form->field($model, 'penyelenggara')->textInput(['maxlength' => true, 'placeholder' => "Masukkan nama penyelenggara"]) ?>

                        <?= $form->field($model, 'tempat_pelaksanaan')->textInput(['maxlength' => true, 'placeholder' => "Masukkan tempat kegiatan"]) ?>

                        <?= $form->field($model, 'tanggal_mulai')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Input tanggal mulai ...', 'autocomplete' => 'off'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                        ?>

                        <?= $form->field($model, 'tanggal_selesai')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Input tanggal selesai ...', 'autocomplete' => 'off'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                        ?>

                        <?= $form->field($model, 'level')->widget(Select2::classname(), [
                            'data' => MyHelper::listSimkatmawaLevel()[0],
                            'options' => ['placeholder' => Yii::t('app', '- Pilih Level -')],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]) ?>

                        <?= $form->field($model, 'apresiasi')->widget(Select2::classname(), [
                            'data' => MyHelper::listSimkatmawaApresiasi(),
                            'options' => ['placeholder' => Yii::t('app', '- Pilih Apresiasi -')],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]) ?>

                        <?= $form->field($model, 'sertifikat_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control'])->label('Sertifikat Apresiasi') ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?= $form->field($model, 'foto_kegiatan_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control'])->label('Dokumentasi Piala/Medali') ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?= $form->field($model, 'url_kegiatan')->textInput(['maxlength' => true, 'placeholder' => "Masukkan url kegiatan"]) ?>

                        <?= $form->field($model, 'foto_penyerahan_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control']) ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?= $form->field($model, 'surat_tugas_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control']) ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?= $form->field($model, 'laporan_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control']) ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?php
                        echo $this->render('_mahasiswa.php', [
                            'function' => $function,
                            'simkatmawa_id' => $model->id ?? null
                        ]);
                        ?>

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