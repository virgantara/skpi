<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @$$this yii\web\View */
/* @$$model app\models\BarangOpname */
/* @$$form yii\widgets\ActiveForm */


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
 <?php $form = ActiveForm::begin([
        
        'options' => [
            'class' => 'form-horizontal'
        ]
    ]); ?> 
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tahun</label>
        <div class="col-sm-2">
          <select name="tahun">
              <option>Pilih tahun</option>
              <?php 
              for($i=2014;$i<date('Y')+10;$i++){
                $selected = !empty($_POST['tahun']) && $_POST['tahun'] == $i ? 'selected' : '';
                echo '<option '.$selected.' value="'.$i.'">'.$i.'</option>';
              }
              ?>
          </select>

        </div>
    </div>
    
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Semester</label>
        <div class="col-sm-2">
            <?php 
            $selected = !empty($_POST['semester']) ? $_POST['semester'] : '';
            ?>
          <?= Html::dropDownList('semester',$selected,['1'=>'Gasal','2'=>'Genap'], ['prompt'=>'..Pilih Semester..','id'=>'semester']);?>
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
 <?= Html::submitButton(' <i class="ace-icon fa fa-check bigger-110"></i>Cari', ['class' => 'btn btn-info','name'=>'search','value'=>1,'id'=>'btn-search']) ?>    
<!-- <span id="loading" style="display: none">Loading...</span> -->
            </div>
  
        </div>
<?php ActiveForm::end(); ?>
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
                <?php 
                $counter = 0;
                

                if(!empty($results['pedagogik']))
                {
                    $i = 0;
                    foreach($results['pedagogik'] as $q => $obj)
                    {


                        $counter++;
                        $angka_pro = $results['profesional'][$q]['angka'];
                        $angka_pri = $results['kepribadian'][$q]['angka'];
                        $angka_sos = $results['sosial'][$q]['angka'];
                        
                        $huruf = "";
                        $ket = "";
                        $skor = ($obj['angka'] + $angka_pro + $angka_pri + $angka_sos) / 4;
                        
                        if($skor >= 126){
                            $huruf = "A";
                            $ket = "Dilaporkan kepada Rektor untuk diberi reward sertifikat dan insentif tertentu penambah semangat kerja";
                        }
                        else if($skor >= 101){
                            $huruf = "B";
                            $ket = "Dilaporkan kepada Rektor untuk diberi reward sertifikat";
                        }
                        else if($skor >= 76){
                            $huruf = "C";
                            $ket = "Dilaporkan kepada Rektor bahwa yang bersangkutan telah mencukupi kinerjanya";
                        }
                        else if($skor >= 51){
                            $huruf = "D";
                            $ket = "<td>Dilaporkan kepada Rektor untuk diberi peringatan.</td>";
                        }
                        else if($skor >= 30){
                            $huruf = "E";
                            $ket = "Dilaporkan kepada Rektor untuk diberikan sanksi tertentu yang mendukung peningkatan kinerjanya";
                        }
                        else{
                            $huruf = "F";
                            $ket = "-";
                        }

                        // print_r($results['sosial'][$q]);
                        // print_r($skor);
                        // print_r($huruf);
                        // exit;
                        if($huruf != "F"){
                        
                            $i++;
                ?>
                
                <tr>
                <td><?=($i);?></td>
                <td><?=$obj['kd_dsn'];?></td>
                <td><?=$obj['nm_dsn'];?></td>
                <td><?=$obj['angka'];?></td>
                <td><?=$angka_pro;?></td>
                <td><?=$angka_pri;?></td>
                <td><?=$angka_sos;?></td>
                <td><?=$skor;?></td>
                <td><?=$huruf;?></td>
                <td><?=$ket;?></td>
                </tr>
                <?php
                            
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
  
</div>
<?php

$this->registerJs(' 
    $(document.body).on(\'click\', \'.ui-datepicker-close\', function (e) {
        $value = $(\'.ui-datepicker-year :selected\').text();
        $(\'#tahun\').val(value);
    });



    ', \yii\web\View::POS_READY);

?>