<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model app\models\OrganisasiMahasiswa */

$this->title = $model->organisasi->nama;
$this->params['breadcrumbs'][] = ['label' => 'Organisasi Mahasiswas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$listJabatan = ArrayHelper::map(\app\models\OrganisasiJabatan::find()->all(),'id','nama');
?>
<style type="text/css">
    .ui-autocomplete { z-index:2147483647; }

</style>
<div class="row">
    <div class="col-md-12">
        
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            [
                'attribute' => 'organisasi_id',
                'value' => function($data){
                    return $data->organisasi->nama;
                }
            ],
            [
                'label' => 'Pembimbing',
                'value' => function($data){
                    return $data->pembimbing->nama_dosen;
                }
            ],
            'tanggal_mulai',
            'tanggal_selesai',
            'no_sk',
            'tanggal_sk',
            
        ],
    ]) ?>
          
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        

    <p>
        <?= Html::a('<i class="fa fa-plus"></i> Tambah Anggota', ['organisasi-anggota/create','id'=>$model->id], ['class' => 'btn btn-success','id'=>'btn-tambah']) ?>
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
            'nim',
            [
                'attribute' => 'namaMahasiswa',
                'label' => 'Mahasiswa',
                'format' => 'raw',
                'value'=>function($model,$url){
                    return $model->namaMahasiswa;
                    
                },
            ],
            [
                'attribute' => 'namaKampus',
                'label' => 'Kampus',
                'format' => 'raw',
                
                'value'=>function($model,$url){
                    return $model->namaKampus;
                    
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
            [
                'attribute' => 'jabatan_id',
                'label' => 'Jabatan',
                'format' => 'raw',
                'value'=>function($model,$url){
                    return $model->jabatan->nama;
                    
                },
            ],
            'peran:ntext',
            //'created_at',
            //'updated_at',
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{delete}',
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'delete') {
                $url =Url::to(['organisasi-anggota/delete','id'=>$model->id]);
                return $url;
            }

          }
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
                    ['content'=> 'Data Anggota', 'options'=>['colspan'=>14, 'class'=>'text-center warning']], //cuma satu 
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

</div>

<?php 


 Modal::begin([
        'header' => 'Modal',
        'id' => 'modal',
        'size' => 'modal-md',
    ]);
 ?>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal">
         
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">NIM</label>
            <div class="col-sm-9">
                <input type="hidden" class="form-control" id="nim">
                <input name="nama_mahasiswa" class="form-control"  type="text" id="nama_mahasiswa" placeholder="ketik nama mahasiswa atau nim " />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Jabatan</label>
            <div class="col-sm-9">
                <?=Html::dropDownList('jabatan','',$listJabatan,['id'=>'jabatan_id','class'=>'form-control']);?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Peran</label>
            <div class="col-sm-9">
                <textarea id="peran" rows="4" cols="40"></textarea>
            </div>
        </div>
        <div class="col-sm-offset-3">
            <button type="button" id="btn-tambahkan" class="btn btn-info">Tambahkan</button>
        </div>

        </form>
    </div>
</div>
 <?php
    Modal::end();
?>

 <?php 
    AutoComplete::widget([
    'name' => 'nama_mahasiswa',
    'id' => 'nama_mahasiswa',
    'clientOptions' => [
    'source' => Url::to(['api/ajax-cari-mahasiswa']),
    'autoFill'=>true,
    'minLength'=>'1',
    'select' => new JsExpression("function( event, ui ) {
        
        $('#nim').val(ui.item.id);
        
     }")],
    'options' => [
        // 'size' => '40'
    ]
 ]); 
 ?>

 <?php 
$script = "
    $('#btn-tambah').on('click', function (e) {
        e.preventDefault();
        $('#modal').modal('show');
    });

    $('#btn-tambahkan').on('click', function (e) {
        e.preventDefault();

        var obj = new Object;
        obj.nim = $('#nim').val();
        obj.jabatan_id = $('#jabatan_id').val();
        obj.organisasi_id = '".$model->id."';
        obj.peran = $('#peran').val();
        $.ajax({
            type : 'POST',
            data : {
                dataPost : obj
            },
            url : '".Url::to(['organisasi-anggota/ajax-create'])."',
            success : function(data){
                var hasil = $.parseJSON(data);

                if(hasil.code == 200){
                    Swal.fire({
                      title: 'Yeay!',
                      text: hasil.message,
                      icon: 'success',
                    });

                    $.pjax.reload({container: '#pjax-container'});
                }

                else{
                    Swal.fire({
                      title: 'Oops!',
                      text: hasil.message,
                      icon: 'error',
                    });
                }
            }
        })
    });
";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);
 ?>