<?php

use app\models\SimakUniv;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SimakUnivSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'KKNI';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simak-univ-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create KKNI', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
 
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php 
    $gridColumns = [
    // ['class' => '\kartik\grid\CheckboxColumn'],
    [
        'class'=>'kartik\grid\SerialColumn',
        'contentOptions'=>['class'=>'kartik-sheet-style'],
        'width'=>'36px',
        'pageSummary'=>'Total',
        'pageSummaryOptions' => ['colspan' => 6],
        'header'=>'',
        'headerOptions'=>['class'=>'kartik-sheet-style']
    ],
    'header',
    'header_en',
    // 'nama:html',
    // 'nama_en:html',
    // 'created_at',
    // 'updated_at',
    // 'urutan',
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{up} {down} {view} {update}  {delete}',
        'buttons'=>[
            'up'=>function ($url, $model) {
                return Html::a('<span class="fa fa-arrow-up"></span>', '#', ['aria-label' => 'Up', 'title'=>'Up','class' => 'btn-up','data-item' => $model->id]);
            },
            'down'=>function ($url, $model) {
                return Html::a('<span class="fa fa-arrow-down"></span>', '#', ['aria-label' => 'Down', 'title'=>'Down','class' => 'btn-down','data-item' => $model->id]);
            },
            
        ],
        // 'visibleButtons' => [
        //     'up' => function ($model, $key, $index) {
        //         return Yii::$app->user->can('akpam');
        //     },
        //     'delete' => function ($model, $key, $index) {
        //         return Yii::$app->user->can('akpam');
        //     },
        //     'update' => function ($model, $key, $index) {
        //         return Yii::$app->user->can('akpam');
        //     }
        // ]
    ]
    ]
     ?>
   
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
                    ['content'=> $this->title, 'options'=>['colspan'=>15, 'class'=>'text-center warning']], //cuma satu 
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
        'id' => 'grid-krs',
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


<?php 

$this->registerJs(' 
$(document).on("click",".btn-up",function(e){   

    e.preventDefault();
    
    let obj = new Object
    obj.model_id = $(this).data("item")

    $.ajax({

        type : "POST",
        url : "/simak-univ/up",
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
});

$(document).on("click",".btn-down",function(e){
    
    e.preventDefault();
    
    let obj = new Object
    obj.model_id = $(this).data("item")

    $.ajax({

        type : "POST",
        url : "/simak-univ/down",
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
});
', \yii\web\View::POS_READY);

?>