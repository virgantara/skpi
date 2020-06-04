<?php 
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

use yii\jui\AutoComplete;
use yii\web\JsExpression;

$this->title = 'Konsulat';
$this->params['breadcrumbs'][] = $this->title;
$country = !empty($_GET['countries']) ? $_GET['countries'] : '';
$model->states_id = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['states_id'] : '';

$model->konsulat = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['konsulat'] : '';
?>

<div class="row">
	<div class="col-xs-12">
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
		<div class="form-group">
            <label class="control-label no-padding-right">Countries</label>
        <div class="">
            <?= Html::dropDownList('countries',$country,ArrayHelper::map(\app\models\Countries::find()->all(),'id','name'),['id'=>'negara','class'=>'form-control','prompt'=>'- Choose a Country -']);?>

            
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label no-padding-right">States</label>
        <div class="">
            <?php echo $form->field($model,'states_id')->widget(DepDrop::className(),[
                'name' => 'states',
                'options' => [
                    'class'=> 'states',
                    'id'=>'states'
                ],
                'pluginOptions'=>[
                    'depends'=>['negara'],
                    'initialize' => true,
                    'placeholder' => '...Choose a state...',
                    'url' => Url::to(['/states/states-list']),

                ]   
            ])->label(false)?>

            
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label no-padding-right">Cities</label>
        <div class="">
            <?php echo $form->field($model,'konsulat')->widget(DepDrop::className(),[
                'name' => 'cities',
                'options' => [
                    'class'=> 'cities',
                    'id' => 'city',
                ],
                'pluginOptions'=>[
                    'depends'=>['states'],
                    'initialize' => true,
                    'placeholder' => '...Choose a city...',
                    'url' => Url::to(['/cities/cities-list']),

                ]   
            ])->label(false);?>

            
            </div>
        </div> 
        <?php ActiveForm::end(); ?>
		
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
					        <td><?=$m->kode_prodi;?></td>
					        <td><?=$m->kampus;?></td>
					        <td><a class="delete" data-item="<?=$m->nim_mhs;?>" href="javascript:void(0)">Delete</a></td>
					    </tr>
						<?php
					}
					?>
					<tr>
						<td colspan="8">
							<input name="nama_mahasiswa" class="form-control"  type="text" id="nama_mahasiswa" placeholder="ketik nama mahasiswa atau nim " />
						</td>
					</td></tr>
				</tbody>
			</table>
     
    <?php 
            AutoComplete::widget([
    'name' => 'nama_mahasiswa',
    'id' => 'nama_mahasiswa',
    'clientOptions' => [
    'source' => Url::to(['api/ajax-cari-mahasiswa']),
    'autoFill'=>true,
    'minLength'=>'1',
    'select' => new JsExpression("function( event, ui ) {
        
        var row = '<tr>';
        row += '<td><span  class=\"numbering\"></span></td>';
        row += '<td>'+ui.item.id+'</td>';
        row += '<td>'+ui.item.nm+'</td>';
        row += '<td>'+ui.item.jk+'</td>';
        row += '<td>'+ui.item.smt+'</td>';
        row += '<td>'+ui.item.nmp+'</td>';
        row += '<td>'+ui.item.k+'</td>';
        row += '<td><a class=\"delete\" data-item=\"'+ui.item.id+'\" href=\"javascript:void(0)\">Delete</a></td>';
        row += '</tr>';

        var nim_mahasiswa = ui.item.id;
		var city = $(\"#city\").val();
		
		var obj = new Object;
		obj.nim = nim_mahasiswa;
		obj.city = city;
		
		$.ajax({

			type : \"POST\",
			url : \"".Url::to(['/mahasiswa/add-konsulat'])."\",
			data : {
				dataku : obj
			},
			success: function(data){
				var hasil = $.parseJSON(data);

				$(\"#tabel_mhs > tbody\").prepend(row);
			}
		});

        

        
     }")],
    'options' => [
        // 'size' => '40'
    ]
 ]); 
 ?>
	</div>
	<!-- <div class="row">
		<div class="col-xs-12">
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">

					<button class="btn btn-info" type="submit" name="btn-submit" value="1">
						<i class="ace-icon glyphicon glyphicon-save bigger-110"></i>
						Simpan Data
					</button>

				</div>
			</div>
		</div>
	</div> -->

</div>
</div>
<?php

$this->registerJs(' 

	
	
	$(".delete").click(function(){
		Swal.fire({
		  title: \'Do you want to remove this person?\',
		  text: "You won\'t be able to revert this!",
		  icon: \'warning\',
		  showCancelButton: true,
		  confirmButtonColor: \'#3085d6\',
		  cancelButtonColor: \'#d33\',
		  confirmButtonText: \'Yes, move him/her!\'
		}).then((result) => {
		  if (result.value) {
		    var nim_mahasiswa = $(this).data(\'item\');
			var city = $(\'#city\').val();
			var row = $(this).parent().parent();
			row.remove();
			var obj = new Object;
			obj.nim = nim_mahasiswa;
			obj.city = city;
			
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

	$("#city").change(function(){
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