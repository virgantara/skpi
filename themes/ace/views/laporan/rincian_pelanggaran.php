<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\RiwayatPelanggaran;
use app\models\SimakKampus;
use kartik\date\DatePicker;
/* @$$this yii\web\View */
/* @$$model app\models\BarangOpname */
/* @$$form yii\widgets\ActiveForm */


$this->title = 'Laporan Rincian Pelanggaran';
$this->params['breadcrumbs'][] = ['label' => 'EKD', 'url' => ['laporan/rincian-pelanggaran']];
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
        'format' => 'dd-mm-yyyy'
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
        'format' => 'dd-mm-yyyy'
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
        <table class="table table-striped table-bordered table-hover" id="tabel_ekd">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Semester</th>
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
                    $kampus=SimakKampus::find()->where(['kode_kampus'=>$item->nim0->kampus])->one();
                    $pelanggaran = RiwayatPelanggaran::find()->where(['nim'=>$item->nim0->nim_mhs])->all();
                    foreach($pelanggaran as $qq=> $pp)
                    {
                        $i++;
                ?>
                <tr>
                <td><?=$i;?></td>
                <td><?=\app\helpers\MyHelper::YmdtodmY($item->tanggal);?></td>
                <td><?=$item->nim0->nim_mhs;?></td>
                <td><?=$item->nim0->nama_mahasiswa;?></td>
                <td><?=$item->nim0->semester;?></td>
                <td><?=$kampus->nama_kampus;?></td>
                <td><?=$item->nim0->kodeProdi->singkatan;?></td>
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