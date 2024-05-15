<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SimakKegiatanMahasiswaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Prestasi Mahasiswa';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body ">

                <div class="alert alert-info">
                    Data Prestasi hanya diambil dari kegiatan mahasiswa (AKPAM) dengan Kegiatan/Prestasi berupa juara
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="klaim-selected btn btn-primary"><i class="fa fa-check"></i> Claim Selected</button>
                        <div class="help-block"></div>
                    </div>  
                </div>
                <?php
                $gridColumns = [
                ['class' => '\kartik\grid\CheckboxColumn'],
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
                'attribute' => 'namaMahasiswa',
                'label' => 'Mahasiswa',
                'format' => 'raw',
                'value'=>function($model,$url){
                    return (isset($model->nim0->nama_mahasiswa) ? $model->nim0->nama_mahasiswa : '');
                },
            ],
            [
                'attribute' => 'namaKampus',
                'label' => 'Kelas',
                'format' => 'raw',
                'value'=>function($model,$url){
                    return !empty($model->nim0->kampus0) ? $model->nim0->kampus0->nama_kampus : '-';
                    
                },
            ],
            [
                'attribute' => 'namaProdi',
                'label' => 'Prodi',
                'format' => 'raw',
                'value'=>function($model,$url){
                    return !empty($model->nim0->kodeProdi) ? $model->nim0->kodeProdi->nama_prodi : '-';
                    
                },
            ],
            'tema',
            [
                'attribute' => 'id_jenis_kegiatan',
                'label' => 'Jenis Kegiatan',
                'format' => 'raw',
                'value'=>function($model,$url){
                    return !empty($model->jenisKegiatan) ? $model->jenisKegiatan->nama_jenis_kegiatan : '-';
                    
                },
            ],
            [
                'attribute' => 'id_kegiatan',
                'label' => 'Kegiatan',
                'format' => 'raw',
                
                'value'=>function($model,$url){
                    return !empty($model->kegiatan) ? $model->kegiatan->nama_kegiatan : '-';
                    
                },
            ],
           
            // 'keterangan:ntext',
            
            // 'instansi',
            // 'bagian',
            // 'bidang',
            // 'nama_kegiatan_mahasiswa',
            'tahun_akademik',
                // ['class' => 'yii\grid\ActionColumn']
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
                    'id' => 'grid-klaim',
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

$this->registerJs(' 
$(".klaim-selected").click(function(e){
    var keys = $(\'#grid-klaim\').yiiGridView(\'getSelectedRows\');
    e.preventDefault();
    
    Swal.fire({
      title: \'Klaim Data Prestasi!\',
      html: "<b>Klaim data ini?</b>",
      icon: \'warning\',
      showCancelButton: true,
      confirmButtonColor: \'#3085d6\',
      cancelButtonColor: \'#d33\',
      confirmButtonText: \'Ya, Klaim Terpilih!\'
    }).then((result) => {
        if(result.isConfirmed){
            var obj = new Object;
            obj.keys = keys;
            $.ajax({

                type : "POST",
                url : "/prestasi/klaim-multiple",
                data : {
                    dataPost : obj
                },
               
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
                    

                    if(data.code == 200){
                        Swal.fire({
                            title: \'Yeay!\',
                            icon: \'success\',
                            text: data.message
                        });

                        $.pjax.reload({container: \'#pjax-container\', async: true});
                    }
                    
                    else{
                        Swal.fire({
                            title: \'Oops!\',
                            icon: \'error\',
                            text: data.message
                        });

                    }
                }
            })
        }
    });
});
', \yii\web\View::POS_READY);

?>