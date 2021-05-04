<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\assets\EventAsset;

EventAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ucwords($daily).' Events';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body ">

               
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
                [
                'attribute' => 'kegiatan_id',
                'value' => function($data){

                    return $data->kegiatan->nama_kegiatan;
                }
            ],
            'nama',
            'venue',
            [
                'attribute' => 'tanggal_mulai',
                'value' => function($data){
                    return date('l F j, Y g:i a',strtotime($data->tanggal_mulai));
                }
            ],
            [
                'attribute' => 'tanggal_selesai',
                'value' => function($data){
                    return date('l F j, Y g:i a',strtotime($data->tanggal_selesai));
                }
            ],
            'penyelenggara',
            'tingkat',
            [
                'attribute' => 'status',
                'filter' => \app\helpers\MyHelper::getStatusEvent(),
                'format' => 'raw',
                'value' => function($data){
                    $list = \app\helpers\MyHelper::getStatusEvent();
                    $colors = \app\helpers\MyHelper::getStatusEventColor();
                    return '<span class="label label-'.$colors[$data->status].'">'.$list[$data->status].'</span>';
                }
            ],
            [
                'header'=>'Ubah Status',
                'value'=> function($data)
                {
                    // $kode = $data->status != '1' ? '1' : '0';
                    $label = '<i class="glyphicon glyphicon-off"></i>';
                    // $alert = $data->status != '1' ? 'success' : 'danger';
                    return  Html::a(Yii::t('app', $label), 'javascript:void(0)', ['class' => ' popupModal','data-item'=>$data->id]); 
                        
                },
                 'format' => 'raw'
            ],
];?>                
<?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $gridColumns,
                    'containerOptions' => ['style' => 'overflow: auto'], 
                    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
                    'containerOptions' => ['style'=>'overflow: auto'], 
                    'beforeHeader'=>[
                        [
                            'columns'=>[
                                ['content'=> $this->title, 'options'=>['colspan'=>14, 'class'=>'text-center warning']], //cuma satu 
                            ], 
                            'options'=>['class'=>'skip-export'] 
                        ]
                    ],
                    'exportConfig' => [
                          GridView::PDF => ['label' => 'Save as PDF'],
                          GridView::EXCEL => ['label' => 'Save as EXCEL'], //untuk menghidupkan button export ke Excell
                          GridView::HTML => ['label' => 'Save as HTML'], //untuk menghidupkan button export ke HTML
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
                            'id'=>'pjax-container',
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
    </div>

</div>
<?php
        yii\bootstrap\Modal::begin(['id' =>'modal']);

    ?>

    <?php

        yii\bootstrap\Modal::end();
    ?>

<?php
$this->registerJs('

function changeStatus(id, status){
    var obj = new Object
    obj.id = id
    obj.status = status
    $.ajax({
        type: \'POST\',
        url: "'.Url::to(['events/ajax-start']).'",
        data: {
            dataPost : obj
        },
        async: true,
        error : function(e){
            Swal.fire({
                  title: \'Oops!\',
                  icon: \'error\',
                  text: e.responseText
                })
        },
        success: function (data) {
            var data = $.parseJSON(data)
            if(data.code == 200){
                Swal.fire({
                    title: \'Yeay!\',
                    icon: \'success\',
                    timer: 1000,
                    timerProgressBar: true,
                    text: data.message,
                    
                  })
                  .then((result)=>{
                    $.pjax.reload({container: "#pjax-container"})
                  })  
            }

            else{
                Swal.fire({
                  title: \'Oops!\',
                  icon: \'error\',
                  text: data.message
                })
            }
            
        }
    })
}

    $(document).on("click",".popupModal",function(e) {
        var selectorId = $(this).data("item");
        e.preventDefault();
        bootbox.dialog({
            message: "<span class=\'bigger-110\'>Change this event status</span>",
            buttons:
            {
                "info" :
                 {
                    "label" : "<i class=\'ace-icon fa fa-check\'></i> Start!",
                    "className" : "btn-sm btn-info",
                    "callback": function() {
                        changeStatus(selectorId, 1)
                    }
                },
                "finished" :
                {
                    "label" : "Finish",
                    "className" : "btn-sm btn-success",
                    "callback": function() {
                        changeStatus(selectorId, 2)
                    }
                }, 
                "postponed" :
                {
                    "label" : "Postpone",
                    "className" : "btn-sm btn-purple",
                    "callback": function() {
                        changeStatus(selectorId, 3)
                    }
                }, 
                "cancelled" :
                {
                    "label" : "Cancel Event",
                    "className" : "btn-sm btn-inverse",
                    "callback": function() {
                        changeStatus(selectorId, 4)
                    }
                }, 
            }
        });
        // Swal.fire({
        //     title: \'Konfirmasi\',
        //     text: "Lanjutkan proses ini?",
        //     icon: \'info\',
        //     showCancelButton: true,
        //     confirmButtonColor: \'#3085d6\',
        //     cancelButtonColor: \'#d33\',
        //     confirmButtonText: \'Ya\',
        //     cancelButtonText: \'Tidak\'
        // })
        // .then((result) => {
        //     if (result.value) {
        //         var obj = new Object;
        //         obj.id = $(this).data("item");
        //         obj.kode = $(this).data("kode");
        //         $(this).ajaxDataPost("'.Url::to(['simak-kegiatan/ajax-aktivasi']).'",obj,function(err,hasil){
        //           if(hasil.code == 200){
                    
        //               Swal.fire({
        //                 title: \'Yeay!\',
        //                 icon: \'success\',
        //                 timer: 1000,
        //                 timerProgressBar: true,
        //                 text: hasil.message,
                        
        //               })
        //               .then((result)=>{
        //                 $.pjax.reload({container: "#pjax-container"})
        //               })  
                    
        //           }

        //           else{
        //             Swal.fire({
        //               title: \'Oops!\',
        //               icon: \'error\',
        //               text: hasil.message
        //             })
        //           }
        //         });
        //     }
        // })
        
   });



');

?>