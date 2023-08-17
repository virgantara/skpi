<?php

use app\models\SimkatmawaMahasiswa;
use richardfan\widget\JSRegister;
use yii\helpers\Html;
?>
<div class="widget-box widget-color-blue2">
    <div class="widget-header">
        <h4 class="widget-title lighter smaller">Mahasiswa</h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <table id="tabel-mahasiswa" class="table table-bordered table-hovered table-striped">
                <?php
                if ($function == 'update') :
                    $mahasiswa = SimkatmawaMahasiswa::findAll(['simkatmawa_mandiri_id' => $simkatmawa_id]);

                    foreach ($mahasiswa as $mhs) :
                ?>
                        <tr id="">
                            <td><?= Html::textInput('hint[]', $mhs->nim . ' - ' . $mhs->nama . ' - '  . $mhs->prodi . ' - ' . $mhs->kampus, ['class' => 'form-control', 'placeholder' => 'Masukkan NIM']) ?></td>
                            <td><?= Html::button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-sm btn-success btn-plus']) ?> <?= Html::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-sm btn-danger btn-minus']) ?></td>
                        </tr>
                <?php
                    endforeach;
                endif; ?>
                <tr id="">
                    <td><?= Html::textInput('hint[]', '', ['class' => 'form-control', 'placeholder' => 'Masukkan NIM']) ?></td>
                    <td><?= Html::button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-sm btn-success btn-plus']) ?> <?= Html::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-sm btn-danger btn-minus']) ?></td>
                </tr>
            </table>
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