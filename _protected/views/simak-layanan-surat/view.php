<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\MyHelper;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\SimakLayananSurat */
$list_header = MyHelper::getListHeaderSurat();

$this->title = $list_header[$model->jenis_surat];
$this->params['breadcrumbs'][] = ['label' => 'Layanan Surat', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$list_status_ajuan = [
    0 => 'BELUM DISETUJUI',
    1 => 'DISETUJUI',
    2 => 'DITOLAK',
];
?>
<div class="block-header">
    <h2><?= Html::encode($this->title) ?></h2>
</div>
<?php
                if (Yii::$app->user->can('operatorUnit') || Yii::$app->user->can('operatorCabang')) {
                    echo Html::a('<i class="fa fa-edit"></i> Approval', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                }

                echo ' ';

                if ($model->status_ajuan == '1') {
                    echo Html::a('<i class="fa fa-download"></i> Download', ['download', 'id' => $model->id], ['class' => 'btn btn-success', 'target' => '_blank']);
                }
                ?>
<div class="row">
    <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
        <div class="panel">
            <div class="panel-heading">
                
            </div>

            <div class="panel-body ">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'nim',
                        [
                            'attribute' => 'namaMahasiswa',
                            'value' => function($data){
                                return !empty($data->nim0) ? $data->nim0->nama_mahasiswa : null;
                            }
                        ],
                        [
                            'attribute' => 'namaProdi',

                            'value' => function($data){
                                return $data->nim0->kodeProdi->nama_prodi;
                            }
                        ],
                        [
                            'label' => 'Semester',
                            // 'filter' => ArrayHelper::map($list_tahun,'id','nama_tahun'),
                            'value' => function($data){
                                return $data->nim0->semester;
                            }
                        ],
                        'tahun.nama_tahun',
                        'keperluan:ntext',
                        'bahasa',
                        'tanggal_diajukan',
                        'tanggal_disetujui',
                        'nomor_surat',
                        // 'nama_pejabat',
                        [
                            'attribute' => 'status_ajuan',
                            'filter' => $list_status_ajuan,
                            'value' => function ($data) use ($list_status_ajuan) {
                                return $list_status_ajuan[$data->status_ajuan];
                            }
                        ],

                    ],
                ]) ?>

            </div>
        </div>

    </div>
    <?php 
    if($model->jenis_surat == 3){
     ?>
    
    <div class="col-md-6 col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <?php 
                if($subakpam < 200){
                ?>
                <div class="alert alert-danger">
                    Nilai AKPAM anda belum mencukupi standart minimum kelulusan, silahkan melengkapi kekurangan nilai tersebut.
                </div>
                <?php 
                } 
                else{
                ?>
                <div class="alert alert-success">
                    Pengajuan Surat Keterangan AKPAM Anda telah diterima dan akan segera diproses
                </div>
                <?php 
                }
                 ?>
                
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>Jenis Kegiatan</td>
                            <td align="center">Nilai</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                        foreach($listJenisKegiatan as $jk)
                        {
                         ?>
                        <tr>
                            <td><?=$jk->nama_jenis_kegiatan?></td>
                            <td align="center"><?=round($list_ipks[$jk->id],2)?></td>
                        </tr>
                        <?php 
                        }
                         ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><b>Total</b></td>
                            <td align="center"><?=round($subakpam,2)?></td>
                        </tr>
                        <tr>
                            <td><b>IPKs</b></td>
                            <td align="center"><?=round($ipks,2)?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
<?php } ?>
</div>



<div class="row">
<?php 
 if(!empty($dataProvider)){

 ?>
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title">
                <h3>Daftar berkas yang sudah diupload</h3>
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

            [
                'attribute' => 'syarat_id',
                'value' => function($data){
                    return $data->syarat->nama;
                }
            ],
            
            [
                'attribute' => 'file_path',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a('<label class="btn btn-success"><i class="fa fa-download"></i> Download</label>',['simak-syarat-bebas-asrama-mahasiswa/download','id' => $data->id],['data-pjax' => 0,'target'=>'_blank']);
                }
            ],
            'updated_at',
            //'created_at',
    [
        'template' => '{delete}',
        'class' => 'yii\grid\ActionColumn',
        'buttons' => [
            'delete' => function ($url, $model) {
                return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['/simak-syarat-bebas-asrama-mahasiswa/delete', 'id' => $model->id], [
                    'title' => Yii::t('app', 'Hapus data'),
                    'data-pjax' => 0,
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
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
        // 'filterModel' => $searchModel,
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
    <?php } ?>

    <?php 
 if(!empty($dataProviderBerkas)){

 ?>
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading">
                <h3>Surat Keterangan AKPAM dan Bebas Sanksi</h3>
            </div>
            <div class="panel-body">
                
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
                'attribute' => 'keperluan',
                // 'value' => function($data){
                //     return $data->syarat->nama;
                // }
            ],
            
            [
                'attribute' => 'file_path',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a('<label class="btn btn-success"><i class="fa fa-download"></i> Download</label>',['simak-layanan-surat/download','id' => $data->id],['data-pjax' => 0,'target'=>'_blank']);
                }
            ],
            // 'updated_at',
            //'created_at',
    // [
    //     'template' => '{delete}',
    //     'class' => 'yii\grid\ActionColumn',
    //     'buttons' => [
    //         'delete' => function ($url, $model) {
    //             return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['/simak-syarat-bebas-asrama-mahasiswa/delete', 'id' => $model->id], [
    //                 'title' => Yii::t('app', 'Hapus data'),
    //                 'data-pjax' => 0,
    //                 'data' => [
    //                     'confirm' => 'Are you sure you want to delete this item?',
    //                     'method' => 'post',
    //                 ],
    //             ]);
    //         },
    //       ],
          
    // ]
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
        'dataProvider' => $dataProviderBerkas,
        // 'filterModel' => $searchModel,
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
    <?php } ?>
</div>