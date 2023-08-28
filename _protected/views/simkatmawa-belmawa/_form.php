<?php

use app\helpers\MyHelper;
use app\models\SimakMasterprogramstudi;
use app\models\SimkatmawaBelmawaKategori;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use richardfan\widget\JSRegister;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaBelmawa $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simkatmawa-belmawa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'simkatmawa_belmawa_kategori_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(SimkatmawaBelmawaKategori::find()->all(), 'id', 'nama'),
        'options' => ['placeholder' => Yii::t('app', '- Pilih Kategori Kegiatan -')],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label('Kategori Kegiatan') ?>

    <?= $form->field($model, 'nama_kegiatan')->textInput(['maxlength' => true, 'placeholder' => 'Masukkan nama kegiatan']) ?>

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

    <?= $form->field($model, 'peringkat')->textInput(['maxlength' => true, 'placeholder' => 'Masukkan peringkat']) ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 4]) ?>

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