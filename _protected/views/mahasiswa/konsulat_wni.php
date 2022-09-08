<?php 
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

use yii\jui\AutoComplete;
use yii\web\JsExpression;

$this->title = 'Pemetaan Konsulat';
$this->params['breadcrumbs'][] = $this->title;

$provinsi = !empty($_GET['provinsi']) ? $_GET['provinsi'] : '';

$model->kabupaten = !empty($_GET['SimakMastermahasiswa']['kabupaten']) ? $_GET['SimakMastermahasiswa']['kabupaten'] : '';
$model->status_aktivitas = !empty($_GET['SimakMastermahasiswa']['status_aktivitas']) ? $_GET['SimakMastermahasiswa']['status_aktivitas'] : 'A';
?>

<h1><?=$this->title;?></h1>

<?php $form = ActiveForm::begin([
			'fieldConfig' => [
				'options' => [
					'tag' => false,
				],
			],
			'method' => 'GET',
			'action' => Url::to(['mahasiswa/konsulat-wni']),
			'options' => [

				'id' =>'form-konsulat',
				'class' => 'form-horizontal'
			]
		]); ?>

<div class="row">
	<div class="col-md-6 col-xs-12">
		<div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Status Aktif</label>
	        <div class="col-sm-9">
	            <?php echo $form->field($model,'status_aktivitas')->dropDownList(\app\helpers\MyHelper::getStatusAktivitas(),['prompt'=>'- Pilih Status -','class'=>''])->label(false);?>
            
            </div>
        </div> 
		<div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Provinsi</label>
	        <div class="col-sm-9">
	            <?= Html::dropDownList('provinsi',$provinsi,ArrayHelper::map(\app\models\SimakPropinsi::find()->all(),'id','prov'),['id'=>'propinsi_id','prompt'=>'- Pilih Provinsi -']);?>

	            
	        </div> 
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Kota/Kab</label>
	        <div class="col-sm-9">
	            <?php echo $form->field($model,'kabupaten')->dropDownList([],['prompt'=>'- Pilih Kota/kab -','class'=>'','id' => 'kota_id'])->label(false);?>
            
            </div>
        </div> 
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Pilih Lokasi Peta</label>
	        <div class="col-sm-9">
	            <?php echo $form->field($model,'konsulat',['options'=>['tag' => false]])->dropDownList([],['class'=>'','id' => 'konsulat_id'])->label(false);?>
	            
	                    
            </div>
        </div> 
        <div class="clearfix form-actions">
			<div class="col-md-offset-3 col-md-9">

				<button class="btn btn-info" value="1" type="submit" name="btn-search">
					<i class="ace-icon glyphicon glyphicon-search bigger-110"></i>
					Tampilkan Mahasiswa
				</button>

			</div>
		</div>
       
       
	</div>
	<div class="col-md-6 col-xs-12">
		<p><div id="map" style="height : 400px;width:100%;padd"></div>
</p>
	</div>
</div>

 <?php ActiveForm::end(); ?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
	<div class="col-xs-12">
	
		<div class="table-responsive">
			<table id="tabel_mhs" class="table table-bordered table-hovered table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>NIM</th>
						<th>Nama Mahasiswa</th>
						<th>JK</th>
						<th>Semester</th>
						<th>Prodi</th>
						<th>Kampus</th>
						<th>Status</th>
						<th>Alamat</th>
						<th>Konsulat</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach($results as $q => $m)
					{
						$kab = \app\models\SimakKabupaten::find()->where(['id'=>$m->kabupaten])->one();
						
						echo Html::hiddenInput('nim[]',$m->nim_mhs);
						?>
						<?=Html::hiddenInput('konsulat[]','',['class'=>'konsulat_mhs']);?>
						<tr>
					        <td><?=$q+1;?></td>
					        <td><?=$m->nim_mhs;?></td>
					        <td><?=$m->nama_mahasiswa;?></td>
					        <td><?=$m->jenis_kelamin;?></td>
					        <td><?=$m->semester;?></td>
					        <td><?=!empty($m->kodeProdi) ? $m->kodeProdi->nama_prodi : '-';?></td>
					        <td><?=!empty($m->kampus0) ? $m->kampus0->nama_kampus :'-';?></td>
					        <td><?=$m->status_aktivitas;?></td>
					        <td><?=!empty($kab) ? $kab->kab : '-';?></td>
					        <td><?=!empty($m->konsulat0) ? $m->konsulat0->name : '-';?></td>
					    </tr>
						<?php
					}
					?>
					
				</tbody>
			</table>
     	</div>
    </div>
</div>
<div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> Update All', ['class' => 'btn btn-success btn-block btn-xlg','name'=>'btn-update-all','value'=>'1']) ?>
</div>
<?php ActiveForm::end(); ?>
  
<?php

$this->registerJs(' 

$(\'#link_tempat_tinggal\').click(function(e) {
     e.preventDefault();
    
     $(\'#modal\').modal(\'show\');

});

var mapCenter = [-7.9023, 111.4923];
var globalmap = null;
var marker = null;

getCities($("#propinsi_id").val())

function getCities(pid){
	$.ajax({

		type : "POST",
		url : "'.Url::to(['/simak-kabupaten/ajax-list-kota']).'",
		data : "pid="+pid,
		beforeSend : function(){

		},
		success: function(hasil){
			var hasil = $.parseJSON(hasil)

			$("#kota_id").empty()
			var row = \'<option value="">- Pilih kota/kab -</option>\';
			$.each(hasil,function(i,obj){
				row += \'<option value="\'+obj.id+\'">\'+obj.nama+\'</option>\';
			});

			$("#kota_id").append(row)
			$("#kota_id").val("'.$model->kabupaten.'")

		}
	});
}

function getGlobalCities(nama_kota){
	$.ajax({

		type : "POST",
		url : "'.Url::to(['/cities/ajax-list-kota']).'",
		data : "nama_kota="+nama_kota,
		beforeSend : function(){

		},
		success: function(hasil){
			var hasil = $.parseJSON(hasil)
			var row = ""
			$("#konsulat_id").empty()
			$.each(hasil,function(i,obj){
				row += \'<option value="\'+obj.id+\'">\'+obj.name+\'</option>\';
			});

			$("#konsulat_id").append(row)
			$("#konsulat_id").trigger("change")	
		}
	});
}

setTimeout(function () {
    addMapPicker(\'map\',function(err, res){
        globalmap = res
    });
    
}, 100);

function addMapPicker(mapId, callback) {


    var map = L.map(mapId).setView(mapCenter, 6.5);
    var accessToken = \'pk.eyJ1Ijoib2RkeXZpcmdhbnRhcmEiLCJhIjoiY2tyNGw3MjV5MndpaDJybmw5YmkxdXN6dSJ9.v-b3dCYyL7BaO9s0AzQzMQ\'
      L.tileLayer(\'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}\', {
        maxZoom: 18,
        center: mapCenter,
        zoom: 6.5,
        
        id: \'mapbox/streets-v11\',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: accessToken
      }).addTo(map);
    
    marker = L.marker(mapCenter).addTo(map);
    
    map.on(\'drag\', function(e) {
        map.invalidateSize();
    });
        
    

    

    callback(null, map)
}


$("#propinsi_id").change(function(){
	var pid = $(this).val();
	
	getCities(pid);
});

$("#kota_id").change(function(){
	var nama_kota = $("#kota_id  option:selected").text();
	
	getGlobalCities(nama_kota);

});

$("#konsulat_id").change(function(){
	
	$.ajax({

		type : "POST",
		url : "'.Url::to(['/cities/ajax-get-kota']).'",
		data : "cid="+$(this).val(),
		beforeSend : function(){

		},
		success: function(hasil){
			var hasil = $.parseJSON(hasil)
			$(".konsulat_mhs").each(function(i,obj){
				$(this).val(hasil.id)
			})
			$("#lat").val(hasil.lat)
			$("#lng").val(hasil.lng)

			var lat = (hasil.lat);
			var lng = (hasil.lng);
			marker.setLatLng([lat, lng]).update();
			globalmap.flyTo(new L.LatLng(lat, lng), 13, {
				 animate: true,
				  duration : 2.5
			});

		}
	});
});


$("#btn-lihat").click(function(e){
	e.preventDefault();
	$(\'#form-konsulat\').submit();
});

setTimeout(function(){

	$("#kota_id").trigger("change")
},100);


', \yii\web\View::POS_READY);

?>