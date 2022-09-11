<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\RiwayatPelanggaran;
use app\models\SimakKampus;
use kartik\date\DatePicker;
use yii\httpclient\Client;
/* @$$this yii\web\View */
/* @$$model app\models\BarangOpname */
/* @$$form yii\widgets\ActiveForm */


$this->title = 'Laporan Rekap Perizinan';
$this->params['breadcrumbs'][] = ['label' => 'EKD', 'url' => ['laporan/rekap-perizinan']];
$this->params['breadcrumbs'][] = $this->title;
// $listDepartment = \app\models\Departemen::getListDepartemens();

$model->tanggal_awal = !empty($_POST['IzinMahasiswa']['tanggal_awal']) ? $_POST['IzinMahasiswa']['tanggal_awal'] : date('01-m-Y');
$model->tanggal_akhir = !empty($_POST['IzinMahasiswa']['tanggal_akhir']) ? $_POST['IzinMahasiswa']['tanggal_akhir'] : date('d-m-Y');

?>
<h1><?= Html::encode($this->title) ?></h1>
<style type="text/css">
.ui-datepicker-calendar {
    display: none;
}

.lebar{
    width: 60px;
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
       <button type="submit" name='btn-search' value='1' class ='btn btn-info' > <i class="ace-icon fa fa-search bigger-110"></i>Cari </button>
       <button type="submit" name='btn-export' value='2' class ='btn btn-success' > <i class="ace-icon fa fa-download bigger-110"></i>Export XLS </button>
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
                    <th rowspan="2" width="160px">Fakultas</th>
                    <th rowspan="2"  width="50px">Prodi</th>
                    <th colspan="4">I/II</th>
                    <th colspan="4">III/IV</th>
                    <th colspan="4">V/VI</th>
                    <th colspan="4">VII/VIII</th>
                    <th colspan="4">IX+</th>
                    
                </tr>
                <tr>

                   
                    <?php
                    for($i = 0 ;$i<5;$i++){
                    ?>
                     <th class="lebar">Jumlah</th>
                    <th class="lebar">Izin</th>
                    <th class="lebar">Sudah<br>Pulang</th>
                    <th class="lebar">Belum<br>Pulang</th>
                    <?php 
                }
                    ?>
                </tr>
            </thead>
            <tbody>

                <?php 

                $i = 0;

                if(!empty($resultsSemua))
                {

                foreach($list_prodi as $q=> $item)
                {
                    $i++;


                    ?>
                    <tr>
                       <td rowspan="<?=count($item['items']);?>"><?=$item['nama_fakultas'];?></td>
                       <td><?=$item['items'][0]['singkatan'];?></td>
                       <?php 

                       $tmpAll = 0;$tmp = 0;$tmpBlm = 0;
                       for($j = 1;$j<=10;$j++)
                       {
                            // print_r($resultsSemua[$item['kode_fakultas']][$item['items'][0]['kode_prodi']][$j]);exit;
                            $valAll = !empty($resultsSemua[$item['kode_fakultas']][$item['items'][0]['kode_prodi']][$j]) ? $resultsSemua[$item['kode_fakultas']][$item['items'][0]['kode_prodi']][$j] : 0;

                            $tmpAll += $valAll;
                            $tmp += !empty($results[$item['kode_fakultas']][$item['items'][0]['kode_prodi']][$j]) ? $results[$item['kode_fakultas']][$item['items'][0]['kode_prodi']][$j] : 0;
                            $tmpBlm += !empty($resultsBelumPulang[$item['kode_fakultas']][$item['items'][0]['kode_prodi']][$j]) ? $resultsBelumPulang[$item['kode_fakultas']][$item['items'][0]['kode_prodi']][$j] : 0;
                            if($j % 2 != 0){
                                $tmpAll = 0;$tmp = 0;$tmpBlm = 0;
                                continue;
                            } 


                       ?>
                       <td><?= $tmpAll;?></td>
                       <td><?php 
                        $jml = $tmp;
                        echo $jml;?>   
                       </td>
                       <td>
                        <?php 
                        $jmlBelumPulang = $tmpBlm;
                        echo $jml - $jmlBelumPulang;
                        ?></td>
                       <td><?=$jmlBelumPulang;?></td>

                      <?php 
                  }
                      ?>
                    </tr>
                    <?php 

                    for($j=1;$j<count($item['items']);$j++)
                    {
                        $p = $item['items'][$j];

                    ?>
                    <tr>
                        <td><?=$p['singkatan'];?></td>
                          <?php 

                       $tmpAll = 0;$tmp = 0;$tmpBlm = 0;
                       for($k = 1;$k<=10;$k++)
                       {
                            $tmpAll += !empty($resultsSemua[$item['kode_fakultas']][$p['kode_prodi']][$k]) ? $resultsSemua[$item['kode_fakultas']][$p['kode_prodi']][$k] : 0;
                            $tmp += !empty($results[$item['kode_fakultas']][$p['kode_prodi']][$k]) ?$results[$item['kode_fakultas']][$p['kode_prodi']][$k] : 0;
                            $tmpBlm += !empty($resultsBelumPulang[$item['kode_fakultas']][$p['kode_prodi']][$k]) ? $resultsBelumPulang[$item['kode_fakultas']][$p['kode_prodi']][$k] : 0;
                            if($k % 2 != 0){
                                $tmpAll = 0;$tmp = 0;$tmpBlm = 0;
                                continue;
                            } 


                       ?>
                       <td><?= $tmpAll;?></td>
                       <td><?php 
                        $jml = $tmp;
                        echo $jml;?>   
                       </td>
                       <td>
                        <?php 
                        $jmlBelumPulang = $tmpBlm;
                        echo $jml - $jmlBelumPulang;
                        ?></td>
                       <td><?=$jmlBelumPulang;?></td>

                      <?php 
                  }
                      ?>
                       
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
   $("th, td").addClass("text-center");



        ', \yii\web\View::POS_READY);

        ?>