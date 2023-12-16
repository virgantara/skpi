<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\helpers\MyHelper;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SimakLayananSuratSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$list_header = MyHelper::getListHeaderSurat();

$this->title = $list_header[$jenis_surat];
$this->params['breadcrumbs'][] = $this->title;

$list_tahun = \app\models\SimakTahunakademik::find()->orderBy(['tahun_id' => SORT_DESC])->limit(5)->all();
$list_status_ajuan = [
    0 => 'BELUM DISETUJUI',
    1 => 'DISETUJUI',
    2 => 'DITOLAK',
];


$query = \app\models\SimakMasterprogramstudi::find();


// if(!Yii::$app->user->isGuest && in_array(Yii::$app->user->identity->access_role, $allowed)){
//     $query->andWhere(['kode_prodi' => Yii::$app->user->identity->prodi]);
// }

$query->orderBy(['kode_jenjang_studi'=>SORT_ASC,'kode_fakultas' => SORT_ASC,'nama_prodi' => SORT_ASC]);
$list_prodi = $query->all();
$list_prodi = ArrayHelper::map($list_prodi,'kode_prodi','nama_prodi');

$list_kampus = ArrayHelper::map(\app\models\SimakKampus::find()->all(),'kode_kampus','nama_kampus');
?>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h3><?= Html::encode($this->title) ?></h3>
            </div>
<div class="x_content">
    <?php 
    if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
        $params = ['class' => 'btn btn-success'];

        if($mhs->status_aktivitas != 'A'){
            $params = ['class' => 'btn btn-danger','disabled' => 'disabled','title' => 'Mohon maaf, Anda tidak bisa mengajukan surat keterangan aktif karena status Anda belum Aktif'];
        }    
     ?>
    <p>
        <?= Html::a(Yii::t('app','Buat Pengajuan'), ['create','jenis_surat' => $jenis_surat], $params) ?>
    </p>
    <?php
}
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
            // 'id',
            'nim',
            [
                'attribute' => 'namaMahasiswa',
                'value' => function($data){
                    return !empty($data->nim0) ? $data->nim0->nama_mahasiswa : null;
                }
            ],
            [
                'attribute' => 'namaProdi',
                'filter' => $list_prodi,
                'value' => function($data){
                    return $data->nim0->kodeProdi->nama_prodi;
                }
            ],
            [
                'attribute' => 'namaKampus',
                'filter' => $list_kampus,
                'value' => function($data){
                    return $data->nim0->kampus0->nama_kampus;
                }
            ],
            [
                'attribute' => 'tahun_id',
                'filter' => ArrayHelper::map($list_tahun,'id','nama_tahun'),
                'value' => function($data){
                    return $data->tahun->nama_tahun;
                }
            ],
            [
                'label' => 'Semester',
                // 'filter' => ArrayHelper::map($list_tahun,'id','nama_tahun'),
                'value' => function($data){
                    return $data->nim0->semester;
                }
            ],
            'keperluan:html',
            [
                'attribute' => 'bahasa',
                'filter' => ['id'=>'Indonesia','en' => 'English'],
                
            ],
            'tanggal_diajukan',
            [
                'label' => 'Keterangan',
                'format' => 'raw',
                'value' => function($data){
                    return $data->tanggal_disetujui.'<br>'.$data->nomor_surat;
                }
            ],
            //'nama_pejabat',
            [
                'attribute' => 'status_ajuan',
                'filter' => $list_status_ajuan,
                'value' => function($data) use ($list_status_ajuan){
                    return $list_status_ajuan[$data->status_ajuan];
                }
            ],
            //'updated_at',
            //'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
            
                    'view' => function ($url, $model){
                        return Html::a('<i class="glyphicon glyphicon-eye-open"></i> View', $url, [
                                'title' => Yii::t('app', 'View'),
                                'data-pjax' =>0,
                                'class' => 'btn btn-success '
                        ]);
                    },
                    
                ],
                'visibleButtons' => [
                    'view' => function($data){
                        return Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('operatorUnit');
                    },

                    
                ]
                // 'visible' => Yii::$app->user->can('sekretearis'),
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

