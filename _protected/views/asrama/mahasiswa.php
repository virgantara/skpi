<?php 
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

$this->title = 'Asrama';
$this->params['breadcrumbs'][] = $this->title;
$model->kampus = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['kampus'] : '';
$model->kode_fakultas = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['kode_fakultas'] : '';

$model->kode_prodi = !empty($_GET['SimakMastermahasiswa']) ? $_GET['SimakMastermahasiswa']['kode_prodi'] : '';
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
    	'options' => [
    		
    		'action' => Url::to(['asrama/mahasiswa']),
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



	<div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">

          <button class="btn btn-info" type="submit" name="btn-search">
            <i class="ace-icon glyphicon glyphicon-search bigger-110"></i>
            Tampilkan Mahasiswa
          </button>
          <button class="btn btn-success" type="submit" name="btn-export">
            <i class="ace-icon glyphicon glyphicon-download-alt bigger-110"></i>
            Export XLS
          </button>
      
		</div>
	</div>
	<table id="tabel_mhs" class="table table-bordered table-hovered table-striped table-responsive">
	<thead>
	<tr>
		<th>No</th>
		<th>NIM</th>
		<th>Nama Mahasiswa</th>
		<th>JK</th>
		<th>Semester</th>
		<th>Asrama</th>
		<th>Kamar</th>
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
	
		<strong>
			<?=!empty($m->kamar) ? $m->kamar->namaAsrama: '';?>
		</strong>
		
		</td>
		<td>
	
		<strong>
			<?=!empty($m->kamar) ? $m->kamar->nama : '';?>
		</strong>
		
		</td>
	</tr>
	<?php 
}
}
	?>
</tbody>
</table>

	 <?php ActiveForm::end(); ?>
	</div>
</div>
<?php

$this->registerJs(' 

	$("#fakultas_id").trigger("change");

	setTimeout(function(){
		$("#kode_prodi").val('.$params['kode_prodi'].');
	},500)
	
    ', \yii\web\View::POS_READY);

?>