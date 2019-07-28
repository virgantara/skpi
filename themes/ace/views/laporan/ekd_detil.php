<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<h1><?= Html::encode($this->title) ?></h1>


<div class="barang-opname-form">

<div class="row">
    <div class="col-sm-12">
        <table class="table table-striped" id="tabel_ekd">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Dosen</th>
                    <th>Nama Dosen</th>
                    <th>Kode MK</th>
                    <th>Nama MK</th>
                    <th>SKS</th>
                    <th>Nilai Angka</th>
                    <th>Nilai Huruf</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<form id="form-ekd">
    <input type="hidden" id="ta" value="<?=$ta;?>"/>
    <input type="hidden" id="kode" value="<?=$kode;?>"/>
    <input type="hidden" id="prodi" value="<?=$prodi;?>"/>
</form>  
</div>
<?php

$this->registerJs(' 

    $(document).ready(function(){

        var ta = $(\'#ta\').val();
        var prodi = $(\'#prodi\').val();
        var kode = $(\'#kode\').val();

        $.ajax({
            type : \'POST\',
            url : \'/api/ajax-get-ekd-detil\',
            data  : \'ta=\'+ta+\'&kode=\'+kode+\'&prodi=\'+prodi,
            success : function(data){
                $(\'#tabel_ekd > tbody\').empty();
                var row = \'\';
                $.each(data,function(i,obj){
                    
                    row += \'<tr>\';
                    row += \'<td>\'+(i+1)+\'</td>\';
                    row += \'<td>\'+obj.kode+\'</td>\';
                    row += \'<td>\'+obj.nama+\'</td>\';
                    row += \'<td>\'+obj.kode_mk+\'</td>\';
                    row += \'<td>\'+obj.nama_mk+\'</td>\';
                    row += \'<td>\'+obj.sks+\'</td>\';
                    row += \'<td>\'+obj.nilai_angka+\'</td>\';
                    row += \'<td>\'+obj.nilai_huruf+\'</td>\';
                    row += \'<td>\'+obj.keterangan+\'</td>\';
                    row += \'</tr>\';

                });

                $(\'#tabel_ekd > tbody\').append(row);
            }
        });
    });


    ', \yii\web\View::POS_READY);

?>