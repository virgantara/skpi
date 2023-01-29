<?php

use app\models\SimakMagang;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SimakMagangSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Magang MBKM';
$this->params['breadcrumbs'][] = $this->title;

$list_status_magang = ArrayHelper::map(\app\models\SimakPilihan::find()->where(['kode' => 'stmg'])->all(),'id','label');
$list_jenis_magang = ArrayHelper::map(\app\models\SimakPilihan::find()->where(['kode' => 'mg'])->all(),'id','label');

$list_prodi = \app\models\SimakMasterprogramstudi::find()->orderBy(['kode_jenjang_studi'=>SORT_ASC,'kode_fakultas' => SORT_ASC,'nama_prodi' => SORT_ASC])->all();

$list_lokasi_magang = ["1" => "Dalam Negeri","2" => "Luar Negeri"];
?>
<div class="simak-magang-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                'attribute' => 'nim',
                // 'contentOptions' => ['width' => '80%'],
                'label' => 'Mahasiswa',
                'value' => function($data){
                    return (!empty($data->nim0) ? $data->nim0->nama_mahasiswa : null);
                }
            ],
            'nim',
            [
                'attribute' => 'kode_prodi',
                'filter' => ArrayHelper::map($list_prodi,'kode_prodi',function($data){return $data->singkatan.' - '.$data->nama_prodi;}),
                'label' => 'Prodi',
                'value' => function($data){
                    return (!empty($data->nim0) && !empty($data->nim0->kodeProdi) ? $data->nim0->kodeProdi->nama_prodi : null);
                }
            ],
            [
                'attribute' => 'jenis_magang_id',
                'filter' => $list_jenis_magang,
                'value' => function($data){
                    return (!empty($data->jenisMagang) ? $data->jenisMagang->label : null);
                }
            ],
            'nama_instansi',
            
            [
                'attribute' => 'kota_instansi',
                // 'contentOptions' => ['width' => '80%'],
                'value' => function($data){
                    return (!empty($data->kotaInstansi) ? $data->kotaInstansi->name : null);
                }
            ],
            [
                'attribute' => 'nama_dosen',
                'label' => 'Pembimbing Magang',
                // 'contentOptions' => ['width' => '80%'],
                'value' => function($data){
                    return (!empty($data->pembimbing) ? $data->pembimbing->display_name : null);
                }
            ],
            [
                'attribute' => 'is_dalam_negeri',
                'filter' => $list_lokasi_magang,
                'value' => function($data){
                    return ($data->is_dalam_negeri == '1' ? "Dalam Negeri" : "Luar Negeri");
                }
            ],

            'tanggal_mulai_magang:date',
            'tanggal_selesai_magang:date',
            [
                'attribute' => 'status_magang_id',
                'filter' => $list_status_magang,
                'value' => function($data){
                    return (!empty($data->statusMagang) ? $data->statusMagang->label : null);
                }
            ],
            [
                'header' => 'Jml Catatan',
                'value' => function($data){
                    return $data->countCatatan;
                }
            ],
            [
                'attribute' => 'file_laporan',
                'format' => 'raw',
                'value' => function($data){
                    $html = '';
                    if(!empty($data->file_laporan))
                        $html .= Html::a('<i class="fa fa-download"></i> Unduh File',['download','id' => $data->id],['class' => 'btn btn-primary','target'=>'_blank','data-pjax'=>0,'style'=>'margin-bottom:3px']);
                    else{
                        $html .= '<span style="color:red">- Belum unggah laporan</span>';
                    }
                    

                    return $html;
                }
            ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view} ',
        'buttons' => [
            
            'view' => function ($url, $model){
                return Html::a('<i class="fa fa-list"></i> Detil', $url, [
                        'title' => Yii::t('app', 'Add Catatan '),
                        'data-pjax' =>0,
                        'class' => 'btn btn-success'
                ]);
            },
            
        ],
        'visibleButtons' => [
                    
            'update' => function($data){
                return Yii::$app->user->can('sekretearis') || Yii::$app->user->can('Mahasiswa');
            },

            'delete' => function($data){
                return Yii::$app->user->can('sekretearis') || Yii::$app->user->can('Mahasiswa');
            }
        ]
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
