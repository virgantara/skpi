<?php

use app\models\SimakKampusKoordinator;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\SimakKampusKoordinatorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Koordinator';
$this->params['breadcrumbs'][] = $this->title;

$list_kampus = ArrayHelper::map(\app\models\SimakKampus::find()->all(),'id','nama_kampus');
?>
<div class="simak-kampus-koordinator-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Koordinator', ['create'], ['class' => 'btn btn-success']) ?>
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
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'kampus_id',
            'filter' => $list_kampus,
            'refreshGrid' => true,
            'editableOptions' => [
                'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                'data' => $list_kampus,
                'asPopover' => false,
            ],
            'value' => function($data){
                return (!empty($data->kampus) ? $data->kampus->nama_kampus : '-');
            }

          
        ],

        // [
        //     'attribute' => 'kampus_id',
        //     'filter' => $list_kampus,
        //     'value' => function($data){
        //         return (!empty($data->kampus) ? $data->kampus->nama_kampus : '-');
        //     }
        // ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'nama_cabang',
            // 'refreshGrid' => true,
             'editableOptions' => [
                'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                'asPopover' => false,
            ],
            
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'niy',
            // 'refreshGrid' => true,
             'editableOptions' => [
                'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                'asPopover' => false,
            ],
            
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'nama_koordinator',
            // 'refreshGrid' => true,
             'editableOptions' => [
                'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                'asPopover' => false,
            ],
          
        ],
        [
            'attribute' => 'ttd_path',
            'format' => 'raw',
            'value' => function($data){
                return (!empty($data->ttd_path) ? Html::img($data->ttd_path,['width' => '250px','loading' => 'lazy']) : '');
            }
        ],
    ['class' => 'yii\grid\ActionColumn']
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
