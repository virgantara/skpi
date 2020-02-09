<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RiwayatPelanggaranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Riwayat Pelanggaran';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="riwayat-pelanggaran-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Pelanggaran', ['cari-mahasiswa'], ['class' => 'btn btn-success']) ?>
    </p>

    
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
        'attribute' => 'tanggal',
        'value' => 'tanggal',
        'filterType' => GridView::FILTER_DATE_RANGE,
        // 'filter' => \yii\jui\DatePicker::widget(['language' => 'en', 'dateFormat' => 'yyyy-MM-dd']),
        // 'format' => 'html',
    ],
    'nim',
    'namaMahasiswa',
   [
        'attribute' => 'namaFakultas',
        'label' => 'Fakultas',
        'format' => 'raw',
        'filter'=>$fakultas,
        'value'=>function($model,$url){
            return $model->namaFakultas;
            
        },
    ],
   [
        'attribute' => 'namaProdi',
        'label' => 'Prodi',
        'format' => 'raw',
        'filter'=>$prodis,
        'value'=>function($model,$url){
            return $model->namaProdi;
            
        },
    ],
    'semester',
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
    'namaPelanggaran',
    [
        'attribute' => 'namaKategori',
        'label' => 'Kategori',
        'format' => 'raw',
        'filter'=>["RINGAN"=>"RINGAN","SEDANG"=>"SEDANG","BERAT"=>"BERAT"],
        'value'=>function($model,$url){

            $st = '';
            $label = '';

            $label = $model->namaKategori;
            if($model->namaKategori == 'RINGAN')
                $st = 'success';
            else if($model->namaKategori == 'SEDANG')
                $st = 'warning';
            else if($model->namaKategori == 'BERAT')
                $st = 'danger';
            
            
            
            return '<button type="button" class="btn btn-'.$st.' btn-sm" >
                       <span>'.$label.'</span>
                    </button>';
            
        },
    ],
    
    'pelapor',
    [
        'attribute' => 'statusAktif',
        'label' => 'Status Aktif',
        'format' => 'raw',
        'filter'=>$status_aktif,
        'value'=>function($model,$url){
            return $model->statusAktif;
            
        },
    ],
    

    //'created_at',
    //'updated_at',

    ['class' => 'yii\grid\ActionColumn'],
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
        'summary'=>'',
        'containerOptions' => ['style'=>'overflow: auto'], 
        'beforeHeader'=>[
            [
                'columns'=>[
                    ['content'=> $this->title, 'options'=>['colspan'=>14, 'class'=>'text-center warning']], //cuma satu kolom header
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
