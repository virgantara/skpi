<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RiwayatHukumanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Punishments';
$this->params['breadcrumbs'][] = ['label' => 'Riwayat Pelanggaran', 'url' => ['riwayat-pelanggaran/view','id'=>$riwayatPelanggaran->id]];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="riwayat-hukuman-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
                                
            <?=Html::a('<i class="fa fa-plus"></i> Add Punishment','#',['id'=>'btn-punishment','class'=>'btn btn-primary ']);?>
        
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
        'attribute' => 'hukuman_id',
        'label' => 'Hukuman',
        'value' => function($data){
            return (!empty($data->hukuman) ? $data->hukuman->nama : null);
        }
    ],
    'created_at',
    'updated_at',

    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{delete}'
    ],
];
    ?>

     <?= GridView::widget([
        'responsiveWrap' => false,
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
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


yii\bootstrap\Modal::begin([
'headerOptions' => ['id' => 'modalHeader'],
'id' => 'modal',
'size' => 'modal-lg',
'clientOptions' => ['backdrop' => 'static', 'keyboard' => true]
]);
?>

<form action="" id="form-hukuman">
    <div class="form-group">
        <label for="">Category*</label>
        <?= Select2::widget([
            'name' => 'kategori',
            'data' => ArrayHelper::map($list_kategori,'id','nama'),
            'options'=>['id'=>'kategori_id','placeholder'=>Yii::t('app','- Choose Category -')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>
        <input type="hidden" name="pelanggaran_id" id="pelanggaran_id" value="<?=$riwayatPelanggaran->id;?>">
    </div>
    <div class="form-group">
        <label for="">Hukuman*</label>
        
        <?= DepDrop::widget([
            'name' => 'hukuman_id',
            'options' => ['id'=>'hukuman_id'],
            'pluginOptions'=>[
                'depends'=>['kategori_id'],
                'placeholder' => '...Choose Punishment...',
                'url' => Url::to(['hukuman/list'])
            ]   
        ]) ?>
        
    </div>
    <div class="form-group">
        <button id="btn-add-hukuman" class="btn btn-info">
            <i class="fa fa-save"></i> Simpan
        </button>
    </div>
</form>

<?php
yii\bootstrap\Modal::end();
?>

<?php 

$this->registerJs(' 
$(document).on("click", "#btn-punishment", function(e){
    e.preventDefault();
    $("#modal").modal("show")
    
});


$(document).on("click", "#btn-add-hukuman", function(e){
    e.preventDefault();
    
    var obj = $("#form-hukuman").serialize()
    
    $.ajax({
        url: "/riwayat-hukuman/ajax-add",
        type : "POST",

        data: obj,
        success: function (data) {
            var hasil = $.parseJSON(data)
            if(hasil.code == 200){
                Swal.fire({
                    title: \'Yeay!\',
                    icon: \'success\',
                    text: hasil.message
                });
                
                $.pjax.reload({container: \'#pjax-container\'});
            }

            else{
                Swal.fire({
                    title: \'Oops!\',
                    icon: \'error\',
                    text: hasil.message
                })
            }
        }
    })
});
', \yii\web\View::POS_READY);

?>