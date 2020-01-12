<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\RiwayatPelanggaran;

/* @$$this yii\web\View */
/* @$$model app\models\BarangOpname */
/* @$$form yii\widgets\ActiveForm */


$tanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');
$this->title = 'Laporan Rincian Pelanggaran';
$this->params['breadcrumbs'][] = ['label' => 'EKD', 'url' => ['laporan/rincian-pelanggaran']];
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
        <table class="table table-striped table-bordered table-hover" id="tabel_ekd">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Kampus</th>
                    <th>Prodi</th>
                    <th>Kategori<br>Pelanggaran</th>
                    <th>Pelanggaran</th>
                    <th>Hukuman</th>
                </tr>
            </thead>
            <tbody>
                
                <?php 

                $i = 0;
                foreach($results as $q=> $item)
                {
                    $pelanggaran = RiwayatPelanggaran::find()->where(['nim'=>$item['nim_mhs']])->all();
                    foreach($pelanggaran as $qq=> $pp)
                    {
                        $i++;
                ?>
                <tr>
                <td><?=$i;?></td>
                <td><?=$item['nim_mhs'];?></td>
                <td><?=$item['nama_mahasiswa'];?></td>
                <td><?=$item['nama_kampus'];?></td>
                <td><?=$item['nama_prodi'];?></td>
                <td><?=$pp->pelanggaran->kategori->nama;?></td>
                <td><?=$pp->pelanggaran->nama;?></td>
                <td><?php
                foreach($pp->riwayatHukumen as $h)
                    echo $h->hukuman->nama.', ';
                ?></td>
                </tr>
                <?php
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