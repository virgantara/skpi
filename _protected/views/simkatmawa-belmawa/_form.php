<?php

use app\helpers\MyHelper;
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

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'laporan_path')->fileInput(['accept' => 'application/pdf', 'class' => 'form-control']) ?>
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