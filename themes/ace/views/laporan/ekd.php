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
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tahun</label>
        <div class="col-sm-2">
          <select name="tahun">
              <option>Pilih tahun</option>
              <?php 
              for($i=2014;$i<date('Y')+10;$i++){
                echo '<option value="'.$i.'">'.$i.'</option>';
              }
              ?>
          </select>

        </div>
    </div>
    
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Semester</label>
        <div class="col-sm-2">
          <?= Html::dropDownList('semester','',['1'=>'Gasal','2'=>'Genap'], ['prompt'=>'..Pilih Semester..','id'=>'semester']);?>
        </div>
    </div>
    
     <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Prodi</label>
        <div class="col-sm-2">
          <?= Html::dropDownList('prodi',!empty($_POST['prodi']) ? $_POST['prodi'] : $_POST['prodi'],$listProdi, ['prompt'=>'..Pilih Prodi..','id'=>'prodi']);?>

        </div>
    </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> </label>
            <div class="col-sm-2">
 <?= Html::button(' <i class="ace-icon fa fa-check bigger-110"></i>Cari', ['class' => 'btn btn-info','name'=>'search','value'=>1,'id'=>'btn-search']) ?>    
<span id="loading" style="display: none">Loading...</span>
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
                    <th>Pedagogik</th>
                    <th>Profesional</th>
                    <th>Kepribadian</th>
                    <th>Sosial</th>
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
  
</div>
<?php

$this->registerJs(' 
    $(document.body).on(\'click\', \'.ui-datepicker-close\', function (e) {
        var value = $(\'.ui-datepicker-year :selected\').text();
        $(\'#tahun\').val(value);
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
                timeout : 15000,
                beforeSend : function(){
                    $("#loading").show();
                },
                error: function(e){
                    console.log(e);
                    $("#loading").hide();
                },
                success : function(data){
                    $("#loading").hide();
                    // var hsl = $.parseJSON(data);
                    $(\'#tabel_ekd > tbody\').empty();
                    var row = \'\';
                    var index = 0;
                    console.log(data);
                    // data = (array) data;
                    $.each(data[\'pedagogik\'],function(i,obj){
                        var angka_pro = data[\'profesional\'][i][\'angka\'];
                        var angka_pri = data[\'kepribadian\'][i][\'angka\'];
                        var angka_sos = data[\'sosial\'][i][\'angka\'];
                        
                        var huruf = "";
                        var ket = "";
                        var skor = (obj.angka + angka_pro + angka_pri + angka_sos) / 4;
                        
                        
                        if(skor >= 126){
                            huruf = "A";
                            ket = "Dilaporkan kepada Rektor untuk diberi reward sertifikat dan insentif tertentu penambah semangat kerja";
                        }
                        else if(skor >= 101){
                            huruf = "B";
                            ket = "Dilaporkan kepada Rektor untuk diberi reward sertifikat";
                        }
                        else if(obj.huruf == "C"){
                            huruf = "C";
                            ket = "Dilaporkan kepada Rektor bahwa yang bersangkutan telah mencukupi kinerjanya";
                        }
                        else if(obj.huruf == "D"){
                            huruf = "D";
                            ket = "<td>Dilaporkan kepada Rektor untuk diberi peringatan.</td>";
                        }
                        else if(obj.huruf == "E"){
                            huruf = "E";
                            ket = "Dilaporkan kepada Rektor untuk diberikan sanksi tertentu yang mendukung peningkatan kinerjanya";
                        }
                        else{
                            huruf = "F";
                            ket = "-";
                        }

                        if(huruf != "F"){
                            index++;
                            row += \'<tr>\';
                            row += \'<td>\'+(index)+\'</td>\';
                            row += \'<td>\'+obj.kd_dsn+\'</td>\';
                            row += \'<td>\'+obj.nm_dsn+\'</td>\';
                            row += \'<td>\'+obj.angka+\'</td>\';
                            row += \'<td>\'+angka_pro+\'</td>\';
                            row += \'<td>\'+angka_pri+\'</td>\';
                            row += \'<td>\'+angka_sos+\'</td>\';
                            row += \'<td>\'+skor+\'</td>\';
                            row += \'<td>\'+huruf+\'</td>\';
                            row += \'<td>\'+ket+\'</td>\';
                            row += \'</tr>\';
                        }
                    });

                    $(\'#tabel_ekd > tbody\').append(row);
                }
            });
        });
    });


    ', \yii\web\View::POS_READY);

?>