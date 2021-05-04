<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IzinHarianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Izin Harian ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="izin-harian-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'nim',
            'namaMahasiswa',
            [
                'attribute' => 'namaProdi',
                'label' => 'Prodi',
                'format' => 'raw',
                'filter'=>$prodis,
                'value'=>function($model,$url){
                    return $model->namaProdi;
                    
                },
            ],
            [
                'attribute' => 'namaAsrama',
                'label' => 'Asrama',
                'format' => 'raw',
                'filter'=>$asramas,
                'value'=>function($model,$url){
                    return $model->namaAsrama;
                    
                },
            ],
            [
                'attribute' => 'namaKamar',
                'label' => 'Kamar',
                'format' => 'raw',
                'value'=>function($model,$url){
                    return $model->namaKamar;
                    
                },
            ],
            'waktu_keluar',
            'waktu_masuk',
            [
                'attribute' => 'status_izin',
                'filter' => ['2'=>'Keluar','1'=>'Masuk'],
                'value' => function($data){
                    return $data->status_izin == 2 ? 'Keluar' : 'Masuk';
                }
            ],
            // 'created_at',
            //'updated_at',

            // ['class' => 'yii\grid\ActionColumn'],
        ]; ?>

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
