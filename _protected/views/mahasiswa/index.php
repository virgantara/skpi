<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MahasiswaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Mahasiswa';
$this->params['breadcrumbs'][] = $this->title;



$rencana_studi = ['1' => '4 Tahun', '2' => '1 Tahun'];

$prodi_tags = (!empty($_GET['kode_prodi']) ? $_GET['kode_prodi'] : null);
$status_aktif_tags = (!empty($_GET['status_aktivitas']) ? $_GET['status_aktivitas'] : null);
$kampus_tags = (!empty($_GET['kampus']) ? $_GET['kampus'] : null);

$status_hapus_tags = (!empty($_GET['status_hapus']) ? $_GET['status_hapus'] : null);
$tahun_masuk_tags = (!empty($_GET['tahun_masuk']) ? $_GET['tahun_masuk'] : null);

$list_status_aktif = \app\helpers\MyHelper::getStatusAktivitas();
$years = array_combine(range(date("Y"), 2010), range(date("Y"), 2010));
$list_kampus = \app\helpers\MyHelper::getKampusList();
?>
<div class="simak-mastermahasiswa-index">

    <h1><?= Html::encode($this->title) ?></h1>

   <?php
        yii\bootstrap\Modal::begin(['id' =>'modal','size'=>'modal-lg',]);
        echo '<div class="text-center">';
        echo '<img width="100%" id="img">';
        echo '</div>';
        yii\bootstrap\Modal::end();
    ?>

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
                                'action' => ['mahasiswa/skpi'],
                                'method' => 'get',
                            ]); ?>
                            <div class="row">
                                
                                <div class="col-lg-6">
                                    <?= $form->field($searchModel, 'nama_mahasiswa')->textInput(['class' => 'form-control selec2-filter']) ?>
                                    <?= $form->field($searchModel, 'nim_mhs')->textInput(['class' => 'form-control selec2-filter']) ?>
                                    <?= $form->field($searchModel, 'semester')->textInput(['class' => 'form-control selec2-filter']) ?>
                                    <?= $form->field($searchModel, 'tahun_masuk')->widget(Select2::classname(), [
                                        'data' => $years,
                                        'value' => $tahun_masuk_tags,
                                        'options' => [
                                            'placeholder' => 'Pilih Angkatan ...',
                                            'multiple' => true,
                                            'id' => 'select2-tahun_masuk',
                                            'class' => 'selec2-filter'
                                        ],
                                    ]) ?>
                                   

                                </div>
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
                                    <?= $form->field($searchModel, 'kampus')->widget(Select2::classname(), [
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
        [
                'attribute' => 'foto_path',
                'format' => 'raw',

                'value' => function($data){
                    if(!empty($data->foto_path))
                        return Html::a(Html::img(Url::to(['mahasiswa/foto','id' => $data->id]),['width'=>'70px']),'',['class'=>'popupModal','data-item'=>Url::to(['mahasiswa/foto','id' => $data->id])]);
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
                'value'=>function($model,$url){
                    return $model->namaProdi;
                    
                },
            ],
            
            'semester',
            'tahun_masuk',
            [
                'attribute' => 'kampus',
                'value' => function($data){
                    return !empty($data->kampus0) ? $data->kampus0->nama_kampus : '-';
                }
            ],
            
            [
                'attribute' => 'status_aktivitas',
                'label' => 'Status Aktif',
                'format' => 'raw',
                'value'=>function($model,$url){
                    return $model->status_aktivitas;
                    
                },
            ],
            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{skpi} {kompetensi}',
            'buttons'=>[
                'skpi'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-eye"></span> SKPI', ['mahasiswa/view','nim' => $model->nim_mhs], ['class' => 'btn btn-primary']);
                },
                'kompetensi'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-eye"></span> Kompetensi', ['mahasiswa/view-kompetensi','nim' => $model->nim_mhs], ['class' => 'btn btn-success']);
                },
                
            ],
            // 'visibleButtons' => [
            //     'validasi' => function ($model, $key, $index) {
            //         return Yii::$app->user->can('akpamPusat') || Yii::$app->user->can('sekretearis')||Yii::$app->user->can('fakultas');
            //     },
            //     'update' => function ($model, $key, $index) {
            //         return Yii::$app->user->can('Mahasiswa');
            //     },
            // ]
        ]
    
];?>    
<p>
<?php 
// Renders a export dropdown menu
echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'clearBuffers' => true, //optional
]);
?>
</p>
<?= GridView::widget([
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
            // '{export}', 

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

    $(document).on('click','.popupModal',function(e){
        e.preventDefault();
        var m = $('#modal').modal('show').find('#img');

        m.attr('src',$(this).data('item'))
    })
    
});");
?>