<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\IzinMahasiswaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Perizinan Mahasiswa';
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .swal2-overflow {
  overflow-x: visible;
  overflow-y: visible;
}
/*.swal-wide{
    width:850px !important;
    height:850px !important;
}*/

.swal2-container {
  z-index:10;
}
</style>

<div class="izin-mahasiswa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php 
if(Yii::$app->user->can('admin')){
    ?>
    <p>
        <?= Html::a('Create Perizinan Mahasiswa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php 
}
?>
   <?php 
    $gridColumns = [
    [
        'class'=>'kartik\grid\SerialColumn',
        'contentOptions'=>['class'=>'kartik-sheet-style'],
        'width'=>'36px',
        'pageSummary'=>'Total',
        'pageSummaryOptions' => ['colspan' => 6],
        'header'=>'',
        'headerOptions'=>['class'=>'kartik-sheet-style']
    ],
    
    'nim',
    'namaMahasiswa',
   // [
   //      'attribute' => 'namaFakultas',
   //      'label' => 'Fakultas',
   //      'format' => 'raw',
   //      'filter'=>$fakultas,
   //      'value'=>function($model,$url){
   //          return $model->namaFakultas;
            
   //      },
   //  ],
   [
        'attribute' => 'namaProdi',
        'label' => 'Prodi',
        'format' => 'raw',
        'filter'=>$prodis,
        'value'=>function($model,$url){
            return $model->namaProdi;
            
        },
    ],
    // 'semester',
    [
        'attribute' => 'namaAsrama',
        'label' => 'Asrama',
        'format' => 'raw',
        'filter'=>$asramas,
        'value'=>function($model,$url){
            return $model->namaAsrama;
            
        },
    ],
    'namaKamar',
    [
        'attribute' => 'namaKeperluan',
        'label' => 'Keperluan',
        'format' => 'raw',
        'filter'=>["1"=>"Pribadi","2"=>"Kampus",'3'=>'Harian'],
        'value'=>function($model,$url){

            $label = $model->namaKeperluan;
            
            return $label;
            
        },
    ],
    'alasan',
    'namaKota',
    'namaNegara',
    [
        'attribute' => 'tanggal_berangkat',
        'value' => 'tanggal_berangkat',
        'filterType' => GridView::FILTER_DATE_RANGE,
        // 'filter' => \yii\jui\DatePicker::widget(['language' => 'en', 'dateFormat' => 'yyyy-MM-dd']),
        // 'format' => 'html',
    ],
    [
        'attribute' => 'tanggal_pulang',
        'value' => 'tanggal_pulang',
        'filterType' => GridView::FILTER_DATE_RANGE,
        // 'filter' => \yii\jui\DatePicker::widget(['language' => 'en', 'dateFormat' => 'yyyy-MM-dd']),
        // 'format' => 'html',
    ],
    [
        'attribute' => 'statusIzin',
        'label' => 'Status Izin',
        'format' => 'raw',
        'filter'=>['1'=>'Belum Pulang','2'=>'Sudah Pulang'],
        'value'=>function($model,$url){
            return $model->statusIzin;
            
        },
    ],
    [
        'attribute' => 'approved',
        'label' => 'Dir. Kepengasuhan',
        'format' => 'raw',
        'filter'=>["1"=>"Disetujui","2"=>"Belum disetujui"],
        'value'=>function($model,$url){
            $label = $model->approved;
        
            return $model->approved == '1' ? '<label class="label label-success"><i class="fa fa-check"></i> Sudah Disetujui</label>' : '<label class="label label-danger"><i class="fa fa-ban"></i> Belum disetujui</label>';;
            
        },
    ],
    
    [
        'attribute' => 'prodi_approved',
        'label' => 'Prodi',
        'format' => 'raw',
        'filter'=>["1"=>"Disetujui","2"=>"Belum disetujui"],
        'value'=>function($model,$url){
            $label = $model->prodi_approved;
            if($model->durasi > 2)
                return $model->prodi_approved == '1' ? '<label class="label label-success"><i class="fa fa-check"></i> Sudah Disetujui</label>' : '<label class="label label-danger"><i class="fa fa-ban"></i> Belum disetujui</label>';
            else
                return '';
        },
    ],
    [
        'attribute' => 'baak_approved',
        'label' => 'BAAK',
        'format' => 'raw',
        'filter'=>["1"=>"Disetujui","2"=>"Belum disetujui"],
        'value'=>function($model,$url){
            $label = $model->baak_approved;
            
            if($model->durasi > 2)
                return $model->baak_approved == '1' ? '<label class="label label-success"><i class="fa fa-check"></i> Sudah Disetujui</label>' : '<label class="label label-danger"><i class="fa fa-ban"></i> Belum disetujui</label>';
            else
                return '';
            
        },
    ],
    //'created_at',
    //'updated_at',
    [
        'format' => 'raw',
        'header' => 'Actions',
        'value' => function($data){
            $html = '<div class="btn-group">
          <button data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle">
            Tindakan
            <span class="ace-icon fa fa-caret-down icon-on-right"></span>
          </button>

          <ul class="dropdown-menu dropdown-info dropdown-menu-right">';
$html .= '<li><a href="#"><i class="ace-icon fa fa-eye bigger-120"></i> View</a></li>';
if(Yii::$app->user->can('operatorCabang'))
    $html .= '<li><a href="#"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Update</a></li>';


if($data->durasi > 2 && $data->approved == '1' && $data->baak_approved == '1' && $data->prodi_approved == '1'){
    $html .= '<li><a href="#"><i class="ace-icon fa fa-print bigger-120"></i> Print</a></li>';
}
$html .= '<li><a href="javascript:void(0)" class="btn-approve" data-item="'.$data->id.'"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Approval</a></li>';

if($data->status == "1"){
$html .= '<li class="divider"></li><li><a href="javascript:void(0)" class="btn-kembali" data-kode="2" data-item="'.$data->id.'"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Kembali/Pulang</a></li>';
}

else if($data->status == '2'){
$html .= '<li class="divider"></li><li><a href="javascript:void(0)" class="btn-batal-kembali" data-kode="1" data-item="'.$data->id.'"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Batal Kembali/Pulang</a></li>';
        }

        return $html;
        }
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{delete}',
        
    ],
];
    ?>

     <div class="table-responsive">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'containerOptions' => ['style' => 'overflow: auto'], 
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'beforeHeader'=>[
            [
                'columns'=>[
                    ['content'=> $this->title, 'options'=>['colspan'=>18, 'class'=>'text-center warning']], //cuma satu kolom header
            //        ['content'=>'', 'options'=>['colspan'=>0, 'class'=>'text-center warning']], //uncomment kalau mau membuat header kolom-2
              //      ['content'=>'', 'options'=>['colspan'=>0, 'class'=>'text-center warning']],
                ], //uncomment kalau mau membuat header kolom-3
                'options'=>['class'=>'skip-export'] 
            ]
        ],
        'exportConfig' => [
              // GridView::PDF => ['label' => 'Save as PDF'],
              GridView::EXCEL => ['label' => 'Save as EXCEL'], //untuk menghidupkan button export ke Excell
              // GridView::HTML => ['label' => 'Save as HTML'], //untuk menghidupkan button export ke HTML
              GridView::CSV => ['label' => 'Save as CSV'], //untuk menghidupkan button export ke CVS
          ],
          
        'toolbar' =>  [
            '{export}', 

           '{toggleData}' //uncoment untuk menghidupkan button menampilkan semua data..
        ],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
    // set export properties
        'export' => [
            'fontAwesome' => true
        ],
        'pjax' => true,
        'pjaxSettings' =>[
            'neverTimeout'=>true,
            'options'=>[
                'id'=>'pjax_id',
            ]
        ],  
        'bordered' => true,
        'striped' => true,
        // 'condensed' => false,
        // 'responsive' => false,
        'hover' => true,
        // 'floatHeader' => true,
        // 'showPageSummary' => true, //true untuk menjumlahkan nilai di suatu kolom, kebetulan pada contoh tidak ada angka.
        'panel' => [
            'type' => GridView::TYPE_PRIMARY
        ],
    ]); ?>
</div>
    
</div>

<?php

$this->registerJs(' 

$(document).on("click",".btn-approve",function(){
    Swal.fire({
      title: \'Do you want to approve this person?\',
      
      icon: \'warning\',
      showCancelButton: true,
      confirmButtonColor: \'#3085d6\',
      cancelButtonColor: \'#d33\',
      confirmButtonText: \'Yes, approve this!\'
    }).then((result) => {
      if (result.value) {
        var id = $(this).attr("data-item");
    var obj = new Object;
    obj.id = id;
    $.ajax({

        type : "POST",
        url : "'.Url::to(['/izin-mahasiswa/approval']).'",
        data : {
            dataku : obj
        },
        success: function(data){
            var hasil = $.parseJSON(data);

            Swal.fire(
            \'Good job!\',
              hasil.msg,
              \'success\'
            );
            $.pjax.reload({container:\'#pjax_id\'});
        }
    });
      }
    })
    
});


$(document).on("click",".btn-kembali, .btn-batal-kembali",function(){
    var kode = $(this).attr("data-kode");
    var tglNow = "'.date('Y-m-d H:i:s').'";
    Swal.fire({
        title: \'Konfirmasi kedatangan saat ini?\',
        customClass: \'swal2-overflow swal-wide\',
        html: \'<input id="datepicker">\',
        icon: \'warning\',
        onOpen: function() {
          $(\'#datepicker\').datetimepicker({
            format: \'YYYY-MM-DD HH:mm:ss\',
            defaultDate : tglNow
        });
        },
        showLoaderOnConfirm : true,
        showCancelButton: true,
        confirmButtonColor: \'#3085d6\',
        cancelButtonColor: \'#d33\',
        confirmButtonText: \'Ya, konfirm data ini!\',

    }).then((result) => {
      if (result.value) {
        var id = $(this).attr("data-item");
    var obj = new Object;
    obj.id = id;
    obj.kode = kode;
    obj.tgl = $("#datepicker").val();
    $.ajax({

        type : "POST",
        url : "'.Url::to(['/izin-mahasiswa/kembali']).'",
        data : {
            dataku : obj
        },
        success: function(data){
            var hasil = $.parseJSON(data);

            Swal.fire(
            \'Good job!\',
              hasil.msg,
              \'success\'
            );
            $.pjax.reload({container:\'#pjax_id\'});
        }
    });
      }
    })
});



    ', \yii\web\View::POS_READY);

?>
