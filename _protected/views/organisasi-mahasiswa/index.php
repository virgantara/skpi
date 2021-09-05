<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrganisasiMahasiswaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Organisasi Mahasiswa';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organisasi-mahasiswa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php 
    if(Yii::$app->user->can('stafBAPAK') || Yii::$app->user->can('akpam'))
    {
    ?>
    <p>
        <?= Html::a('Create Organisasi Mahasiswa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
}
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
                'filter' => ArrayHelper::map(\app\models\SimakKampus::getList(),'kode_kampus','nama_kampus'),
                'format' => 'raw',
                'attribute' => 'kampus',
                'value' => function($data){
                    return !empty($data->kampus0) ? $data->kampus0->nama_kampus : '-';
                }
            ],
            [
                'filter' => ArrayHelper::map(\app\models\Organisasi::getList(),'id','nama'),
                'format' => 'raw',
                'attribute' => 'organisasi_id',
                'value' => function($data){
                    return !empty($data->organisasi) ? $data->organisasi->nama : '-';
                }
            ],
           
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'no_sk',
                'readonly' => !Yii::$app->user->can('theCreator'),
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    
                ],
            ],
            [
                // 'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'pembimbing_id',
                'value' => function($data){
                    return  !empty($data->pembimbing) ? $data->pembimbing->nama_dosen : '-';
                },
                // 'readonly' => !Yii::$app->user->can('theCreator'),
                // 'editableOptions' => [
                //     'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    
                // ],
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'tahun_akademik',
                'filter' => ArrayHelper::map(\app\models\SimakTahunakademik::getList(),'tahun_id','nama_tahun'),
                'format' => 'raw',
                'readonly' => !Yii::$app->user->can('theCreator'),
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'data' => ArrayHelper::map(\app\models\SimakTahunakademik::getList(),'tahun_id','nama_tahun')
                    
                ],
            ],
            'tanggal_sk',
            'tanggal_mulai',
            'tanggal_selesai',
            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    // 'view' => Yii::$app->user->can('stafBAPAK'),
                    'update' => Yii::$app->user->can('stafBAPAK')||Yii::$app->user->can('akpam'),
                    'delete' => Yii::$app->user->can('stafBAPAK')
                ]
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
