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

  <div class="col-xs-12 col-sm-12 col-lg-4 col-md-4">
    <div class="widget-box transparent">
      <div class="widget-header">
        <h4 class="widget-title lighter smaller">
          <i class="ace-icon fa fa-rss orange"></i>Top Pelanggaran Ringan
          <span id="loadingringan" style="display: none">Fetching...</span>
        </h4>
         
         <div class="pull-right">
          <a href="javascript:void(0)" class="btn btn-xs btn-info" id="kembalilv2ringan" style="display: none"> <i class="glyphicon glyphicon-step-backward"></i> Kembali</a>
          <a href="javascript:void(0)" class="btn btn-xs btn-info" id="kembalilv3ringan" style="display: none"> <i class="glyphicon glyphicon-step-backward"></i> Kembali</a>
        </div>
      </div>

      <div class="widget-body">
        <div class="widget-main padding-4">
          <div class="tab-content padding-8">
           

               <div class="containerringan" id="containerringan" style="min-width: 200;  margin: 0 auto">
                 
               </div> 
            
          </div>
        </div><!-- /.widget-main -->
      </div><!-- /.widget-body -->
    </div><!-- /.widget-box -->
  </div><!-- /.col -->
  <div class="col-xs-12 col-sm-12 col-lg-4 col-md-4">
    <div class="widget-box transparent">
      <div class="widget-header">
        <h4 class="widget-title lighter smaller">
          <i class="ace-icon fa fa-rss orange"></i>Top Pelanggaran Sedang
          <span id="loadingsedang" style="display: none">Fetching...</span>
        </h4>
          <div class="pull-right">
          <a href="javascript:void(0)" class="btn btn-xs btn-warning" id="kembalilv2sedang" style="display: none"> <i class="glyphicon glyphicon-step-backward"></i> Kembali</a>
          <a href="javascript:void(0)" class="btn btn-xs btn-warning" id="kembalilv3sedang" style="display: none"> <i class="glyphicon glyphicon-step-backward"></i> Kembali</a>
        </div>
      </div>

      <div class="widget-body">
        <div class="widget-main padding-4">
          <div class="tab-content padding-8">
           

            <div class="table-responsive">
                 <div class="containersedang" id="containersedang" style="min-width: 200;  margin: 0 auto">
                   
                 </div> 
            </div>

          </div>
        </div><!-- /.widget-main -->
      </div><!-- /.widget-body -->
    </div><!-- /.widget-box -->
  </div><!-- /.col -->
  <div class="col-xs-12 col-sm-12 col-lg-4 col-md-4">
    <div class="widget-box transparent">
      <div class="widget-header">
        <h4 class="widget-title lighter smaller">
          <i class="ace-icon fa fa-rss orange"></i>Top Pelanggaran Berat
          <span id="loadingberat" style="display: none">Fetching...</span>
        </h4>
         <div class="pull-right">
          <a href="javascript:void(0)" class="btn btn-xs btn-danger" id="kembalilv2berat" style="display: none"> <i class="glyphicon glyphicon-step-backward"></i> Kembali</a>
          <a href="javascript:void(0)" class="btn btn-xs btn-danger" id="kembalilv3berat" style="display: none"> <i class="glyphicon glyphicon-step-backward"></i> Kembali</a>
        </div>
      </div>

      <div class="widget-body">
        <div class="widget-main padding-4">
          <div class="tab-content padding-8">
           

            <div class="table-responsive">
                 <div class="containerberat" id="containerberat" style="min-width: 200;  margin: 0 auto">
                   
                 </div> 
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


<div class="row">
     <div class="col-xs-12 col-sm-12 col-lg-4 col-md-6">
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

$(document).on("click","#kembalilv2ringan",function(e){
  var dataJenis = $(this).attr("data-jenis");
  var dataWarna = $(this).attr("data-warna");
  var dataCategory = $(this).attr("data-category");
  getTopPelanggaran("ringan","#5890e8");
  $(this).hide();

});

$(document).on("click","#kembalilv3ringan",function(e){
  var dataJenis = $("#kembalilv2ringan").attr("data-jenis");
  var dataWarna = $("#kembalilv2ringan").attr("data-warna");
  var dataCategory = $("#kembalilv2ringan").attr("data-category");
  getTopPelanggaranFakultas(dataJenis,dataCategory,"#5890e8");
  $("#kembalilv2ringan").show();
  $("#kembalilv3ringan").hide();
});


$(document).on("click","#kembalilv2sedang",function(e){
  var dataJenis = $(this).attr("data-jenis");
  var dataWarna = $(this).attr("data-warna");
  var dataCategory = $(this).attr("data-category");
  getTopPelanggaran("sedang","#e58b31");
  $(this).hide();
});

$(document).on("click","#kembalilv3sedang",function(e){
  var dataJenis = $("#kembalilv2sedang").attr("data-jenis");
  var dataWarna = $("#kembalilv2sedang").attr("data-warna");
  var dataCategory = $("#kembalilv2sedang").attr("data-category");
  getTopPelanggaranFakultas(dataJenis,dataCategory,"#e58b31");
  $("#kembalilv2sedang").show();
  $("#kembalilv3sedang").hide();
});


$(document).on("click","#kembalilv2berat",function(e){
  var dataJenis = $(this).attr("data-jenis");
  var dataWarna = $(this).attr("data-warna");
  var dataCategory = $(this).attr("data-category");
  getTopPelanggaran("berat","#d31414");
  $(this).hide();
});

$(document).on("click","#kembalilv3berat",function(e){
  var dataJenis = $("#kembalilv2berat").attr("data-jenis");
  var dataWarna = $("#kembalilv2berat").attr("data-warna");
  var dataCategory = $("#kembalilv2berat").attr("data-category");
  getTopPelanggaranFakultas(dataJenis,dataCategory,"#d31414");
  $("#kembalilv2berat").show();
  $("#kembalilv3berat").hide();
});

function getTopPelanggaran(kat,warna){

  $.ajax({
      type: "POST",
      url: "'.Url::to(["/api/ajax-get-pelanggaran-jumlah-terbanyak"]).'",
      data : {
        kategori : kat
      },
      async: true,
      beforeSend : function(){
        $("#loading"+kat).show();
      },
      error: function(e){
          console.log(e.responseText);
         $("#loading"+kat).hide();
      },
      success : function(data){
        $("#loading"+kat).hide();
        var hasil = $.parseJSON(data);

        var kategori = [];
        var dataitems = [];
        
        $.each(hasil,function(i,obj){
            var tmp = new Object;
            tmp.y = obj.total;
            tmp.name = obj.nama;

            dataitems.push(tmp);
            kategori.push(obj.nama); 

        }); 


        Highcharts.chart("container"+kat, {
          chart: {
              type: "bar"
          },
          title: {
              text: null
          },
          subtitle: {
              text: null
          },
          xAxis: {
            categories: kategori,
            title : {
              text : \'Pelanggaran\'
            }
          },
          yAxis: {
              min: 0,
              title: {
                  text: "Jumlah",
                  align: \'high\'
              },
              labels: {
                  overflow: \'justify\'
              }
          },
          tooltip: {
              valueSuffix: " Pelanggaran"
          },
          plotOptions: {
              bar: {
                  dataLabels: {
                      enabled: true
                  }
              },
              series: {
                  cursor: \'pointer\',
                  point: {
                      events: {
                          click: function() {
                            getTopPelanggaranFakultas(kat,this.category,warna);
                            $("#kembalilv2"+kat).attr("data-jenis",kat);
                            $("#kembalilv2"+kat).attr("data-category",this.category);
                            $("#kembalilv2"+kat).attr("data-warna",warna);
                            $("#kembalilv2"+kat).show();
                          }
                      }
                  }
              }
          },
          credits: {
              enabled: false
          },
          series: [{
              name: "Pelanggaran",
              data: dataitems,
              color: warna
          }],
          
        });

      }
  });
}

function getTopPelanggaranFakultas(kat,pel, warna){

  $.ajax({
      type: "POST",
      url: "'.Url::to(["/api/ajax-get-pelanggaran-jumlah-terbanyak-fakultas"]).'",
      data : {
        kategori : kat,
        pel_nama : pel
      },
      async: true,
      beforeSend : function(){
        $("#loading"+kat).show();
      },
      error: function(e){
          console.log(e.responseText);
         $("#loading"+kat).hide();
      },
      success : function(data){
        $("#loading"+kat).hide();
        var hasil = $.parseJSON(data);

        var kategori = [];
        var dataitems = [];
        
        $.each(hasil,function(i,obj){
            var tmp = new Object;
            tmp.y = obj.total;
            tmp.name = obj.nama;

            dataitems.push(tmp);
            kategori.push(obj.nama); 

        }); 


        Highcharts.chart("container"+kat, {
          chart: {
              type: "bar"
          },
          title: {
              text: null
          },
          subtitle: {
              text: null
          },
          xAxis: {
            categories: kategori,
            title : {
              text : \'Pelanggaran\'
            }
          },
          yAxis: {
              min: 0,
              title: {
                  text: "Banyak Pelanggaran",
                  align: \'high\'
              },
              labels: {
                  overflow: \'justify\'
              }
          },
          tooltip: {
              valueSuffix: " Pelanggaran"
          },
          plotOptions: {
              bar: {
                  dataLabels: {
                      enabled: true
                  }
              },
              series: {
                  cursor: \'pointer\',
                  point: {
                      events: {
                          click: function() {
                            getTopPelanggaranProdi(kat,pel,this.category,warna);
                            $("#kembalilv3"+kat).show();
                            $("#kembalilv2"+kat).hide();
                          }
                      }
                  }
              }
          },
          credits: {
              enabled: false
          },
          series: [{
              name: "Pelanggaran",
              data: dataitems,
              color: warna
          }],
          
        });

      }
  });
}


function getTopPelanggaranProdi(kat,pel,fak, warna){

  $.ajax({
      type: "POST",
      url: "'.Url::to(["/api/ajax-get-pelanggaran-jumlah-terbanyak-prodi"]).'",
      data : {
        kategori : kat,
        pel_nama : pel,
        fakultas : fak
      },
      async: true,
      beforeSend : function(){
        $("#loading"+kat).show();
      },
      error: function(e){
          console.log(e.responseText);
         $("#loading"+kat).hide();
      },
      success : function(data){
        $("#loading"+kat).hide();
        var hasil = $.parseJSON(data);

        var kategori = [];
        var dataitems = [];
        
        $.each(hasil,function(i,obj){
            var tmp = new Object;
            tmp.y = obj.total;
            tmp.name = obj.nama;

            dataitems.push(tmp);
            kategori.push(obj.nama); 

        }); 


        Highcharts.chart("container"+kat, {
          chart: {
              type: "bar"
          },
          title: {
              text: null
          },
          subtitle: {
              text: null
          },
          xAxis: {
            categories: kategori,
            title : {
              text : \'Pelanggaran\'
            }
          },
          yAxis: {
              min: 0,
              title: {
                  text: "Banyak Pelanggaran",
                  align: \'high\'
              },
              labels: {
                  overflow: \'justify\'
              }
          },
          tooltip: {
              valueSuffix: " Pelanggaran"
          },
          plotOptions: {
              bar: {
                  dataLabels: {
                      enabled: true
                  }
              },
              
          },
          credits: {
              enabled: false
          },
          series: [{
              name: "Pelanggaran",
              data: dataitems,
              color: warna
          }],
          
        });

      }
  });
}


getTopPelanggaran("ringan","#5890e8");
getTopPelanggaran("sedang","#e58b31");
getTopPelanggaran("berat","#d31414");


';
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);


?>
