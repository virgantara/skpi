<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\daterange\DateRangePicker;
use app\assets\HighchartAsset;

HighchartAsset::register($this);
use app\assets\DatatableAsset;
DatatableAsset::register($this);
setlocale(LC_TIME, 'id_ID.utf8');
/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatanHarian */


$jenis_kegiatan = !empty($_GET['jenis_kegiatan']) ? $_GET['jenis_kegiatan'] : '';
$bulan = !empty($_GET['bulan']) ? $_GET['bulan'] : date('m');
$kampus = !empty($_GET['kampus']) ? $_GET['kampus'] : '';

 $bulans = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember',
];

$this->title = 'Rekap Kegiatan Bulanan ';
$this->params['breadcrumbs'][] = ['label' => 'Kegiatan Harian', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$list_kampus = ArrayHelper::map(\app\models\SimakKampus::getList(),'kode_kampus','nama_kampus');



$hariIni = new \DateTime(date('Y-m-d',strtotime($sd)));
$tgl_awal = strftime('%A, %d %B %Y', $hariIni->getTimestamp());

$hariIni = new \DateTime(date('Y-m-d',strtotime($ed)));
$tgl_akhir = strftime('%A, %d %B %Y', $hariIni->getTimestamp());


?>
<div class="simak-kegiatan-harian-view">

    <h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'options' => [
            'tag' => false,
        ],
    ],
    'method' => 'GET',
    'action' => Url::to(['simak-kegiatan-harian/rekap-bulanan']),
    'options' => [
        'class' => 'form-horizontal'
    ]
]); ?>
<div class="form-group" >
    <label class="col-sm-3 control-label no-padding-right">Jenis Kegiatan</label>
    <div class="col-sm-9">
        <?=Html::dropDownList('jenis_kegiatan',$jenis_kegiatan,ArrayHelper::map($list_kategori,'kode','nama'));?>
    </div>
</div>  
<div class="form-group" >
    <label class="col-sm-3 control-label no-padding-right">Bulan</label>
    <div class="col-sm-9">
        <?=Html::dropDownList('bulan',$bulan,$bulans);?>
    </div>
</div>  
<div class="form-group" >
    <label class="col-sm-3 control-label no-padding-right">Kelas</label>
    <div class="col-sm-9">
        <?=Html::dropDownList('kampus',$kampus,$list_kampus);?>
    </div>
</div>  
<div class="clearfix form-actions">
    <div class="col-md-offset-3 col-md-9">

        <button class="btn btn-info" value="1" type="submit" name="btn-search">
            <i class="ace-icon glyphicon glyphicon-search bigger-110"></i>
            Apply Filter
        </button>

    </div>
</div>
<?php ActiveForm::end(); ?>

</div>

<div class="row">
    <div class="col-md-6">
        <h3>Persentase Kehadiran dari <?=$tgl_awal;?> hingga <?=$tgl_akhir;?></h3>
        <table id="dynamic-table"  class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Prodi</th>
                    <?php 
                    foreach($list_sholat as $kat)
                    {
                    ?>
                    <th class="text-center"><?=$kat->kegiatan->sub_kegiatan;?><br> (%)</th>
                    <?php
                    }
                    ?>
                   
                </tr>
                
            </thead>
            <tbody>
                <?php 

                $i = 0;
                foreach($list_prodi as $res)
                {
                    // $total_mhs = $res[];

                    // $hari = new \DateTime($res['tgl']);
                    // $d = strftime('%A, %d %B %Y', $hari->getTimestamp());
                ?>
                <tr>
                    <td><?=$i+1;?></td>
                    <td><?=$res['nama_prodi'];?></td>
                    <?php 
                    foreach($list_sholat as $kat)
                    {
                        $avg= $results[$res['kode_prodi']][$kat->kode];
                    ?>
                    <td class="text-center">
                        <?=$avg;?>        
                    </td>

                    <?php
                    }
                    ?>
                    
                </tr>
                <?php 
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <h3>Grafik Perkembangan Kehadiran per Hari</h3>
        <div class="chart-container">
            <div id="container" style="min-width: 310px; height: 600px; max-width: 100%; margin: 0 auto"></div>
        </div>
    </div>
</div>


<?php
$script = '



var myTable = $(\'#dynamic-table\')
    .DataTable( {
        pageLength: 50,
        bAutoWidth: false,
        "aoColumns": [
          { "bSortable": false },
          null, null,null, null, null,
          null
        ],
        "aaSorting": [],
        select: {
            style: \'multi\'
        }
    } );
getPerkembangan(20211)

function getPerkembangan(tahun_akademik){
    
    var obj = new Object;
    obj.tahun_akademik = tahun_akademik;
   
    $.ajax({

        type : "POST",
        url : "'.Url::to(['/simak-kegiatan-harian/ajax-perkembangan']).'",
        data : {
          dataPost : obj
        },
        async : true,
        error : function(e){
          $("#loading_akpam_lulus").hide();
        },
        beforeSend : function(){
          $("#loading_akpam_lulus").show(); 

        },
        success: function(hasil){
          var hasil = $.parseJSON(hasil);
          var kategori = [];

          var chartData = [];
          var kategories = []
          $.each(hasil.tanggal,function(i,obj){
            kategories.push(obj)
            
          });

          $.each(hasil.items,function(i,obj){
            // kategori.push(obj.kategori)
            var o = new Object
            o.name = obj.kategori
            o.data = obj.data
            o.type = "spline"
            chartData.push(o);
          });


          $("#container").highcharts({
            
            title: {
                text: "Perkembangan Sholat Jama\'ah di masjid"
            },

            xAxis: {
                categories : kategories,
                labels: {
                    rotation : -45
                }
            },
            yAxis: {
                title: {
                    text: "Jumlah Mahasiswa"
                },
                
            },
         
            series: chartData,

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: "horizontal",
                            align: "center",
                            verticalAlign: "bottom"
                        }
                    }
                }]
            }
          });
        }
    });
}

';
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);


?>
