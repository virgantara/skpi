<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BarangOpname */
/* @var $form yii\widgets\ActiveForm */


$tanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');
$this->title = 'Laporan Rekap EKD';
$this->params['breadcrumbs'][] = ['label' => 'EKD', 'url' => ['laporan/ekd']];
$this->params['breadcrumbs'][] = $this->title;
// $listDepartment = \app\models\Departemen::getListDepartemens();



?>
<h1><?= Html::encode($this->title) ?></h1>
<style type="text/css">
.ui-datepicker-calendar {
        display: none;
    }
</style>


<div class="barang-opname-form">
<form class="form-horizontal" id="form-ekd">
     <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Prodi</label>
        <div class="col-sm-2">
          <?= Html::dropDownList('prodi',!empty($_POST['prodi']) ? $_POST['prodi'] : $_POST['prodi'],$listProdi, ['prompt'=>'..Pilih Prodi..','id'=>'prodi']);?>

        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tahun</label>
        <div class="col-sm-2">
           <?= \yii\jui\DatePicker::widget([
             'options' => ['placeholder' => 'Pilih Tahun ...','id'=>'tahun'],
             'clientOptions' => [
                 'changeMonth' => false,
                'changeYear' => true,
                'showButtonPanel' => true,
             ],
             'name' => 'tahun',
             'value' => $tanggal,
            'dateFormat' => 'php:Y',
        ]
    ) ?>
       


        </div>
    </div>
    
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Semester</label>
        <div class="col-sm-2">
          <?= Html::dropDownList('semester','',['1'=>'Gasal','2'=>'Genap'], ['prompt'=>'..Pilih Semester..','id'=>'semester']);?>
        </div>
    </div>
    

        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> </label>
            <div class="col-sm-2">
 <?= Html::button(' <i class="ace-icon fa fa-check bigger-110"></i>Cari', ['class' => 'btn btn-info','name'=>'search','value'=>1,'id'=>'btn-search']) ?>    

            </div>
  
        </div>
     
</form>

<div class="row">
    <div class="col-sm-12">
        <table class="table table-striped" id="tabel_ekd">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Dosen</th>
                    <th>Nama Dosen</th>
                    <th>Rata-rata</th>
                    <th>Dalam<br> Huruf</th>
                    <th>Keterangan</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
  
</div>
<?php

$this->registerJs(' 

function popitup(url,label) {
    var w = screen.width * 0.7;
    var h = screen.height * 0.7;
    var left = screen.width / 2 - w / 2;
    var top = screen.height / 2 - h / 2;
    
    window.open(url,label,\'height=\'+h+\',width=\'+w+\',top=\'+top+\',left=\'+left);
    
}

$(document.body).on(\'click\', \'.ui-datepicker-close\', function (e) {
    var value = $(\'.ui-datepicker-year :selected\').text();
    $(\'#tahun\').val(value);
});

$(document).on(\'click\', \'.detil\', function (e) {
    e.preventDefault();
    var tahun = $(\'#tahun\').val();
    var semester = $(\'#semester\').val();
    var prodi = $(\'#prodi\').val();
    var kode = $(this).attr(\'data-item\');
    var url = \'/laporan/ekd-detil?tahun=\'+tahun+\'&semester=\'+semester+\'&prodi=\'+prodi+\'&kode=\'+kode;
    popitup(url,\'detil\');
});



$(document).ready(function(){
    $(\'#btn-search\').click(function(){

        var tahun = $(\'#tahun\').val();
        var semester = $(\'#semester\').val();
        var prodi = $(\'#prodi\').val();


        $.ajax({
            type : \'POST\',
            url : \'/api/ajax-get-ekd\',
            data  : $("#form-ekd").serialize(),
            success : function(data){

                // var hsl = $.parseJSON(data);
                $(\'#tabel_ekd > tbody\').empty();
                var row = \'\';
                $.each(data,function(i,obj){
                    row += \'<tr>\';
                    row += \'<td>\'+(i+1)+\'</td>\';
                    row += \'<td>\'+obj.kode+\'</td>\';
                    row += \'<td>\'+obj.nama+\'</td>\';
                    row += \'<td>\'+obj.nilai_angka+\'</td>\';
                    row += \'<td>\'+obj.nilai_huruf+\'</td>\';
                    row += \'<td>\'+obj.keterangan+\'</td>\';
                    row += \'<td><a class="btn btn-info detil" data-item="\'+obj.kode+\'" href="javascript:void(0)">Lihat Rincian</a>\';
                    row += \'&nbsp;<a class="btn btn-success print" data-item="\'+obj.kode+\'" href="javascript:void(0)">Print EKD</a>\';
                    row += \'</td>\';
                    row += \'</tr>\';

                });

                $(\'#tabel_ekd > tbody\').append(row);
            }
        });
    });
});



    ', \yii\web\View::POS_READY);

?>