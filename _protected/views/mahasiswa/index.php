<?php

use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MahasiswaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Mahasiswa';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="simak-mastermahasiswa-index">

    <h1><?= Html::encode($this->title) ?></h1>

 <?php
        yii\bootstrap\Modal::begin(['id' =>'modal','size'=>'modal-lg',]);
        echo '<div class="text-center">';
        echo '<img id="img">';
        echo '</div>';
        yii\bootstrap\Modal::end();
    ?>
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
                'attribute' => 'foto_path',
                'format' => 'raw',

                'value' => function($data){
                    if(!empty($data->foto_path))
                        return Html::a(Html::img($data->foto_path,['width'=>'70px']),'',['id'=>'popupModal','data-item'=>$data->foto_path]);
                    else
                        return '';
                }
            ],
            'nama_mahasiswa',
            'nim_mhs',
            
            'tempat_lahir',
            'tgl_lahir',
            [
                'attribute' => 'jenis_kelamin',
                'label' => 'JK',
                'format' => 'raw',
                'filter'=>['L'=>'Laki-laki','P'=>'Perempuan'],
                'value'=>function($model,$url){
                    return $model->jenis_kelamin;
                    
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
            'tahun_masuk',
            [
                'attribute' => 'kampus',
                'filter' => $listKampus,
                'value' => function($data){
                    return !empty($data->kampus0) ? $data->kampus0->nama_kampus : '-';
                }
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'rfid',
                'readonly' => !Yii::$app->user->can('admin'),
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    
                ],
            ],
            [
                'attribute' => 'status_aktivitas',
                'label' => 'Status Aktif',
                'format' => 'raw',
                'filter'=>$status_aktif,
                'value'=>function($model,$url){
                    return $model->status_aktivitas;
                    
                },
            ],
            [
                'class'     => 'yii\grid\ActionColumn',
                'template'  => '{view} {update}',
            ],
    
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

$this->registerJs("$(function() {
   $('#popupModal').click(function(e) {
     e.preventDefault();
     var m = $('#modal').modal('show').find('#img');

     m.attr('src',$(this).data('item'))
     
   });
});");
?>