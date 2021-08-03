<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;

$list_venue = \app\models\Venue::getList();
$list_prodi = \app\models\SimakMasterprogramstudi::getList();
$list_fakultas = \app\models\SimakMasterfakultas::getList();
$list_tingkat = \app\helpers\MyHelper::getTingkatEvent();
$listTahun = \app\models\SimakTahunakademik::find()->select(['tahun_id','nama_tahun'])->orderBy(['tahun_id' => SORT_DESC])->limit(5)->all();
$listTahun = ArrayHelper::map($listTahun,'tahun_id','nama_tahun');
$listDosen = \app\models\SimakMasterdosen::find()->orderBy(['nama_dosen'=>SORT_ASC])->all();

?>

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body ">

                <p>
                    <?= Html::a('Add an event', ['create'], ['class' => 'btn btn-success']) ?>
                    or <?= Html::a('<i class="fa fa-download"></i> Download template events', ['download'], ['class' => 'btn btn-info']) ?>
                </p>
                <p>
                <?php
                    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                      echo '<div class="flash alert alert-' . $key . '">' . $message . '<button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button></div>';
                    }

                ?>
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
                    'attribute' => 'file_path',
                    'format' => 'raw',
                    'value' => function($data){
                        
                        return Html::img($data->file_path,['width'=>'150px']);
                    }
                ],
                [
                    'attribute' => 'kegiatan_id',
                    'value' => function($data){

                        return !empty($data->kegiatan) ? $data->kegiatan->nama_kegiatan : 'Not found';
                    }
                ],

                'nama',
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'venue',
                    'filter' => ArrayHelper::map($list_venue,'nama','nama'),
                    'refreshGrid' => true,
                    'editableOptions' => [
                        'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                        'data' => ArrayHelper::map($list_venue,'nama','nama'),
                        'asPopover' => false,
                    ],

                  
                ],
                'tanggal_mulai',
                'tanggal_selesai',
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'penyelenggara',
                    'refreshGrid' => true,
                     'editableOptions' => [
                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                        'asPopover' => false,
                    ],
                  
                ],
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'tingkat',
                    'filter' => $list_tingkat,
                    'refreshGrid' => true,
                    'editableOptions' => [
                        'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                        'data' => $list_tingkat,
                        'asPopover' => false,
                    ],
                  
                ],
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'fakultas',
                    'refreshGrid' => true,
                    'filter' => ArrayHelper::map($list_fakultas,'kode_fakultas','nama_fakultas'),
                    'editableOptions' => [
                        'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                        'data' => ArrayHelper::map($list_fakultas,'kode_fakultas','nama_fakultas'),
                        'asPopover' => false,
                    ],
                    'value' => function($data){

                        return !empty($data->fakultas0) ? $data->fakultas0->nama_fakultas : 'Not found';
                    }
                ],
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'prodi',
                    'refreshGrid' => true,
                    'filter' => ArrayHelper::map($list_prodi,'kode_prodi','singkatan'),
                    'editableOptions' => [
                        'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                        'data' => ArrayHelper::map($list_prodi,'kode_prodi','singkatan'),
                        'asPopover' => false,
                    ],
                    'value' => function($data){

                        return !empty($data->prodi0) ? $data->prodi0->singkatan : 'Not found';
                    }
                ],
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'dosen_id',
                    'refreshGrid' => true,
                    'filter' => ArrayHelper::map($listDosen,'nidn','nama_dosen'),
                    'editableOptions' => [
                        'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                        'data' => ArrayHelper::map($listDosen,'nidn','nama_dosen'),
                        'asPopover' => false,
                    ],
                    'value' => function($data){

                        return !empty($data->dosen) ? $data->dosen->nama_dosen : 'Not found';
                    }
                ],
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'tahun_id',
                    'filter' => $listTahun,
                    'refreshGrid' => true,
                    'editableOptions' => [
                        'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                        'data' => $listTahun,
                        'asPopover' => false,
                    ],
                  
                ],
                [
                    'attribute' => 'status',
                    'filter' => \app\helpers\MyHelper::getStatusEvent(),
                    'format' => 'raw',
                    'value' => function($data){
                        $list = \app\helpers\MyHelper::getStatusEvent();
                        $colors = \app\helpers\MyHelper::getStatusEventColor();
                        return '<span class="label label-'.$colors[$data->status].'">'.$list[$data->status].'</span>';
                    }
                ],

            //'url:url',
            //'priority',
                ['class' => 'yii\grid\ActionColumn']
];?>                
    <?= GridView::widget([
        'responsiveWrap' => false,
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
        </div>
    </div>

</div>

