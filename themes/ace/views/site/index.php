<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\assets\HighchartAsset;
$this->title = Yii::t('app', Yii::$app->name);

HighchartAsset::register($this);

?>
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
	<div class="col-xs-12 col-sm-12 col-lg-9 col-md-9">
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

                 <div id="container" style="min-width: 310px; height: 500px; margin: 0 auto"></div>

                </div>
              </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
          </div><!-- /.widget-box -->
        </div><!-- /.col -->


    
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
              text: "Grafik Pelanggaran"
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

';
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);


?>
