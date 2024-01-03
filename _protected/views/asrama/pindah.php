<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

$this->title = 'Pindah Kamar';
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
			'action' => Url::to(['asrama/pindah']),
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
						<th>Konsulat</th>

						<th>Asrama dan Kamar</th>
						<th>Pindah</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 0;
					if (!empty($results)) {
						$tahun = \app\models\SimakTahunakademik::getTahunAktif();
						foreach ($results as $m) {

							$konfirmasi = \app\models\SimakKonfirmasipembayaran::find()->where([
								'pembayaran' => '01',
								'status' => 1,
								'nim' => $m->nim_mhs,
								'tahun_id' => $tahun->tahun_id
							])->one();

							if (empty($konfirmasi)) continue;
							$i++;

					?>
							<tr>
								<td><?= ($i); ?></td>
								<td><?= $m->nim_mhs; ?>
								</td>
								<td><?= $m->nama_mahasiswa; ?></td>
								<td><?= $m->jenis_kelamin; ?></td>
								<td><?= $m->semester; ?></td>
								<td><?= !empty($m->konsulat0) ? $m->konsulat0->name : 'konsulat name not set'; ?> - <?= !empty($m->konsulat0) ? $m->konsulat0->state->name : 'provinsi not set'; ?> - <?= !empty($m->konsulat0) ? $m->konsulat0->country->name : 'country name not set'; ?></td>
								<td>
									<span class="datakamar"><?= (!empty($m->kamar) ? $m->kamar->namaAsrama . ' - ' . $m->kamar->nama : '-'); ?></span>
								</td>
								<td>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right">Asrama</label>
										<div class="col-sm-9">

											<?= Html::dropDownList('asrama', '', [], ['id' => 'asrama_' . $m->nim_mhs, 'class' => 'form-control list_asrama', 'prompt' => '- Pilih Asrama -']); ?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right">Kamar</label>
										<div class="col-sm-4">
											<?php echo DepDrop::widget([
												'name' => 'kamar_id_' . $m->nim_mhs,
												'options' => [
													'class' => 'kamar_id'
												],
												'pluginOptions' => [
													'depends' => ['asrama_' . $m->nim_mhs],
													'placeholder' => '...Pilih Kamar...',
													'url' => Url::to(['/kamar/kamar-list']),

												]
											]) ?>
										</div>
										<div class="col-sm-5">
											<button type="button" class="btn btn-info btn-pindah" value="<?php echo $m->nim_mhs ?>">
												<i class="fa fa-paper-plane"></i> Pindah
											</button>
											<br>
											<br>
											<div class="icon">
												<a href="/asrama/setnull?nim=<?php echo $m->nim_mhs ?>" onclick="myFunction()"><i class="fa fa-paper-plane"></i> Kosongkan Kamar</a>
											</div>
										</div>
										<script>
											function myFunction() {
												confirm("Are you sure want to set him's/her's room to null?");
											}
										</script>

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

function getListAsrama(kampus_id){
	$.ajax({

		type : "POST",
		url : "' . Url::to(['/asrama/list']) . '",
		data : "kampus_id="+kampus_id,
		success: function(data){
			var hasil = $.parseJSON(data);
			
			var row = "";
			$.each(hasil, function(i,obj){
				row += "<option value=\'"+obj.id+"\'>";
				row += obj.nama;
				row += "</option>";
			});



			$(".list_asrama").each(function(i,obj){
				$(this).empty();

				$(this).append(row)
			})
			
		}
	});
}

getListAsrama($("#kampus").val())

	$("#kampus").change(function(){
		getListAsrama($(this).val())
		
	});
	
	$(".btn-pindah").click(function(){
		Swal.fire({
		  title: \'Do you want to migrate this person?\',
		  text: "You won\'t be able to revert this!",
		  icon: \'warning\',
		  showCancelButton: true,
		  confirmButtonColor: \'#3085d6\',
		  cancelButtonColor: \'#d33\',
		  confirmButtonText: \'Yes, move him/her!\'
		}).then((result) => {
		  if (result.value) {
		    var nim_mahasiswa = $(this).val();
		var kamar_id = $(this).parent().prev().find(".kamar_id").val();
		var viewkamar = $(this).parent().parent().parent().prev().find(".datakamar");
		// console.log(viewkamar);
		var obj = new Object;
		obj.nimku = nim_mahasiswa;
		obj.kamarku = kamar_id;
		// console.log(obj);
		$.ajax({

			type : "POST",
			url : "' . Url::to(['/asrama/kamar']) . '",
			data : {
				dataku : obj
			},
			success: function(data){
				var hasil = $.parseJSON(data);
				if(hasil.code == 200){
					viewkamar.html(hasil.asrama + " - " + hasil.kamar);
					Swal.fire(
					\'Good job!\',
					  hasil.msg,
					  \'success\'
					)
				}

				else{
					viewkamar.html(hasil.asrama + " - " + hasil.kamar);
					Swal.fire(
					\'Oops\',
					  hasil.msg,
					  \'error\'
					)
				}
				
			}
		});
		  }
		})
		
	});

	$("#fakultas_id").trigger("change");

	setTimeout(function(){
		$("#kode_prodi").val("' . (!empty($params['kode_prodi']) ? $params['kode_prodi'] : '-') . '");
	},500);

', \yii\web\View::POS_READY);

?>