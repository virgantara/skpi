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
                    <h4 class="widget-title lighter smaller">Mengajar di Sekolah</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'nama_program')->textInput(['maxlength' => true, 'placeholder' => "Masukkan nama kegiatan"]) ?>

                        <?= $form->field($model, 'tempat_pelaksanaan')->textInput(['maxlength' => true, 'placeholder' => "Masukkan tempat kegiatan"]) ?>

                        <?= $form->field($model, 'penyelenggara')->textInput(['maxlength' => true, 'placeholder' => "Masukkan nama penyelenggara"]) ?>

                        <?= $form->field($model, 'tanggal_mulai')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Input tanggal mulai ...', 'autocomplete' => 'off'],
                            'pluginOptions' => ['autoclose' => true, 'format' => 'dd-mm-yyyy']
                        ]); ?>

                        <?= $form->field($model, 'tanggal_selesai')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Input tanggal selesai ...', 'autocomplete' => 'off'],
                            'pluginOptions' => ['autoclose' => true, 'format' => 'dd-mm-yyyy']
                        ]); ?>

                        <?= $form->field($model, 'sk_penerimaan_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control'])->label('SK Mengajar dari Sekolah Penerima') ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?= $form->field($model, 'surat_tugas_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control'])->label('Surat Tugas / Surat Izin') ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?= $form->field($model, 'sertifikat_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control'])->label('Sertifikat Mengajar') ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <?= $form->field($model, 'laporan_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control'])->label('Laporan Akademik Pelaksanakan Kegiatan') ?>
                        <small>File: pdf Max size: 5 MB</small>

                        <div class="widget-box widget-color-blue2">
                            <div class="widget-header">
                                <h4 class="widget-title lighter smaller">Mahasiswa</h4>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main">
                                    <table id="tabel-mahasiswa" class="table table-bordered table-hovered table-striped">
                                        <tr id="">
                                            <td><?= Html::textInput('hint[]', '', ['class' => 'form-control', 'placeholder' => 'Masukkan NIM']) ?></td>
                                            <td><?= Html::button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-sm btn-success btn-plus']) ?> <?= Html::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-sm btn-danger btn-minus']) ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

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
<?php JSRegister::begin() ?>
<script>
    $(document).on("click", '.btn-plus', function(e) {

        html = ''
        html += '<tr>'
        html += '<td>'
        html += '<input type="text" name="hint[]" class="form-control" placeholder="Masukkan NIM">'
        html += '</td>'
        html += '<td>'
        html += '<button type="button" class="btn btn-sm btn-success btn-plus" ><i class="fa fa-plus"></i> </button> '
        html += '<button type="button" class="btn btn-sm btn-danger btn-minus" ><i class="fa fa-trash"></i> </button>'
        html += '</td>'
        html += '</tr>'

        $("#tabel-mahasiswa").append(html);
    });

    $(document).on("click", '.btn-minus', function(e) {
        $(this).closest('tr').remove();
    });

    $(document).bind("keyup.autocomplete", function() {

        $('[name="hint[]"]').autocomplete({
            minLength: 10,
            select: function(event, ui) {
                $(this).next().val(ui.item.id);
                $('[name="nim[]"]').val(ui.item.items.nim_mhs)
                $('[name="nama[]"]').val(ui.item.items.nama_mahasiswa)
            },
            focus: function(event, ui) {
                $(this).next().val(ui.item.id);
                $('[name="nim[]"]').val(ui.item.items.nim_mhs)
                $('[name="nama[]"]').val(ui.item.items.nama_mahasiswa)
            },
            source: function(request, response) {
                $.ajax({
                    url: "/mahasiswa/ajax-cari-mahasiswa-by-nim",
                    dataType: "json",
                    data: {
                        term: request.term,

                    },
                    success: function(data) {
                        response(data);
                    }
                })
            },

        });
    });
</script>
<?php JSRegister::end() ?>