<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\assets\HighchartAsset;
$this->title = Yii::t('app', Yii::$app->name);

HighchartAsset::register($this);
$listAsrama = \app\models\Asrama::find()->all();
?>
<style type="text/css">
.containerAsrama {
    height: 130px;
}

</style>
<div class="alert alert-block alert-success">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>

    <i class="ace-icon fa fa-check green"></i>

    Welcome to
    <strong class="green">
        <?=Yii::$app->name;?>
        <small>(v1.4)</small>
    </strong>,

</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-lg-6 col-md-6">
          <div class="widget-box transparent">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Grafik Jumlah Pelanggaran
              </h4>
               <div id="loadingBuy" style="display: none">Fetching...</div>
            </div>

            <div class="widget-body">
              <div class="widget-main padding-4">
                <div class="tab-content padding-8">
                  <select name="year"  id="tahun_pelanggan_kategori">
  <option value=''>Select Year</option>
  <?php
    for ($year = 2014; $year <= 2030; $year++) {
      $selected = (date('Y')==$year) ? 'selected' : '';
        echo "<option value=$year $selected>$year</option>";
      
    }
  ?>
</select>
<div class="table-responsive">
                 <div id="container" style="min-width: 310px; height: 500px; margin: 0 auto"></div>
</div>
                </div>
              </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
          </div><!-- /.widget-box -->
        </div><!-- /.col -->

</div>
<div class="row">
     <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
          <div class="widget-box transparent">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Kapasitas Asrama
              </h4>
               <div id="loadingGauge" style="display: none">Fetching...</div>
            </div>

            <div class="widget-body">
              <div class="widget-main padding-4">
                <div class="tab-content padding-8">
                 

                    <?php 
                    
                    foreach($listAsrama as $a)
                    {
                    ?><div class="table-responsive">
                 <div class="containerAsrama" id="containerAsrama<?=$a->id;?>" style="min-width: 200;  margin: 0 auto"></div> </div>
                 <?php 
             }
                 ?>
            
                </div>
              </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
          </div><!-- /.widget-box -->
        </div><!-- /.col -->

</div>
<?php
$script = '

function getPelanggaran(tahun){

  $.ajax({
      type : "POST",
      data : "tahun="+tahun,
      url : "'.Url::to(["api/ajax-get-jumlah-pelanggaran-by-kategori"]).'",
      async: true,
      beforeSend : function(){
        $("#loadingBuy").show();
      },
      error : function(e){
          console.log(e.responseText);
         $("#loadingBuy").hide();
      },
      success : function(data){
         $("#loadingBuy").hide();
        var hasil = $.parseJSON(data);
        
        var kategori = [];
        var chartDataRingan = [];
        var chartDataSedang = [];
        var chartDataBerat = [];

        $.each(hasil.ringan,function(i,obj){
          kategori.push(obj.bulan);
          chartDataRingan.push(obj.jumlah);
        });

        $.each(hasil.sedang,function(i,obj){
          chartDataSedang.push(obj.jumlah);
        });

        $.each(hasil.berat,function(i,obj){
          chartDataBerat.push(obj.jumlah);
        });

        $("#container").highcharts({
          chart: {
                type: "column"
            },
          title: {
              text: "Grafik Pelanggaran "+tahun
          },

          xAxis: {
            categories: kategori,
            crosshair: true
          },
          yAxis: {
              title: {
                  text: "Jumlah"
              }
          },
         tooltip: {
        headerFormat: "<span style=\"font-size:10px\">{point.key}</span><table>",
        pointFormat: "<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>" +
            "<td style=\"padding:0\"><b>{point.y}</b></td></tr>",
        footerFormat: "</table>",
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },

          series: [{
              name: "Pelanggaran Ringan ",
              data: chartDataRingan,
               color: "#19ca07"
          },{
              name: "Pelanggaran Sedang ",
              data: chartDataSedang,
               color: "#e58b31"
          },{
              name: "Pelanggaran Berat ",
              data: chartDataBerat,
              color: "#FF0000"
          }
          ],

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

$("#tahun_pelanggan_kategori").change(function(){
    getPelanggaran($(this).val());
});

var tahun = $("#tahun_pelanggan_kategori").val();
getPelanggaran(tahun);

function generateDataAsrama(id, kategori, kapasitas, nilai){
    Highcharts.chart("containerAsrama"+id, {
        plotOptions: {
            series: {
                pointPadding: 0.25,
                borderWidth: 0,
                color: \'#000\',
                targetOptions: {
                    width: \'200%\'
                }
            }
        },
        chart: {
            marginTop: 40,
            inverted: true,
            marginLeft: 135,
            type: \'bullet\'
        },
        title: {
            text: kategori
        },
        xAxis: {
            categories: ["<span class=\"hc-cat-title\">"+kategori+"</span>"]
        },
        yAxis: {
            plotBands: [{
                from: 0,
                to: kapasitas,
                color: "#18ca2a"
            }, {
                from: kapasitas,
                to: kapasitas+100,
                color: "#d31414"
            }],
            title: null
        },
        series: [{
            data: [{
                y: nilai,
                target: kapasitas
            }]
        }],
        tooltip: {
            pointFormat: "<b>{point.y}</b> (with target at {point.target})"
        }
    });
}
$.ajax({
      type : "POST",
      data : "tahun="+tahun,
      url : "'.Url::to(["api/ajax-get-kapasitas-asrama"]).'",
      async: true,
      beforeSend : function(){
        $("#loadingGauge").show();
      },
      error : function(e){
          console.log(e.responseText);
         $("#loadingGauge").hide();
      },
      success : function(data){
         $("#loadingGauge").hide();
        var hasil = $.parseJSON(data);
       

        $.each(hasil,function(i,obj){
            generateDataAsrama(obj.id, obj.nama, obj.total, obj.terpakai)    
        });
        
    }
});



';
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);


?>
