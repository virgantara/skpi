<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SkpiPermohonanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Pemohon SKPI';
$this->params['breadcrumbs'][] = $this->title;


$prodi_tags = (!empty($_GET['kode_prodi']) ? $_GET['kode_prodi'] : null);
// $query = \app\models\SimakMasterprogramstudi::find();


// if(!Yii::$app->user->isGuest && in_array(Yii::$app->user->identity->access_role, $allowed)){
//     $query->andWhere(['kode_prodi' => Yii::$app->user->identity->prodi]);
// }

// $query->orderBy(['kode_jenjang_studi'=>SORT_ASC,'kode_fakultas' => SORT_ASC,'nama_prodi' => SORT_ASC]);
// $list_prodi = $query->all();
// $list_prodi = ArrayHelper::map($list_prodi,'kode_prodi','nama_prodi');


$list_kampus = ArrayHelper::map(\app\models\SimakKampus::find()->all(),'kode_kampus','nama_kampus');

$list_status_pengajuan = \app\helpers\MyHelper::getStatusPengajuan();
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body ">
                <?php 
                if(Yii::$app->user->can('theCreator')){
                 ?>
                
                <p>
                    <?= Html::a('Ajukan pemohon', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
            <?php } ?>
                <div id="faq" role="tablist" aria-multiselectable="true">

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="questionOne">
                        <h5 class="panel-title">
                            <a data-toggle="collapse" data-parent="#faq" href="#answerOne" aria-expanded="false" aria-controls="answerOne">
                                <i class="fa fa-filter"></i> Filter <small style="color:blue">* Klik di sini untuk filter data</small>
                            </a>
                        </h5>
                    </div>
                    <div id="answerOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="questionOne">
                        <div class="panel-body">

                            <?php $form = ActiveForm::begin([
                                'action' => ['index'],
                                'method' => 'get',
                            ]); ?>
                            <div class="row">
                                
                                
                                <div class="col-lg-6">
                                    <?= $form->field($searchModel, 'kode_prodi')->widget(Select2::classname(), [
                                        'data' => $list_prodi,
                                        'value' => $prodi_tags,
                                        'options' => [
                                            'id' => 'select2-kode_prodi',
                                            'class' => 'selec2-filter',
                                            'placeholder' => 'Pilih Prodi ...',
                                            'multiple' => true
                                        ],
                                    ]) ?>
                                    
                                </div>
                            </div>


                            <div class="form-group">
                                <?= Html::submitButton('Apply Filter', ['class' => 'btn btn-primary']) ?>
                                <?= Html::resetButton('Reset', ['class' => 'btn btn-default btn-reset', 'type' => 'reset']) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>


            </div>
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
            'nim',
            [
                'attribute' => 'namaMahasiswa',
                'value' => function($data){
                    return !empty($data->nim0) ? $data->nim0->nama_mahasiswa : null;
                }
            ],
            [
                'label' => 'Tempat & Tgl Lahir',
                'value' => function($data){
                    return !empty($data->nim0) ? $data->nim0->tempat_lahir.', '.\app\helpers\MyHelper::convertTanggalIndo($data->nim0->tgl_lahir) : null;
                }
            ],
            [
                'attribute' => 'namaProdi',
                'filter' => $list_prodi,
                'value' => function($data){
                    return $data->nim0->kodeProdi->nama_prodi;
                }
            ],
            [
                'attribute' => 'namaKampus',
                'filter' => $list_kampus,
                'value' => function($data){
                    return $data->nim0->kampus0->nama_kampus;
                }
            ],
            [
                'label' => 'Tahun Lulus',
                'value' => function($data){
                    return (isset($data->nim0->tgl_lulus) ? \app\helpers\MyHelper::convertTanggalIndo($data->nim0->tgl_lulus) : null);
                }
            ],
            'tanggal_pengajuan:date',
            [
                'label' => 'Nomor Ijazah',
                'value' => function($data){
                    return $data->nim0->no_ijazah;
                }
            ],
            [
                'attribute' => 'nomor_skpi',
                'class' => 'kartik\grid\EditableColumn',
                'readonly' => !Yii::$app->user->can('akpamPusat'),
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'asPopover' => false,
                ],
            ],
            [
                'attribute' => 'link_barcode',
                'class' => 'kartik\grid\EditableColumn',
                'readonly' => !Yii::$app->user->can('akpamPusat'),
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'asPopover' => false,
                ],
            ],
            
            [
                'attribute' => 'status_pengajuan',
                
                'filter' => $list_status_pengajuan,
                'value' => function($data) use ($list_status_pengajuan){
                    return $list_status_pengajuan[$data->status_pengajuan];
                }
            ],
            [
                'attribute' => 'approved_by',
                'value' => function($data) {
                    return (!empty($data->approvedBy) ? $data->approvedBy->display_name : '-');
                }
            ],
            //'updated_at',
            //'created_at',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {print-skpi}',
                    'buttons'=>[                    
                        'view'=>function ($url, $model) {
                            return Html::a('<span class="fa fa-eye"></span> View', $url, ['class' => 'btn btn-primary']);
                        },
                        'print-skpi'=>function ($url, $model) {
                            return Html::a('<span class="fa fa-download"></span> Download', $url, ['class' => 'btn btn-success','data-pjax' => 0]);
                        },
                        // 'delete'=>function ($url, $model) {
                        //     return Html::a('<span class="fa fa-trash"></span> Delete', $url, ['class' => 'btn btn-danger','data-method' => 'POST']);
                        // },
                        
                    ],
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

