<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\assets\HighchartAsset;
use app\helpers\MyHelper;
use app\models\SimakMasterprogramstudi;
use app\models\SimakTahunakademik;
use kartik\select2\Select2;

$this->title = Yii::t('app', Yii::$app->name);

HighchartAsset::register($this);

?>

<div class="page-header">
  <h1>
    Selamat datang di Sistem Informasi SKPI
  </h1>
</div>
<div class="row">
  <div class="col-md-3">
    <div class="widget-box transparent">
      <div class="widget-header">
        <h4 class="widget-title lighter smaller">
          <i class="ace-icon fa fa-rss orange"></i>Jumlah Pemohon SKPI

        </h4>
      </div>
      <div class="widget-body">
        <div class="widget-main padding-4">
          <div class="tab-content padding-8">
           <div class="col-sm-6 infobox-container">
              <div class="infobox infobox-green  infobox-dark">
                <div class="infobox-progress">
                  
                </div>

                <div class="infobox-data">
                  <div class="infobox-content">Disetujui</div>
                  <div class="infobox-content"><span id="status_pengajuan_2"></span></div>
                </div>
              </div>
              <div class="infobox infobox-blue  infobox-dark">
                <div class="infobox-chart">
                  
                </div>

                <div class="infobox-data">
                  <div class="infobox-content">Diproses</div>
                  <div class="infobox-content"><span id="status_pengajuan_1"></span></div>
                </div>
              </div>
              <div class="infobox infobox-grey  infobox-dark">
                <div class="infobox-icon">
                  <!-- <i class="ace-icon fa fa-download"></i> -->
                </div>

                <div class="infobox-data">
                  <div class="infobox-content">Belum Diajukan</div>
                  <div class="infobox-content"><span id="status_pengajuan_0"></span>
                  </div>
                </div>
              </div>
              <div class="infobox infobox-red  infobox-dark">
                <div class="infobox-icon">
                  <!-- <i class="ace-icon fa fa-download"></i> -->
                </div>

                <div class="infobox-data">
                  <div class="infobox-content">Ditolak</div>
                  <div class="infobox-content"><span id="status_pengajuan_3"></span>
                  </div>
                </div>
              </div>
            </div>
           
          </div>
        </div>

      </div>
    </div>

  </div>
  <div class="col-md-6">
    <div class="widget-box transparent">
      <div class="widget-header">
        <h4 class="widget-title lighter smaller">
          <i class="ace-icon fa fa-rss orange"></i>Data Pengusul SKPI Per Fakultas

        </h4>

        <div class="pull-right">

        </div>
      </div>

      <div class="widget-body">
        <div class="widget-main padding-4">
          <div class="tab-content padding-8">

            
            <div id="containerPerFakultas" style="min-width: 200;  margin: 0 auto">

            </div>
          </div>
        </div><!-- /.widget-main -->
      </div><!-- /.widget-body -->
    </div><!-- /.widget-box -->
  </div>
  <div class="col-md-3">
    <div class="widget-box transparent">
      <div class="widget-header">
        <h4 class="widget-title lighter smaller">
          <i class="ace-icon fa fa-rss orange"></i>Quick Links

        </h4>
      </div>
      <div class="widget-body">
        <div class="widget-main padding-4">
          <h4>- <?=Html::a('Data Pemohon',['skpi-permohonan/index']);?></h4>

          <h4>- <?=Html::a('KKNI',['simak-univ/index']);?></h4>
          <h4>- <?=Html::a('CPL',['capaian-pembelajaran-lulusan/index']);?></h4>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  
</div>


<?php

$this->registerJs(' 


$(document).ready(function(e){

  $.ajax({

    type : "POST",
    url : "/skpi-permohonan/ajax-count-permohonan-per-fakultas",
    async: true,
    beforeSend: function(){
       
    },
    error: function(e){
      console.log(e)
    },
    success: function(data){
        var hasil = $.parseJSON(data)
        var kategori = []
        var chartData = []
        $.each(hasil, function(i, obj) {
          kategori.push(obj.nama_fakultas)
          let color = "#"+(Math.random() * 0xFFFFFF << 0).toString(16).padStart(6, "0");
          var tmp = {
            y: eval(obj.total),
            name: obj.nama_fakultas,
            color: color
          }

          chartData.push(tmp)
        })
        Highcharts.chart("containerPerFakultas", {
          chart: {
            type: "column"
          },
          title: {
            text: null
          },
          subtitle: {
            text: null
          },
          xAxis: {
            categories: kategori,
            title: {
              text: "Pengusul SKPI per Fakultas"
            }
          },
          yAxis: {
            min: 0,
            title: {
              text: "Jumlah",
              align: "high"
            },
            labels: {
              overflow: "justify"
            }
          },
          
          plotOptions: {
            bar: {
              dataLabels: {
                enabled: true
              }
            },
            series: {
              cursor: "pointer",
              point: {
                events: {
                  click: function() {

                  }
                }
              }
            }
          },
          credits: {
            enabled: false
          },
          series: [{
            name: "Data Fakultas",
            data: chartData,
            // color: warna
          }],

        });
    }
  })

  $.ajax({

    type : "POST",
    url : "/skpi-permohonan/ajax-count-permohonan",
    async: true,
   
    beforeSend: function(){
       Swal.fire({
            title : "Please wait",
            html: "Processing your request...",
            
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            },
            
        })
    },
    error: function(e){
        Swal.close()
    },
    success: function(data){
        Swal.close()
        var data = $.parseJSON(data)
        $.each(data, function(i,obj){
          $("#status_pengajuan_"+obj.status_pengajuan).html(obj.total)
        })
    }
  })
})


', \yii\web\View::POS_READY);

?>