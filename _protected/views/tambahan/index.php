<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;

use yii\helpers\ArrayHelper;

use kartik\depdrop\DepDrop;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SimakMagangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Magang';
$this->params['breadcrumbs'][] = $this->title;


// $list_negara = ArrayHelper::map(\app\models\Countries::find()->orderBy(['name' => SORT_ASC])->all(),'id','name');
$list_status_magang = ArrayHelper::map(\app\models\SimakPilihan::find()->where(['kode' => 'stmg'])->all(),'id','label');
$list_jenis_magang = ArrayHelper::map(\app\models\SimakPilihan::find()->where(['kode' => 'mg'])->all(),'id','label');

$list_lokasi_magang = ["1" => "Dalam Negeri","2" => "Luar Negeri"];

$kota_tags = (!empty($_GET['kota_instansi']) ? $_GET['kota_instansi'] : null);
$prodi_tags = (!empty($_GET['kode_prodi']) ? $_GET['kode_prodi'] : null);
// $negara_tags = (!empty($_GET['negara']) ? $_GET['kode_prodi'] : null);
$status_aktif_tags = (!empty($_GET['status_aktivitas']) ? $_GET['status_aktivitas'] : null);
$kampus_tags = (!empty($_GET['kampus']) ? $_GET['kampus'] : null);
$is_dalam_negeri_tags = (!empty($_GET['is_dalam_negeri']) ? $_GET['is_dalam_negeri'] : null);

$status_magang_tags = (!empty($_GET['status_magang_id']) ? $_GET['status_magang_id'] : null);
$jenis_magang_tags = (!empty($_GET['jenis_magang_tags']) ? $_GET['jenis_magang_tags'] : null);
$tahun_masuk_tags = (!empty($_GET['tahun_masuk']) ? $_GET['tahun_masuk'] : null);
$list_kampus = \app\helpers\MyHelper::getKampusList();
// $list_kota = ArrayHelper::map(\app\models\Cities::find()->all(),'id','name');
// $negara = (!empty($_GET['SimakMagangSearch']['negara']) ? $_GET['SimakMagangSearch']['negara'] : null);

$provinsi = (!empty($_GET['provinsi']) ? $_GET['provinsi'] : null);
$kota_tags = (!empty($_GET['kota_instansi']) ? $_GET['kota_instansi'] : null);

?>

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body ">
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
                                
                                <div class="col-lg-4">
                                    <?= $form->field($searchModel, 'namaMahasiswa')->textInput(['class' => 'form-control selec2-filter']) ?>
                                    <?= $form->field($searchModel, 'nim')->textInput(['class' => 'form-control selec2-filter']) ?>
                                    
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
                                <div class="col-lg-4">
                                    <?= $form->field($searchModel, 'is_dalam_negeri')->widget(Select2::classname(), [
                                        'data' => $list_lokasi_magang,
                                        'value' => $is_dalam_negeri_tags,
                                        'options' => [
                                            'id' => 'is_dalam_negeri',
                                            'class' => 'selec2-filter',
                                            'placeholder' => 'Pilih Lokasi Magang ...',
                                            'multiple' => false
                                        ],
                                    ]) ?>
                                    <?= $form->field($searchModel, 'status_magang_id')->widget(Select2::classname(), [
                                        'data' => $list_status_magang,
                                        'value' => $status_magang_tags,
                                        'options' => [
                                            'id' => 'select2-is_status_magang_id',
                                            'class' => 'selec2-filter',
                                            'placeholder' => 'Pilih Status Magang ...',
                                            'multiple' => true
                                        ],
                                    ]) ?>
                                    <?= $form->field($searchModel, 'jenis_magang_id')->widget(Select2::classname(), [
                                        'data' => $list_jenis_magang,
                                        'value' => $jenis_magang_tags,
                                        'options' => [
                                            'id' => 'select2-is_jenis_magang_id',
                                            'class' => 'selec2-filter',
                                            'placeholder' => 'Pilih Jenis Magang ...',
                                            'multiple' => true
                                        ],
                                    ]) ?>
                                    <?= $form->field($searchModel, 'nama_dosen')->textInput(['class' => 'form-control selec2-filter']) ?>
                                </div>
                                <div class="col-lg-4">
                                   
                                    <?= $form->field($searchModel, 'negara')->widget(DepDrop::classname(), [
                                        'type'=>DepDrop::TYPE_SELECT2,
                                        // 'value' => $negara,
                                        'options' => [
                                            'id' => 'negara_id',
                                        ],
                                        'pluginOptions'=>[
                                             // 'id' => 'provinsi_id',
                                            'depends'=>['is_dalam_negeri'],
                                            'initialize' => true,
                                            'placeholder'=>'- Pilih Negara -',
                                            'url'=>'/countries/sub'
                                        ]
                                    
                                    ]) ?>
                                    <?= $form->field($searchModel, 'provinsi')->widget(DepDrop::classname(), [
                                        'type'=>DepDrop::TYPE_SELECT2,
                                        'value' => $provinsi,
                                        'options' => [
                                            'id' => 'provinsi_id',
                                        ],
                                        'pluginOptions'=>[
                                             // 'id' => 'provinsi_id',
                                            'depends'=>['negara_id'],
                                            'initialize' => true,
                                            'placeholder'=>'- Pilih Provinsi -',
                                            'url'=>'/states/sub'
                                        ]
                                    
                                    ]) ?>
                                    <?= $form->field($searchModel, 'kota_instansi')->widget(DepDrop::classname(), [
                                        'type'=>DepDrop::TYPE_SELECT2,
                                        'value' => $kota_tags,
                                        'options' => [
                                            'id' => 'select2-kota_instansi',
                                            'class' => 'selec2-filter',
                                            'multiple' => true,
                                        ],
                                        'pluginOptions'=>[
                                            'depends'=>['provinsi_id'],
                                            'initialize' => true,
                                             
                                            'placeholder'=>'- Pilih Kota -',
                                            'url'=>'/cities/sub',
                                            
                                        ]
                                    
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
            // [
            //     'label' => 'Foto',
            //     'format' => 'raw',
            //     'value' => function($data){
            //         if(!empty($data->nim0->foto_path))
            //             return Html::a(Html::img(Url::to(['mahasiswa/foto','id' => $data->nim0->id]),['width'=>'70px','loading' => 'lazy']),'',['class'=>'popupModal','data-item'=>Url::to(['mahasiswa/foto','id' => $data->nim0->id])]);
            //         else
            //             return '';
            //     }
            // ],
            [
                'attribute' => 'namaMahasiswa',
                // 'contentOptions' => ['width' => '80%'],
                'label' => 'Mahasiswa',
                'value' => function($data){
                    return (!empty($data->nim0) ? $data->nim0->nama_mahasiswa : null);
                }
            ],
            
            [
                'attribute' => 'nama_prodi',
                'label' => 'Prodi',
                'value' => function($data){
                    return (!empty($data->nim0) && !empty($data->nim0->kodeProdi) ? $data->nim0->kodeProdi->nama_prodi : null);
                }
            ],
            [
                'attribute' => 'jenis_magang_id',
                'filter' => $list_jenis_magang,
                'value' => function($data){
                    return (!empty($data->jenisMagang) ? $data->jenisMagang->label : null);
                }
            ],
            'nama_instansi',
            
            [
                'attribute' => 'kota_instansi',
                // 'contentOptions' => ['width' => '80%'],
                'value' => function($data){
                    return (!empty($data->kotaInstansi) ? $data->kotaInstansi->name : null);
                }
            ],
            [
                'attribute' => 'nama_dosen',
                'label' => 'Pembimbing Magang',
                'format' => 'raw',
                'value' => function($data){
                    return (!empty($data->pembimbing) ? $data->pembimbing->display_name :  '<i style="color:red">Pembimbing Magang belum ditentukan</i>');
                }
            ],
            [
                'attribute' => 'is_dalam_negeri',
                'filter' => $list_lokasi_magang,
                'value' => function($data){
                    return ($data->is_dalam_negeri == '1' ? "Dalam Negeri" : "Luar Negeri");
                }
            ],

            'tanggal_mulai_magang:date',
            'tanggal_selesai_magang:date',
            [
                'attribute' => 'status_magang_id',
                'format' => 'raw',
                'filter' => $list_status_magang,
                'value' => function($data){
                    return (!empty($data->statusMagang) ? $data->statusMagang->label : '<i style="color:red">Status Magang belum ditentukan</i>');
                }
            ],
           
            
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}'

                ]
];?>                
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

<?php
        yii\bootstrap\Modal::begin(['id' =>'modal','size'=>'modal-lg',]);
        echo '<div class="text-center">';
        echo '<img width="100%" id="img">';
        echo '</div>';
        yii\bootstrap\Modal::end();
    ?>

<?php

$this->registerJs("

    $(document).on('click','.popupModal',function(e){
        e.preventDefault();
        var m = $('#modal').modal('show').find('#img');

        m.attr('src',$(this).data('item'))
    })
    

");
?>