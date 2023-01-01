<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrganisasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Organisasi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organisasi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Organisasi', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fa fa-refresh"></i> Sync to AKPAM', ['sync'], ['class' => 'btn btn-info']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


     <?php $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            'nama',
            'tingkat',
            'instansi',
            [
                // 'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'file_sk',
                 'format' => 'raw',
                'value' => function($data){
                    return (!empty($data->file_sk) ? Html::a('<i class="fa fa-download"></i> Unduh',$data->file_sk, ['class'=>'btn btn-primary','data-pjax' => 0,'target' => '_blank']) : null);
                },
                
            ],
            'updated_at',
            ['class' => 'yii\grid\ActionColumn'],
        ]; ?>
    <?= GridView::widget([
        'responsiveWrap' => false,
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
