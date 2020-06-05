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
$country = !empty($_GET['countries']) ? $_GET['countries'] : '';
$states = !empty($_GET['states']) ? $_GET['states'] : '';

$model->konsulat = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['konsulat'] : '';
?>

<h1><?=$this->title;?></h1>

<?php $form = ActiveForm::begin([
			'fieldConfig' => [
				'options' => [
					'tag' => false,
				],
			],
			'method' => 'GET',
			'action' => Url::to(['mahasiswa/konsulat']),
			'options' => [

				'id' =>'form-konsulat',
				'class' => 'form-horizontal'
			]
		]); ?>

<div class="row">
	<div class="col-xs-12">
		
		<div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Countries</label>
        <div class="col-sm-9">
            <?= Html::dropDownList('countries',$country,ArrayHelper::map(\app\models\Countries::find()->all(),'id','name'),['id'=>'negara','prompt'=>'- Choose a Country -']);?>

            
            </div>
        </div> 
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">States</label>
        <div class="col-sm-9">
            
        		<?= Html::dropDownList('states',$states,[],['id'=>'states','prompt'=>'- Choose a state -']);?>
            
            </div>
        </div> 
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Cities</label>
        <div class="col-sm-9">
            <?php echo $form->field($model,'konsulat')->dropDownList([],['prompt'=>'- Choose a city -','class'=>'','id' => 'konsulat'])->label(false);?>

            
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
</div>
 <?php ActiveForm::end(); ?>
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
						<th>Opsi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach($results as $m)
					{
						?>
						<tr>
					        <td><span class="numbering"></span></td>
					        <td><?=$m->nim_mhs;?></td>
					        <td><?=$m->nama_mahasiswa;?></td>
					        <td><?=$m->jenis_kelamin;?></td>
					        <td><?=$m->semester;?></td>
					        <td><?=$m->kodeProdi->nama_prodi;?></td>
					        <td><?=$m->kampus0->nama_kampus;?></td>
					        <td><a class="delete btn btn-sm btn-danger" data-item="<?=$m->nim_mhs;?>" href="javascript:void(0)"><i class="fa fa-trash"></i> Delete</a></td>
					    </tr>
						<?php
					}
					?>
					<tr>
						<td colspan="7">
							<input name="nama_mahasiswa" class="form-control"  type="text" id="nama_mahasiswa" placeholder="ketik nama mahasiswa atau nim " />
						</td>
						<td>
							<input type="hidden" id="id">
							<input type="hidden" id="nm">
							<input type="hidden" id="jk">
							<input type="hidden" id="smt">
							<input type="hidden" id="nmp">
							<input type="hidden" id="k">
							<a class="btn btn-sm btn-success" id="add" href="javascript:void(0)"><i class="fa fa-plus"></i> Add</a>
						</td>
					</tr>
				</tbody>
			</table>
     	</div>
    </div>
</div>
    <?php 
            AutoComplete::widget([
    'name' => 'nama_mahasiswa',
    'id' => 'nama_mahasiswa',
    'clientOptions' => [
    'source' => Url::to(['api/ajax-cari-mahasiswa']),
    'autoFill'=>true,
    'minLength'=>'1',
    'select' => new JsExpression("function( event, ui ) {
        
        $('#id').val(ui.item.id);
        $('#nm').val(ui.item.nm);
        $('#jk').val(ui.item.jk);
        $('#smt').val(ui.item.smt);
        $('#nmp').val(ui.item.nmp);
        $('#k').val(ui.item.k);
        
        $('#add').focus();
        
     }")],
    'options' => [
        // 'size' => '40'
    ]
 ]); 
 ?>
	
<?php

$this->registerJs(' 

$(document).on("click","#add",function(){

	var id = $(\'#id\').val();
    var nm = $(\'#nm\').val();
    var jk = $(\'#jk\').val();
    var smt = $(\'#smt\').val();
    var nmp = $(\'#nmp\').val();
    var k = $(\'#k\').val();

	var row = \'<tr>\';
    row += \'<td><span  class="numbering"></span></td>\';
    row += \'<td>\'+id+\'</td>\';
    row += \'<td>\'+nm+\'</td>\';
    row += \'<td>\'+jk+\'</td>\';
    row += \'<td>\'+smt+\'</td>\';
    row += \'<td>\'+nmp+\'</td>\';
    row += \'<td>\'+k+\'</td>\';
    row += \'<td><a class="delete  btn btn-sm btn-danger" data-item="\'+id+\'" href="javascript:void(0)"><i class="fa fa-trash"></i> Delete</a></td>\';
    row += \'</tr>\';

    var nim_mahasiswa = id;
	var city = $("#konsulat").val();
	
	var obj = new Object;
	obj.nim = nim_mahasiswa;
	obj.city = city;
	
	$.ajax({

		type : "POST",
		url : "'.Url::to(['/mahasiswa/add-konsulat']).'",
		data : {
			dataku : obj
		},
		success: function(data){
			var hasil = $.parseJSON(data);
			if(hasil.code == 200){
				$("#tabel_mhs > tbody").prepend(row);
			}

			else{
				Swal.fire(
				\'Oops!\',
				  hasil.msg,
				  \'error\'
				)
			}
			$(\'#id\').val("");
	        $(\'#nm\').val("");
	        $(\'#jk\').val("");
	        $(\'#smt\').val("");
	        $(\'#nmp\').val("");
	        $(\'#k\').val("");

	        $("#nama_mahasiswa").focus();
	        $("#nama_mahasiswa").val("");
		}
	});


});

getStates($("#negara").val());

function getStates(cid){
	$.ajax({

		type : "POST",
		url : "'.Url::to(['/states/states-list']).'",
		data : "cid="+cid,
		beforeSend : function(){
			$("#states").empty();
			var row = \'<option value="">Loading...</option>\';
			$("#states").append(row);
		},
		success: function(hasil){
			// var hasil = $.parseJSON(data);
			$("#states").empty();
			var row = \'<option value="">- Choose a state -</option>\';
			$.each(hasil,function(i,obj){
				row += \'<option value="\'+obj.id+\'">\'+obj.name+\'</option>\';
			});

			$("#states").append(row);

			$("#states").val("'.$states.'");
			getCities("'.$states.'");
		}
	});
}

function getCities(sid){
	$.ajax({

		type : "POST",
		url : "'.Url::to(['/cities/cities-list']).'",
		data : "sid="+sid,
		beforeSend : function(){
			$("#konsulat").empty();
			var row = \'<option value="">Loading...</option>\';
			$("#konsulat").append(row);
		},
		success: function(hasil){
			$("#konsulat").empty();
			var row = \'<option value="">- Choose a city -</option>\';
			$.each(hasil,function(i,obj){
				row += \'<option value="\'+obj.id+\'">\'+obj.name+\'</option>\';
			});

			$("#konsulat").append(row);
			$("#konsulat").val("'.$model->konsulat.'");
		}
	});
}
	$("#negara").change(function(){
		var cid = $(this).val();
		
		getStates(cid);
	});

	$("#states").change(function(){
		var sid = $(this).val();
		
		getCities(sid);
	});
	
	$(document).on("click",".delete",function(){
		Swal.fire({
		  title: \'Do you want to remove this person?\',
		  text: "You won\'t be able to revert this!",
		  icon: \'warning\',
		  showCancelButton: true,
		  confirmButtonColor: \'#3085d6\',
		  cancelButtonColor: \'#d33\',
		  confirmButtonText: \'Yes, remove him/her!\'
		}).then((result) => {
		  if (result.value) {
		    var nim_mahasiswa = $(this).data(\'item\');
			var row = $(this).parent().parent();
			row.remove();
			var obj = new Object;
			obj.nim = nim_mahasiswa;
			
			$.ajax({

				type : "POST",
				url : "'.Url::to(['/mahasiswa/remove-konsulat']).'",
				data : {
					dataku : obj
				},
				success: function(data){
					var hasil = $.parseJSON(data);

					Swal.fire(
					\'Good job!\',
					  hasil.msg,
					  \'success\'
					)
				}
			});
		  }
		})
		
	});

	$("#btn-lihat").click(function(e){
		e.preventDefault();
		$(\'#form-konsulat\').submit();
	});

	setTimeout(function(){
		$("#kode_prodi").val('.$params['kode_prodi'].');
	},500);

	setInterval(function(){
		$(\'.numbering\').each(function(i, obj) {
		    $(this).html(i+1);
		});
	},500);

', \yii\web\View::POS_READY);

?>