<?php 
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

$this->title = 'Registrasi';
$this->params['breadcrumbs'][] = $this->title;
$model->kampus = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['kampus'] : '';
$model->kode_fakultas = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['kode_fakultas'] : '';

$model->kode_prodi = !empty($_GET['SimakMastermahasiswa']['kode_prodi']) ? $_GET['SimakMastermahasiswa']['kode_prodi'] : '';

$model->status_aktivitas = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['status_aktivitas'] : '';

$model->tahun_masuk = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['tahun_masuk'] : '';

$tahun_akademik = !empty($_GET['tahun_akademik']) ? $_GET['tahun_akademik'] : '';
 $listTahun = \app\models\SimakTahunakademik::find()->where(['>=','tahun_id', '2014'])->orderBy(['tahun_id' => SORT_DESC])->all();
$list_tahun = ArrayHelper::map($listTahun,'tahun_id','nama_tahun');

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
			'action' => Url::to(['simak-kegiatan/bulk-registration','id' => $kegiatan->id]),
			'options' => [


				'class' => 'form-horizontal'
			]
		]); ?>
		<?= $form->errorSummary($model,['header'=>'<div class="alert alert-danger">','footer'=>'</div>']) ?>

		<div class="form-group">
			<div class="col-sm-offset-3">
				<h3><?=$kegiatan->nama_kegiatan;?> [<?=$kegiatan->nilai;?>]</h3>
				<h3><?=$kegiatan->jenisKegiatan->nama_jenis_kegiatan;?> [<?=$kegiatan->jenisKegiatan->nilai_minimal;?> - <?=$kegiatan->jenisKegiatan->nilai_maximal;?>]</h3>
			</div>
		</div>
		<div class="form-group" >
			<label class="col-sm-3 control-label no-padding-right">Kelas</label>
			<div class="col-sm-9 col-lg-4">
				<?= $form->field($model,'kampus')->dropDownList(ArrayHelper::map(\app\models\SimakKampus::find()->all(),'id',function($data){
					return $data->kode_kampus.' - '.$data->nama_kampus;
				}),['class'=>'form-control','id' => 'kampus'])->label(false) ?>
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
			<?= $form->field($model,'status_aktivitas')->dropDownList(['A'=>'Aktif','N'=>'Non Aktif','C'=>'Cuti','L'=>'Lulus'],['class'=>'form-control','id'=>'status_aktivitas'])->label(false) ?>
			</div>
		</div>
		<div class="form-group" >
			<label class="col-sm-3 control-label no-padding-right">Tahun Akademik</label>
			<div class="col-sm-9 col-lg-4">
				<?= Html::dropDownList('tahun_akademik',$tahun_akademik,$list_tahun,['id'=>'tahun_akademik','class'=>'form-control','prompt'=>'- Pilih Tahun Akademik -']) ?>
			</div>
		</div>
		<div class="form-group" >
			<label class="col-sm-3 control-label no-padding-right">Tahun Masuk</label>
			<div class="col-sm-9 col-lg-4">
				<?= $form->field($model,'tahun_masuk')->textInput(['class'=>'form-control','id'=>'tahun_masuk'])->label(false) ?>
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
						<th class="text-center">Kehadiran<br><input type="checkbox" id="checkAll" class="form-control"></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i=0;
					if(!empty($results))
					{

						foreach($results as $m)
						{

							$keg = \app\models\SimakKegiatanMahasiswa::find()->where([
								'nim' => $m->nim_mhs,
								'id_kegiatan' => $kegiatan->id,
								'tahun_akademik' => $tahun_akademik
							])->one();
		                    $value = !empty($keg) ? '1' : '0';
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
								<?= Html::checkbox('kehadiran',$value,['class'=>'form-control list_kehadiran','data-item'=>$m->nim_mhs,'data-event'=>$kegiatan->id]);?>
								
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

$("#checkAll").click(function(){
    $(\'input.list_kehadiran\').not(this).prop(\'checked\', this.checked);

    $(".list_kehadiran").each(function(i,obj){
    	var nim = $(this).data("item")
    	var kegiatan_id = "'.$kegiatan->id.'"
		var tahun_akademik = $("#tahun_akademik").val()
		if(this.checked)
			register(nim, kegiatan_id, tahun_akademik)
		else
			unregister(nim, kegiatan_id, tahun_akademik)
    })
});

$(".list_kehadiran").click(function(){
    
	var nim = $(this).data("item")
	var kegiatan_id = "'.$kegiatan->id.'"
	var tahun_akademik = $("#tahun_akademik").val()
	if(this.checked)
		register(nim, kegiatan_id, tahun_akademik)
	else
		unregister(nim, kegiatan_id, tahun_akademik)
    
});

function unregister(nim, kegiatan_id, tahun_akademik){
    var obj = new Object
    obj.nim = nim
    obj.kegiatan_id = kegiatan_id
    obj.tahun_akademik = tahun_akademik
    $.ajax({
        type: \'POST\',
        url: "'.\yii\helpers\Url::to(['simak-kegiatan/ajax-unregister']).'",
        data: {
            dataPost : obj
        },
        async: true,
        error : function(e){
            Swal.fire({
                  title: \'Oops!\',
                  icon: \'error\',
                  text: e.responseText
                })
        },
        success: function (data) {
            var data = $.parseJSON(data)
            if(data.code == 200){
                // Swal.fire({
                //     title: \'Yeay!\',
                //     icon: \'success\',
                //     timer: 1000,
                //     timerProgressBar: true,
                //     text: data.message,
                    
                // }).
                // then(res=>{
                    
                // })  
            }

            else{
                Swal.fire({
                  title: \'Oops!\',
                  icon: \'error\',
                  text: data.message
                })
            }
            
        }
    })
}

function register(nim, kegiatan_id, tahun_akademik){
    var obj = new Object
    obj.nim = nim
    obj.kegiatan_id = kegiatan_id
    obj.tahun_akademik = tahun_akademik
    $.ajax({
        type: \'POST\',
        url: "'.\yii\helpers\Url::to(['simak-kegiatan/ajax-register']).'",
        data: {
            dataPost : obj
        },
        async: true,
        error : function(e){
            Swal.fire({
                  title: \'Oops!\',
                  icon: \'error\',
                  text: e.responseText
                })
        },
        success: function (data) {
            var data = $.parseJSON(data)
            if(data.code == 200){
                // Swal.fire({
                //     title: \'Yeay!\',
                //     icon: \'success\',
                //     timer: 1000,
                //     timerProgressBar: true,
                //     text: data.message,
                    
                // }).
                // then(res=>{
                    
                // })  
            }

            else{
                Swal.fire({
                  title: \'Oops!\',
                  icon: \'error\',
                  text: data.message
                })
            }
            
        }
    })
}

$("#fakultas_id").trigger("change");

setTimeout(function(){
	$("#kode_prodi").val("'.(!empty($params['kode_prodi'])? $params['kode_prodi'] : '-').'");
},500);

', \yii\web\View::POS_READY);

?>