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
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Dosen</th>
                    <th>Nama Dosen</th>
                    <th>Nilai Angka</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                </tr>
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
                success : function(data){
                    console.log(data);
                }
            });
        });
    });


    ', \yii\web\View::POS_READY);

?>