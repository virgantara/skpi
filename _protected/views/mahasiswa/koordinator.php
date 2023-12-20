<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

$this->title = 'Koordinator Kampus ';
$this->params['breadcrumbs'][] = $this->title;
$model->kampus = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['kampus'] : '';
$model->kode_fakultas = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['kode_fakultas'] : '';

$model->kode_prodi = !empty($_GET['SimakMastermahasiswa']['kode_prodi']) ? $_GET['SimakMastermahasiswa']['kode_prodi'] : '';

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
			'action' => Url::to(['mahasiswa/koordinator']),
			'options' => [


				'class' => 'form-horizontal'
			]
		]); ?>
		<?= $form->errorSummary($model, ['header' => '<div class="alert alert-danger">', 'footer' => '</div>']) ?>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Kelas</label>
			<div class="col-sm-9 col-lg-4">
				<?= $form->field($model, 'kampus')->dropDownList(ArrayHelper::map(\app\models\SimakKampus::find()->all(), 'id', function ($data) {
					return $data->kode_kampus . ' - ' . $data->nama_kampus;
				}), ['class' => 'form-control', 'id' => 'kampus'])->label(false) ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Fakultas</label>
			<div class="col-sm-9 col-lg-4">
				<?= $form->field($model, 'kode_fakultas')->dropDownList(ArrayHelper::map(\app\models\SimakMasterfakultas::find()->all(), 'id', function ($data) {
					return $data->kode_fakultas . ' - ' . $data->nama_fakultas;
				}), ['class' => 'form-control', 'id' => 'fakultas_id'])->label(false) ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Prodi</label>
			<div class="col-sm-9 col-lg-4">
				<?= $form->field($model, 'kode_prodi')->widget(DepDrop::classname(), [
					'options' => ['id' => 'kode_prodi'],
					// 'pluginEvents'=> [
					//     "depdrop.afterChange"=>"function(event, id, value) { 
					//         console.log('value: ' + value + ' id: ' + id); 
					//     }"
					// ],
					'pluginOptions' => [
						'depends' => ['fakultas_id'],
						'params' => ['selected_id'],
						'placeholder' => '...Pilih Prodi...',
						'url' => Url::to(['/asrama/prodi'])
					]
				])->label(false) ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Status Mahasiswa</label>
			<div class="col-sm-9 col-lg-4">
				<?= $form->field($model, 'status_aktivitas')->dropDownList(['A' => 'Aktif', 'N' => 'Non Aktif', 'C' => 'Cuti'], ['class' => 'form-control', 'id' => 'status_aktivitas'])->label(false) ?>
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
						<th>Koordinator<br>Sekarang</th>
						<th>Opsi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 0;
					if (!empty($results)) {
						// $tahun = \app\models\SimakTahunakademik::getTahunAktif();
						foreach ($results as $m) {

							
							$i++;

					?>
							<tr>
								<td><?= ($i); ?></td>
								<td><?= $m->nim_mhs; ?>
								</td>
								<td><?= $m->nama_mahasiswa; ?></td>
								<td><?= $m->jenis_kelamin; ?></td>
								<td><?= $m->semester; ?></td>
								<td>
									<label class="label_koordinator"><?=(!empty($m->koordinator) ? $m->koordinator->nama_koordinator : '')?></label>
										
								</td>
								<td>
									<div class="form-group">
										<div class="col-sm-6">

											<?= Html::dropDownList('koordinator', '', [], ['id' => 'koodinator_id' . $m->nim_mhs, 'class' => 'form-control list_koordinator', 'prompt' => '- Pilih Koordinator -']); ?>
										</div>
										<div class="col-sm-6">
											<button type="button" class="btn btn-info btn-update-koordinator" value="<?php echo $m->nim_mhs ?>">
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

function getListKoordinator(kampus_id){
	$.ajax({

		type : "POST",
		url : "' . Url::to(['/simak-kampus-koordinator/list']) . '",
		data : "kampus_id="+kampus_id,
		success: function(data){
			var hasil = $.parseJSON(data);
			
			var row = "";
			$.each(hasil, function(i,obj){
				row += "<option value=\'"+obj.id+"\'>";
				row += obj.nama;
				row += "</option>";
			});



			$(".list_koordinator").each(function(i,obj){
				$(this).empty();

				$(this).append(row)
			})
			
		}
	});
}

getListKoordinator($("#kampus").val())

$("#kampus").change(function(){
	getListKoordinator($(this).val())
	
});

$(".btn-update-koordinator").click(function(){
	var nim_mahasiswa = $(this).val();
	var koordinator_id = $(this).parent().prev().find(".list_koordinator").val();
	let lbl = $(this).parent().parent().parent().prev().find(".label_koordinator");
	var obj = new Object;
	obj.nimku = nim_mahasiswa;
	obj.koordinator_id = koordinator_id;
	// console.log(obj);
	$.ajax({

		type : "POST",
		url : "' . Url::to(['/mahasiswa/update-koordinator']) . '",
		data : {
			dataku : obj
		},
		success: function(data){
			var hasil = $.parseJSON(data);
			if(hasil.code == 200){

				
				lbl.html(hasil.nama)
				Swal.fire({
				  title: "Yeay",
				  text: hasil.msg,
				  icon: "success",
				  timer: 500
				});
				
			}

			else{
				
				Swal.fire(
				\'Oops\',
				  hasil.msg,
				  \'error\'
				)
			}
			
		}
	});
	
});

$("#fakultas_id").trigger("change");

setTimeout(function(){
	$("#kode_prodi").val("' . (!empty($params['kode_prodi']) ? $params['kode_prodi'] : '-') . '");
},500);

', \yii\web\View::POS_READY);

?>