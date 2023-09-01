<?php

use app\models\SimakMasterprogramstudi;
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

                        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

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

                        <?php if ($function == 'update') : ?>
                            <ul>
                                <li>
                                    <p style="color: red;">Jika file tidak ingin di update, maka biarkan kosong!</p>
                                </li>
                                <li>
                                    <p style="color: red;">"Current file" menandakan file tersebut sudah ada</p>
                                </li>
                            </ul>
                        <?php endif; ?>

                        <?= $form->field($model, 'laporan_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control'])->label('Laporan Akademik Pelaksanaan Kegiatan') ?>
                        <?php if ($model->laporan_path) :
                            $file_name = urldecode(basename(parse_url($model->laporan_path, PHP_URL_PATH)));
                            $array = explode("-", $file_name);
                            $file_name = $array[1] . '.pdf';
                        ?>
                            <p style="color: red;">Current File (Laporan Akademik Pelaksanaan Kegiatan): <?= Html::a($file_name, ['download', 'id' => $model->id, 'file' => 'laporan_path'], ['target' => '_blank']) ?></p>
                        <?php endif; ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?= $form->field($model, 'url_kegiatan')->textInput(['maxlength' => true, 'placeholder' => 'Masukkan url kegiatan']) ?>

                        <?= $form->field($model, 'foto_kegiatan_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control'])->label('Foto Kegiatan') ?>
                        <?php if ($model->foto_kegiatan_path) :
                            $file_name = urldecode(basename(parse_url($model->foto_kegiatan_path, PHP_URL_PATH)));
                            $array = explode("-", $file_name);
                            $file_name = $array[1] . '.pdf';
                        ?>
                            <p style="color: red;">Current File (Foto Kegiatan): <?= Html::a($file_name, ['download', 'id' => $model->id, 'file' => 'foto_kegiatan_path'], ['target' => '_blank']) ?></p>
                        <?php endif; ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?php if (Yii::$app->user->can('admin')) : ?>

                            <?= $form->field($model, 'prodi_id')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(SimakMasterprogramstudi::find()->all(), 'id', 'nama_prodi'),
                                'options' => ['placeholder' => Yii::t('app', '- Pilih Program Studi -')],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ])->label('Program Studi') ?>

                        <?php endif; ?>

                        <?php
                        echo $this->render('_mahasiswa.php', [
                            'function' => $function,
                            'simkatmawa_id' => $model->id ?? ''
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