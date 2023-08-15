<?php

use app\helpers\MyHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use richardfan\widget\JSRegister;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMbkm $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simkatmawa-mbkm-form">
    <div class="row">
        <div class="col-sm-12">

            <div class="widget-box widget-color-blue2">
                <div class="widget-header">
                    <h4 class="widget-title lighter smaller">Pertukaran Pelajar</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'nama_program')->textInput(['maxlength' => true, 'placeholder' => "Masukkan nama kegiatan"]) ?>

                        <?= $form->field($model, 'tempat_pelaksanaan')->textInput(['maxlength' => true, 'placeholder' => "Masukkan tempat kegiatan"]) ?>

                        <?= $form->field($model, 'penyelenggara')->textInput(['maxlength' => true, 'placeholder' => "Masukkan nama penyelenggara"]) ?>

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

                        <?= $form->field($model, 'level')->radioList(
                            MyHelper::listSimkatmawaLevel()[1],
                            [
                                'class' => 'radio-list', // You can add custom classes here
                            ]
                        ) ?>

                        <?= $form->field($model, 'status_sks')->radioList(
                            MyHelper::listStatusSks(),
                            [
                                'class' => 'radio-list', // You can add custom classes here
                            ]
                        ) ?>

                        <?= $form->field($model, 'sk_penerimaan_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control'])->label('SK Penerimaan Pertukaran Pelajar') ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?= $form->field($model, 'surat_tugas_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control'])->label('Surat Tugas / Surat Izin dari Fakultas') ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?= $form->field($model, 'rekomendasi_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control'])->label('Surat Rekomendasi dari PT Asal') ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?= $form->field($model, 'khs_pt_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control'])->label('KHS dari PT Penerima') ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?= $form->field($model, 'sertifikat_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control'])->label('Sertifikat Pertukaran Pelajar') ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?= $form->field($model, 'laporan_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control'])->label('Laporan Akademik Pelaksanakan Kegiatan') ?>
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