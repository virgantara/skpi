<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\grid\GridView;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\RequestOrder */

$this->title = Yii::$app->name.' | Item '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Request Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-order-view">

      <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

<?php

$url = '';
if(Yii::$app->user->can('gudang')){
    
    if($model->is_approved !=1){
        $label = 'Setujui Permintaan RO';
        $kode = 1;
        $warna = 'info';
        echo Html::a($label, ['approve', 'id' => $model->id,'kode'=>$kode], [
            'class' => 'btn btn-'.$warna,
            'data' => [
                'confirm' => $label.' permintaan ini?',
                'method' => 'post',
            ],
        ]);
    }
    
} 

if(Yii::$app->user->can('kepalaCabang')){
    $url = 'approveRo';
    $label = '';
    $kode = 0;
    $warna = '';
    if($model->is_approved_by_kepala ==1){
        $label = 'Batal Setujui';
        $kode = 2;
        $warna = 'warning';
    }

    else{
        $label = 'Setujui RO';
        $kode = 1;
        $warna = 'info';
    }
    echo Html::a($label, ['approve-ro', 'id' => $model->id,'kode'=>$kode], [
        'class' => 'btn btn-'.$warna,
        'data' => [
            'confirm' => $label.' permintaan ini?',
            'method' => 'post',
        ],
    ]);
} 
?>
    </p>
<div class="col-xs-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'no_ro',
            'petugas1',
            'petugas2',
           
            
        ],
    ]) ?>
</div>
<div class="col-xs-6">
     <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'tanggal_pengajuan',
            'tanggal_penyetujuan',
            // 'perusahaan_id',
            'created',
        ],
    ]) ?>
</div>
<?php 
if($model->departemen_id == Yii::$app->user->identity->departemen){
?>   
    <div class="row" >
        <div class="col-xs-12">
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th>Data</th>
            <th>Kode</th>
            <th>Barang</th>
            <th>Jml minta</th>
            <th>Satuan</th>
            <th>Opsi</th>
        </tr>
        <tr>
            <td width="30%">
                 <?php 
    $url = \yii\helpers\Url::to(['/sales-stok-gudang/ajax-barang']);
    
    $template = '<div><p class="repo-language">{{nama}}</p>' .
    '<p class="repo-name">{{kode}}</p>';
    echo \kartik\typeahead\Typeahead::widget([
    'name' => 'kd_barang',
    'value' => '',
    'options' => ['placeholder' => 'Ketik nama barang ...'],
    'pluginOptions' => ['highlight'=>true],
    'pluginEvents' => [
        "typeahead:select" => "function(event,ui) { 
            $('#jml_minta').focus();

            $('#kode_barang').val(ui.kode);
            $('#nama_barang').val(ui.nama);
            $('#id_stok').val(ui.id_stok);
            $('#item_id').val(ui.id);
            $('#jml_minta').val('0');
            $('#satuan').val(ui.satuan);
        }",
    ],
    
    'dataset' => [
        [
            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
            'display' => 'value',
            // 'prefetch' => $baseUrl . '/samples/countries.json',
            'remote' => [
                'url' => Url::to(['sales-stok-gudang/ajax-barang']) . '?q=%QUERY',
                'wildcard' => '%QUERY'
            ],
            'templates' => [
                'notFound' => '<div class="text-danger" style="padding:0 8px">Data Item Barang tidak ditemukan.</div>',
                'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
            ]
        ]
    ]
]);
    ?>
              

            </td>
            <td ><input id="kode_barang" type="text" class="form-control"></td>
            <td >
                <input id="ro_id" type="hidden" value="<?=$model->id;?>">
                <input id="id_stok" type="hidden">
                <input id="item_id" type="hidden">
                <input id="nama_barang" type="text" class="form-control">
            </td>
            <td ><input id="jml_minta" type="text" class="form-control"></td>
            <td ><input id="satuan" type="text" class="form-control"></td>
            <td><button class="btn btn-sm btn-primary" id="input-barang"><i class="fa fa-plus"></i> Input</button></td>
        </tr>
    </table>
</div>
    </div>
    <?php 
}
    ?>
      <p>
        <div class="alert alert-success" id="alert-message" style="display: none">Data Tersimpan</div>
        <?php 
    //      if(Yii::$app->user->can('operatorCabang')) {
    //     echo Html::a('Create Request Order Item', ['/request-order-item/create','ro_id'=>$model->id], ['class' => 'btn btn-success']);
    // }
         ?>
    </p>

<?php \yii\widgets\Pjax::begin(['id' => 'pjax-container']); ?>    
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'stok.barang.nama_barang',
            'jumlah_minta',
            'jumlah_beri',
            'satuan',
            'keterangan',
            //'created',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'visibleButtons' => [
                    'view' => function($data){
                        return !Yii::$app->user->can('kepalaCabang');
                    },
                    'update' => function($data){
                        return $data->ro->departemen_id != Yii::$app->user->identity->departemen;
                    },
                    'delete' => function($data){
                       return !Yii::$app->user->can('kepalaCabang');
                    },
                ],
                'buttons' => [
                    'update' => function($url, $model){
                         return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                   'title'        => 'update',
                                    'onclick' => "
                                    $('#ro-item-id').val(".$model->id.");
                                    $('#jumlah-beri').val(".$model->jumlah_beri.");
                                    $('#ket-beri').val('".$model->keterangan."');
                                    $('#test').trigger('click');
                                    return false;
                                ",
                                    // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    // 'data-method'  => 'post',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                   'title'        => 'delete',
                                    'onclick' => "
                                    if (confirm('Are you sure you want to delete this item?')) {
                                        $.ajax('$url', {
                                            type: 'POST'
                                        }).done(function(data) {
                                            $.pjax.reload({container: '#pjax-container'});
                                            $('#alert-message').html('Data berhasil dihapus');
                                            $('#alert-message').show();    
                                            $('#alert-message').fadeOut(2500);
                                        });
                                    }
                                    return false;
                                ",
                                    // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    // 'data-method'  => 'post',
                        ]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    
                    if ($action === 'delete') {
                        $url =Url::to(['request-order-item/delete','id'=>$model->id]);
                        return $url;
                    }

                    else if ($action === 'update') {
                        $url =Url::to(['request-order-item/update','id'=>$model->id,'ro_id'=>$model->ro_id]);
                        return $url;
                    }

                    else if ($action === 'view') {
                        $url =Url::to(['request-order-item/view','id'=>$model->id]);
                        return $url;
                    }

                }
            ],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
<?php 

\yii\bootstrap\Modal::begin([
    'header' => '<h2>Konfirmasi Pemberian</h2>',
    'toggleButton' => ['label' => '','id'=>'test','style'=>'display:none'],
]);

?>
<form class="form-horizontal" role="form">
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jumlah Beri </label>

        <div class="col-sm-9">
            <input type="hidden" id="ro-item-id"/>
            <input type="text" id="jumlah-beri" placeholder="Jumlah Beri" class="col-xs-10 col-sm-5" />
        </div>
    </div>

     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Keterangan </label>

        <div class="col-sm-9">
            <input type="text" id="ket-beri" placeholder="Keterangan" class="col-xs-10 col-sm-5" />
        </div>
    </div>
   
    <div class="space-4"></div>

    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="button" id="btn-beri">
                <i class="ace-icon fa fa-check bigger-110"></i>
                Submit
            </button>

            &nbsp; &nbsp; &nbsp;
            <button class="btn" type="reset">
                <i class="ace-icon fa fa-undo bigger-110"></i>
                Reset
            </button>
        </div>
    </div>
</form>
<?php

\yii\bootstrap\Modal::end();
?>
<?php
$script = "

jQuery(function($){

    $('#btn-beri').on('click',function(){

        var jml_beri = $('#jumlah-beri').val();
        var keterangan = $('#ket-beri').val();

        item = new Object;
        item.ro_id = $('#ro-item-id').val();
        item.keterangan = keterangan;
        item.jml_beri = jml_beri;
      
        $.ajax({
            type : 'POST',
            url : '/request-order-item/ajax-update-item',
            data : {dataItem:item},
            beforeSend: function(){

                $('#alert-message').hide();
            },
            success : function(data){
                var hsl = jQuery.parseJSON(data);

                if(hsl.code == '200'){
                    $('#w4').modal('hide');
                    $.pjax({container: '#pjax-container'});
                    $('#alert-message').html('Data telah disimpan');
                    $('#alert-message').show();    
                    $('#alert-message').fadeOut(2500);
                }

                else{
                    alert(hsl.message);
                } 
            }
        });
    });

    $('#input-barang').on('click',function(){
        var ro_id = $('#ro_id').val();
        var stok_id = $('#id_stok').val();
        var jml_minta = $('#jml_minta').val();
        var item_id = $('#item_id').val();
        var satuan = $('#satuan').val();
       

        item = new Object;
        item.ro_id = ro_id;
        item.stok_id = stok_id;
        item.jml_minta = jml_minta;
        item.item_id = item_id;
        item.satuan = satuan;
      
        $.ajax({
            type : 'POST',
            url : '/request-order-item/ajax-create',
            data : {dataItem:item},
            beforeSend: function(){

                $('#alert-message').hide();
            },
            success : function(data){
                var hsl = jQuery.parseJSON(data);

                if(hsl.code == '200'){
                    
                    $.pjax({container: '#pjax-container'});
                    $('#alert-message').html('Data telah disimpan');
                    $('#alert-message').show();    
                    $('#alert-message').fadeOut(2500);
                }

                else{
                    alert(hsl.message);
                } 
            }
        });
    });

});
";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);
// $this->registerJs($script);
?>