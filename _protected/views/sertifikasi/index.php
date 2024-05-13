<?php

use yii\helpers\Html;
use kartik\grid\GridView;

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SimakSertifikasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sertifikasi';
$this->params['breadcrumbs'][] = $this->title;

$list_jenis_sertifikasi = \app\helpers\MyHelper::getJenisSertifikasi();
$list_status_validasi = \app\helpers\MyHelper::getStatusValidasi();


$list_prodi = \app\helpers\MyHelper::getProdiList();
$prodi_tags = (!empty($_GET['namaProdi']) ? $_GET['namaProdi'] : null);
$status_aktif_tags = (!empty($_GET['status_aktivitas']) ? $_GET['status_aktivitas'] : null);
$kampus_tags = (!empty($_GET['kampus']) ? $_GET['kampus'] : null);

$tahun_masuk_tags = (!empty($_GET['tahun_masuk']) ? $_GET['tahun_masuk'] : null);
$status_validasi_tags = (!empty($_GET['status_validasi']) ? $_GET['status_validasi'] : null);

$list_status_aktif = \app\helpers\MyHelper::getStatusAktivitas();
$years = array_combine(range(date("Y"), 2010), range(date("Y"), 2010));
$list_kampus = \app\helpers\MyHelper::getKampusList();

?>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h3><?= Html::encode($this->title) ?></h3>
            </div>
<div class="x_content">

    <?php 
    if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
     ?>
    
    <p>
        <?= Html::a('<i class="fa fa-plus"></i> Tambah', ['create'], ['class' => 'btn btn-success']) ?>
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
                                    <?= $form->field($searchModel, 'namaMahasiswa')->textInput(['class' => 'form-control selec2-filter']) ?>
                                    <?= $form->field($searchModel, 'nim')->textInput(['class' => 'form-control selec2-filter']) ?>
                                    <?= $form->field($searchModel, 'jenis_sertifikasi')->widget(Select2::classname(), [
                                        'data' => $list_jenis_sertifikasi,
                                        // 'value' => $tahun_masuk_tags,
                                        'options' => [
                                            'placeholder' => 'Pilih Jenis Sertifikasi ...',
                                            'multiple' => true,
                                            'id' => 'select2-jenis_sertifikasi',
                                            'class' => 'selec2-filter'
                                        ],
                                    ]) ?>
                                    <?= $form->field($searchModel, 'status_validasi')->widget(Select2::classname(), [
                                        'data' => $list_status_validasi,
                                        'value' => $status_validasi_tags,
                                        'options' => [
                                            'placeholder' => 'Pilih Status Validasi ...',
                                            'multiple' => true,
                                            'id' => 'select2-status_validasi',
                                            'class' => 'selec2-filter'
                                        ],
                                    ]) ?>
                                </div>
                                <div class="col-lg-6">
                                    <?= $form->field($searchModel, 'namaProdi')->widget(Select2::classname(), [
                                        'data' => $list_prodi,
                                        'value' => $prodi_tags,
                                        'options' => [
                                            'id' => 'select2-kode_prodi',
                                            'class' => 'selec2-filter',
                                            'placeholder' => 'Pilih Prodi ...',
                                            'multiple' => true
                                        ],
                                    ]) ?>
                                    <?= $form->field($searchModel, 'status_aktivitas')->widget(Select2::classname(), [
                                        'data' => $list_status_aktif,
                                        'value' => $status_aktif_tags,
                                        'options' => [
                                            'id' => 'select2-status_aktivitas',
                                            'class' => 'selec2-filter',
                                            'placeholder' => 'Pilih Status Aktif ...',
                                            'multiple' => true
                                        ],
                                    ]) ?>
                                    <?= $form->field($searchModel, 'namaKampus')->widget(Select2::classname(), [
                                        'data' => $list_kampus,
                                        'value' => $kampus_tags,
                                        'options' => [
                                            'id' => 'select2-kampus',
                                            'class' => 'selec2-filter',
                                            'placeholder' => 'Pilih Kelas ...',
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
            // 'id',
            'nim',
            [
                'attribute' => 'jenis_sertifikasi',
                'filter' => $list_jenis_sertifikasi,
                'value' => function($data) use ($list_jenis_sertifikasi){
                    return $list_jenis_sertifikasi[$data->jenis_sertifikasi];
                }
            ],
            'lembaga_sertifikasi',
            'nomor_registrasi_sertifikasi',
            'nomor_sk_sertifikasi',
            'tahun_sertifikasi',
            [
                'attribute' => 'status_validasi',
                'value' => function($data) use ($list_status_validasi){
                    return $list_status_validasi[$data->status_validasi];
                }
            ],
            //'tmt_sertifikasi',
            //'tst_sertifikasi',
            //'file_path',
            //'status_validasi',
            //'updated_at',
            //'created_at',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {validasi} {delete}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-eye"></span> View', $url, ['class' => 'btn btn-primary']);
                },
                'update'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-edit"></span> Update', $url, ['class' => 'btn btn-primary']);
                },
                'validasi'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-check"></span> Validasi', $url, ['class' => 'btn btn-success']);
                },
                'delete' => function ($url, $model) {
                    return Html::a('<i class="fa fa-trash"></i> Delete', $url, [
                        'title' => Yii::t('app', 'Hapus data'),
                        'class' => 'btn btn-danger',
                        'data-pjax' => 0,
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]);
                },
                
            ],
            'visibleButtons' => [
                'validasi' => function ($model, $key, $index) {
                    return Yii::$app->user->can('akpamPusat');
                },
            ]
        ]
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
        // 'filterModel' => $searchModel,
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
        </div>
    </div>

</div>

