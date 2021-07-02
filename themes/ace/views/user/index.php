<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;

$list_kampus = ArrayHelper::map(\app\models\SimakKampus::getList(),'kode_kampus','nama_kampus');
?>
<div class="user-index">

    <h1>
        <?= Html::encode($this->title) ?>
        <span class="pull-right">
            <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
        </span>         
    </h1>

    
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
        'attribute' => 'username',
        'readonly' => !Yii::$app->user->can('theCreator'),
        'editableOptions' => [
            'inputType' => \kartik\editable\Editable::INPUT_TEXT,
            
        ],
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'email',
        'readonly' => !Yii::$app->user->can('theCreator'),
        'editableOptions' => [
            'inputType' => \kartik\editable\Editable::INPUT_TEXT,
            
        ],
    ],
    // status
    [
         'class' => 'kartik\grid\EditableColumn',
        'attribute'=>'status',
        'filter' => $searchModel->statusList,
        'value' => function ($data) {
            return $data->getStatusName($data->status);
        },
        'refreshGrid' => true,
        'editableOptions' => [
            'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
            'data' => $searchModel->statusList,
            'asPopover' => false 
        ],
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'uuid',
        'readonly' => !Yii::$app->user->can('theCreator'),
        'editableOptions' => [
            'inputType' => \kartik\editable\Editable::INPUT_TEXT,
            
        ],
    ],
    [

        'attribute'=>'item_name',
        'filter' => $searchModel->rolesList,
        'value' => function ($data) {
            return $data->roleName;
        },
        'contentOptions'=>function($model, $key, $index, $column) {
            return ['class'=>CssHelper::roleCss($model->roleName)];
        }
    ],
    [
         'class' => 'kartik\grid\EditableColumn',
        'attribute'=>'kampus',
        'filter' => $list_kampus,
        'value' => function ($data) {
            return !empty($data->kampus0) ? $data->kampus0->nama_kampus : null;
        },
        'refreshGrid' => true,
        'editableOptions' => [
            'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
            'data' => $list_kampus,
            'asPopover' => false 
        ],
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Opsi'
    ]

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
