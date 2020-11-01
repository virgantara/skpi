<?php 
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

$this->title = 'Pemetaan Dapur';
$this->params['breadcrumbs'][] = $this->title;
$model->kampus = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['kampus'] : '';
$model->kode_fakultas = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['kode_fakultas'] : '';

$model->kode_prodi = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['kode_prodi'] : '';

$model->status_aktivitas = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['status_aktivitas'] : '';
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
			'action' => Url::to(['asrama/dapur']),
			'options' => [


				'class' => 'form-horizontal'
			]
		]); ?>
		<?= $form->errorSummary($model,['header'=>'<div class="alert alert-danger">','footer'=>'</div>']) ?>
		<div class="form-group" >
			<label class="col-sm-3 control-label no-padding-right">Kampus</label>
			<div class="col-sm-9 col-lg-4">
				<?= $form->field($model,'kampus')->dropDownList(ArrayHelper::map(\app\models\SimakKampus::find()->all(),'id',function($data){
					return $data->kode_kampus.' - '.$data->nama_kampus;
				}),['class'=>'form-control'])->label(false) ?>
			</div>
		</div>	
		<div class="form-group" >
			<label class="col-sm-3 control-label no-padding-right">Fakultas</label>
			<div class="col-sm-9 col-lg-4">
				<?= $form->field($model,'kode_fakultas')->dropDownList(ArrayHelper::map(\app\models\SimakMasterfakultas::find()->all(),'id',function($data){
					return $data->kode_fakultas.' - '.$data->nama_fakultas;
				}),['class'=>'form-control','id'=>'fakultas_id'])->label(false) ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Prodi</label>
			<div class="col-sm-9 col-lg-4">
				<?= $form->field($model, 'kode_prodi')->widget(DepDrop::classname(), [
					'options' => ['id'=>'kode_prodi'],
                // 'pluginEvents'=> [
                //     "depdrop.afterChange"=>"function(event, id, value) { 
                //         console.log('value: ' + value + ' id: ' + id); 
                //     }"
                // ],
					'pluginOptions'=>[
						'depends'=>['fakultas_id'],
						'params'=> ['selected_id'], 
						'placeholder' => '...Pilih Prodi...',
						'url' => Url::to(['/asrama/prodi'])
					]   
				])->label(false) ?>
			</div>
		</div>

		<div class="form-group" >
			<label class="col-sm-3 control-label no-padding-right">Status Mahasiswa</label>
				<div class="col-sm-9 col-lg-4">
			<?= $form->field($model,'status_aktivitas')->dropDownList(['A'=>'Aktif'],['class'=>'form-control','id'=>'status_aktivitas'])->label(false) ?>
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
		<div class="table-responsive">
			<table id="tabel_mhs" class="table table-bordered table-hovered table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>NIM</th>
						<th>Nama Mahasiswa</th>
						<th>JK</th>
						<th>Semester</th>
						
						<th>Dapur</th>
						<th>Pindah</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i=0;
					if(!empty($results)){
						foreach($results as $m)
						{
							$i++;

							?>
							<tr>
								<td><?=($i);?></td>
								<td><?=$m->nim_mhs;?>
							</td>
							<td><?=$m->nama_mahasiswa;?></td>
							<td><?=$m->jenis_kelamin;?></td>
							<td><?=$m->semester;?></td>
							
							<td>
								<span class="datadapur"><?=$m->dapur->nama;?></span>
							</td>
							<td>
								<div class="form-group">
									<div class="col-sm-7">
										<?= Html::dropDownList('dapur','',ArrayHelper::map($listDapur,'id','nama'),['id'=>'dapur_'.$m->nim_mhs,'class'=>'form-control dapur_id','prompt'=>'- Pilih Dapur -']);?>
									</div>
									<div class="col-sm-5">
										<button type="button" class="btn btn-info btn-pindah" value="<?php echo $m->nim_mhs ?>">
											<i class="fa fa-paper-plane"></i> Simpan
										</button>
									</div>
								</div>
								
							</td>
						</tr>
						<?php 
					}
				}
				?>
			</tbody>
		</table>

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

	<?php ActiveForm::end(); ?>
</div>
</div>
<?php

$this->registerJs(' 

	
	
	$(".btn-pindah").click(function(){
		Swal.fire({
		  title: \'Do you want to apply this?\',
		  text: "You won\'t be able to revert this!",
		  icon: \'warning\',
		  showCancelButton: true,
		  confirmButtonColor: \'#3085d6\',
		  cancelButtonColor: \'#d33\',
		  confirmButtonText: \'Yes, apply!\'
		}).then((result) => {
		  if (result.value) {
		    var nim_mahasiswa = $(this).val();
		var dapur_id = $(this).parent().prev().find(".dapur_id").val();
		var viewkamar = $(this).parent().parent().parent().prev().find(".datadapur");
		var obj = new Object;
		obj.nimku = nim_mahasiswa;
		obj.dapur_id = dapur_id;
		// console.log(obj);
		$.ajax({

			type : "POST",
			url : "'.Url::to(['/asrama/ajax-dapur']).'",
			data : {
				dataku : obj
			},
			success: function(data){
				var hasil = $.parseJSON(data);

				viewkamar.html(hasil.dapur);
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

	$("#fakultas_id").trigger("change");

	setTimeout(function(){
		$("#kode_prodi").val('.$params['kode_prodi'].');
	},500);

', \yii\web\View::POS_READY);

?>