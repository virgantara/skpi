<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\date\DatePicker;
use dosamigos\ckeditor\CKEditor;

use kartik\select2\Select2;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\SimakMagang */

$this->title = 'Magang '.(!empty($model->nim0) ? $model->nim0->nama_mahasiswa : null);
$this->params['breadcrumbs'][] = ['label' => 'Simak Magangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$nama_dosen = (!empty($model->pembimbing) ? $model->pembimbing->display_name : '');
$list_status_magang = ArrayHelper::map(\app\models\SimakPilihan::find()->where(['kode' => 'stmg'])->all(),'id','label');
?>

<div class="row">
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-heading">
                <h1><?=$this->title?></h1>
            </div>

            <div class="panel-body">
        
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
       
            [
                'attribute' => 'nim',
                'contentOptions' => ['width' => '80%'],
                'label' => 'Mahasiswa',
                'value' => function($data){
                    return (!empty($data->nim0) ? $data->nim0->nama_mahasiswa : null);
                }
            ],
            'nama_instansi',
            'alamat_instansi',
            'telp_instansi',
            'email_instansi:email',
            'nama_pembina_instansi',
            'jabatan_pembina_instansi',
           
        ],
    ]) ?>

            </div>
        </div>

    </div>
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-heading">
               <h1>&nbsp;</h1>
            </div>

            <div class="panel-body">
        
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
       
           
            
            [
                'attribute' => 'kota_instansi',
                // 'contentOptions' => ['width' => '80%'],
                'value' => function($data){
                    return (!empty($data->kotaInstansi) ? $data->kotaInstansi->name : null);
                }
            ],
            [
                'attribute' => 'is_dalam_negeri',
                'value' => function($data){
                    return ($data->is_dalam_negeri == '1' ? "Dalam Negeri" : "Luar Negeri");
                }
            ],
            'tanggal_mulai_magang:date',
            'tanggal_selesai_magang:date',
            'status',
            'keterangan:html',
            [
                'attribute' => 'file_laporan',
                'format' => 'raw',
                'value' => function($data){
                    $html = '';
                    if(isset($data->file_laporan))
                        $html .= Html::a('<i class="fa fa-download"></i> Unduh File',['download','id' => $data->id],['class' => 'btn btn-primary','target'=>'_blank','data-pjax'=>0,'style'=>'margin-bottom:3px']);
                    else{
                        $html .= '<span style="color:red">- Belum unggah laporan</span>';
                    }
                    

                    return $html;
                }
            ],
        ],
    ]) ?>

            </div>
        </div>

    </div>
    
</div>


<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Catatan Magang</h3>
            </div>
            <div class="x_content">

               
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
                        'tanggal',
                        'rincian_kegiatan:html',
                        // 'evaluasi:html',
                        // 'tindak_lanjut:html',
                        'catatan_pembimbing:html',
                        
                        // 'updated_at',
                        // 'created_at',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if($action == 'view')
                        {
                          return Url::to(['simak-magang-catatan/view','id'=>$model->id]); 
                        }
                        
                       
                        else {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }  
                      },
                    'buttons' => [
            
                        'view' => function ($url, $model){
                            return Html::a('<i class="fa fa-list"></i> Lihat Detil', $url, [
                                    'title' => Yii::t('app', 'View Catatan '),
                                    'data-pjax' =>0,
                                    'class' => 'btn btn-success btn-view-catatan'
                            ]);
                        },
                        'update' => function ($url, $model){
                            return Html::a('<i class="fa fa-edit"></i> Edit', $url, [
                                    'title' => Yii::t('app', 'Edit data magang '),
                                    'data-pjax' =>0,
                                    'class' => 'btn btn-warning'
                            ]);
                        },
                        'delete' => function ($url, $model){
                            return Html::a('<i class="fa fa-trash"></i> Delete', $url, [
                                    'title' => Yii::t('app', 'Hapus data magang '),
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                    'class' => 'btn btn-danger'
                            ]);
                        },
                        
                        
                    ],
                ]
            ];?>    
            <?= GridView::widget([
                    'pager' => [
                        'options'=>['class'=>'pagination'],  
                        'activePageCssClass' => 'active paginate_button page-item',
                        'disabledPageCssClass' => 'disabled paginate_button',
                        'prevPageLabel' => 'Previous',   
                        'nextPageLabel' => 'Next',  
                        'firstPageLabel'=>'First',  
                        'lastPageLabel'=>'Last',    
                        'nextPageCssClass'=>'paginate_button next page-item',   
                        'prevPageCssClass'=>'paginate_button previous page-item',  
                        'firstPageCssClass'=>'first paginate_button page-item',    
                        'lastPageCssClass'=>'last paginate_button page-item',   
                        'maxButtonCount'=>10,    
                        'linkOptions' => [
                            'class' => 'page-link'
                        ]
                    ],      
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'responsiveWrap' => false,
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
                    'id' => 'my-grid',
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


yii\bootstrap\Modal::begin([
'headerOptions' => ['id' => 'modalHeader'],
'id' => 'modal-catatan-harian',
'size' => 'modal-lg',
'clientOptions' => ['backdrop' => 'static', 'keyboard' => true]
]);
?>
<div id="modalCatatanHarianContent"></div>
<?php
yii\bootstrap\Modal::end();
?>


<?php \yii\bootstrap\Modal::begin([
    'id' => 'activity-modal',
    'header' => '<h4 class="modal-title">Form Rencana Kegaitan</h4>',
    'size' => \yii\bootstrap\Modal::SIZE_LARGE,
    // 'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>


<form action="" id="form-rencana-kegiatan">
    <?=Html::hiddenInput('magang_id',$model->id)?>
    <div class="form-group">
        <label for="">Tanggal Kegiatan *</label>
        <?= DatePicker::widget([
            'name' => 'tanggal',
            'options' => ['placeholder' => 'Pilih Tanggal Kegiatan ...'],
            'convertFormat' => true,
            'pluginOptions' => [
                'todayHighlight' => true,
                'todayBtn' => true,
                'format' => 'php:Y-m-d',
                'autoclose' => true,
            ]
        ]) ?> 

    </div>
    <div class="row">
        <div class="col-lg-6">
            
            <div class="form-group">
                <label for="">Rincian Kegiatan *</label>
                <?= CKEditor::widget([
                    'name' => 'rincian_kegiatan',
                    'options' => ['rows' => 6],
                    'preset' => 'advance',
                    'clientOptions' => [
                        'enterMode' => 2,
                        'forceEnterMode' => false,
                        'shiftEnterMode' => 1
                    ]
                ]) ?>
            </div>
            <div class="form-group">
                <label for="">Evaluasi *</label>
                <?= CKEditor::widget([
                    'name' => 'evaluasi',
                    'options' => ['rows' => 6],
                    'preset' => 'advance',
                    'clientOptions' => [
                        'enterMode' => 2,
                        'forceEnterMode' => false,
                        'shiftEnterMode' => 1
                    ]
                ]) ?>
            </div>
        </div>
        <div class="col-lg-6">
            
            <div class="form-group">
                <label for="">Tindak Lanjut *</label>
                <?= CKEditor::widget([
                    'name' => 'tindak_lanjut',
                    'options' => ['rows' => 6],
                    'preset' => 'advance',
                    'clientOptions' => [
                        'enterMode' => 2,
                        'forceEnterMode' => false,
                        'shiftEnterMode' => 1
                    ]
                ]) ?>
            </div>
        </div>
    </div>
    
    
    
    <div class="form-group">
        <?=Html::button('Submit',['class' => 'btn btn-success btn-block btn-lg','id' => 'btn-submit'])?>
    </div>
</form>

<?php \yii\bootstrap\Modal::end(); ?>


<?php 

$this->registerJs(' 

$(document).on("click",".btn-view-catatan",function(e){
    e.preventDefault()
    $(\'#modal-catatan-harian\').modal()
    .find("#modalCatatanHarianContent")
    .load($(this).attr("href"))
})

$(document).on("click","#btn-create",function(e){
    e.preventDefault()
    $(\'#activity-modal\').modal();
})

$(document).on("click","#btn-submit",function(e){
    e.preventDefault()
    var obj = $("#form-rencana-kegiatan").serialize()

    $.ajax({
        type: "POST",
        url: "/simak-magang-catatan/ajax-insert",
        data: obj,
        async: true,
        error : function(e){
            console.log(e.responseText)
        },
        success: function (data) {
            var res = $.parseJSON(data)
            if(res.code == 200){
                Swal.fire({
                    title: \'Yeay...\', 
                    html: res.message, 
                    type: \'success\',
                    timer: 500
                })
                $.pjax.reload({container: "#pjax-container"})
                $("#rencana_kegiatan").val("")
                // $("#activity-modal").modal("hide");
            }

            else{
                Swal.fire(\'Oops...\', res.message, \'error\')
            }

        }
    })
})


$(document).on("click","#btn-update-magang",function(e){
    e.preventDefault()
    var obj = $("#form-update-magang").serialize()

    $.ajax({
        type: "POST",
        url: "/simak-magang/ajax-update",
        data: obj,
        async: true,
        error : function(e){
            console.log(e.responseText)
        },
        success: function (data) {
            var res = $.parseJSON(data)
            if(res.code == 200){
                Swal.fire({
                    title: \'Yeay...\', 
                    html: res.message, 
                    type: \'success\',
                    timer: 500
                })
            }

            else{
                Swal.fire(\'Oops...\', res.message, \'error\')
            }

        }
    })
})


', \yii\web\View::POS_READY);

?>