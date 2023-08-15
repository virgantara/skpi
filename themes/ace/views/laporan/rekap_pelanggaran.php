<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\models\RiwayatPelanggaran;

/* @$$this yii\web\View */
/* @$$model app\models\BarangOpname */
/* @$$form yii\widgets\ActiveForm */

$this->title = 'Laporan Rekap Pelanggaran';
$this->params['breadcrumbs'][] = ['label' => 'EKD', 'url' => ['laporan/rekap-pelanggaran']];
$this->params['breadcrumbs'][] = $this->title;
// $listDepartment = \app\models\Departemen::getListDepartemens();

$model->tanggal_awal = !empty($_POST['RiwayatPelanggaran']['tanggal_awal']) ? $_POST['RiwayatPelanggaran']['tanggal_awal'] : date('01-m-Y');
$model->tanggal_akhir = !empty($_POST['RiwayatPelanggaran']['tanggal_akhir']) ? $_POST['RiwayatPelanggaran']['tanggal_akhir'] : date('d-m-Y');

?>
<h1><?= Html::encode($this->title) ?></h1>
<style type="text/css">
.ui-datepicker-calendar {
        display: none;
    }
</style>


<div class="barang-opname-form">
  <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'options' => [
                'tag' => false,
            ],
        ],
        'options' => [
            'class' => 'form-horizontal'
        ]
    ]); ?> 
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tanggal Awal</label>
        <div class="col-sm-2">
           <?= DatePicker::widget([
    'model' => $model,
    'attribute' => 'tanggal_awal',
    // 'value' => date('01-m-Y'),
    'readonly' => true,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd'
    ]
]) ?>

        </div>
    </div>
    
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tanggal Akhir</label>
        <div class="col-sm-2">
          <?= DatePicker::widget([
            'model' => $model,
    'attribute' => 'tanggal_akhir',
    // 'value' => $model->tanggal_akhir,
    'readonly' => true,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd'
    ]
]) ?>
        </div>
    </div>
    
   
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> </label>
            <div class="col-sm-2">
 <?= Html::submitButton(' <i class="ace-icon fa fa-check bigger-110"></i>Cari', ['class' => 'btn btn-info','name'=>'search','value'=>1,'id'=>'btn-search']) ?>&nbsp;
 <?php

  // Html::submitButton(' <i class="ace-icon fa fa-download bigger-110"></i>Export', ['class' => 'btn btn-success','name'=>'search','value'=>1,'id'=>'btn-export'])
  ?>    
<!-- <span id="loading" style="display: none">Loading...</span> -->
            </div>
  
        </div>
<?php ActiveForm::end(); ?>
<div class="row">
    <div class="col-sm-12">
        <h3>Rekap Per Semester</h3>
        <table class="table table-striped table-bordered table-hover" id="tabel_ekd">
            
            <thead>
                <tr>
                    <th>No</th>
                    <th>Semester</th>
                    <th>Total</th>    
                </tr>
            </thead>
            <tbody>
                
                <?php 

                $i = 0;
                foreach($results as $q=> $item)
                {
                    $i++;
                ?>
                <tr>
                <td><?=$i;?></td>
                <td><?=$item['smt'];?></td>
                <td><?=$item['total'];?></td>
                </tr>
                <?php
                    
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <h3>Rekap Per Prodi</h3>
        <table class="table table-striped table-bordered table-hover" id="tabel_ekd">
            
            <thead>
                <tr>
                    <th>No</th>
                    <th>Prodi</th>
                    <th>Total</th>    
                </tr>
            </thead>
            <tbody>
                
                <?php 

                $i = 0;
                foreach($resultsProdi as $q=> $item)
                {
                    $i++;
                ?>
                <tr>
                <td><?=$i;?></td>
                <td><?=$item['prodi'];?></td>
                <td><?=$item['total'];?></td>
                </tr>
                <?php
                    
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