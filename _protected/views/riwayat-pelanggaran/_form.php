<?php
use app\helpers\MyHelper;
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use dosamigos\ckeditor\CKEditor;

use app\models\Pelanggaran;
use app\models\Hukuman;

$list_rekomendasi = MyHelper::listRekomendasi();
/* @var $this yii\web\View */
/* @var $model app\models\RiwayatPelanggaran */
/* @var $form yii\widgets\ActiveForm */


?>
<?php $form = ActiveForm::begin([
		'fieldConfig' => [
	        'options' => [
	            'tag' => false,
	        ],
	    ],
    	'options' => [
    		'enctype' => 'multipart/form-data',
    		'class' => 'form-horizontal'
    	]
    ]); ?>
    <?= $form->errorSummary($model,['header'=>'<div class="alert alert-danger">','footer'=>'</div>']);?>
<div class="row">
	<div class="col-sm-5">
	      <div class="widget-box widget-color-blue2">
	        <div class="widget-header">
	          <h4 class="widget-title lighter smaller">Data Ortu</h4>
	        </div>
	        <div class="widget-body">
	          <div class="widget-main">
	          	<table class="table table-striped">
					<tr>
						<th >No</th>
						<th  >Nama</th>
						<th  >Hubungan</th>
						<th  >Pendidikan</th>
						<th  >Pekerjaan</th>
						<th  >Penghasilan</th>
						<th  >HP</th>
					</tr>
					<?php 
					$listOrtu = $mahasiswa->simakMahasiswaOrtus;
					foreach($listOrtu as $q => $ortu)
					{
					?>
						<tr>
							<td><?=$q+1;?></td>
							<td><?=$ortu->nama;?></td>
							<td><?=ucwords(strtolower($ortu->hubungan));?></td>
							<td><?=$ortu->pendidikan0->label;?></td>
							<td><?=$ortu->pekerjaan0->label;?></td>
							<td><?=$ortu->penghasilan0->label;?></td>
							<td><?=$ortu->hp;?></td>
						</tr>
								
					<?php 
					}
					?>
				</table>
	          </div>
	      </div>
	  </div>
	</div>
	<div class="col-sm-7">
		<div class="widget-box widget-color-blue2">
	        <div class="widget-header">
	          <h4 class="widget-title lighter smaller">Biodata Diri</h4>
	        </div>
	        <div class="widget-body">
	          <div class="widget-main">
	          	<?= DetailView::widget([
			        'model' => $mahasiswa,
			        'attributes' => [
			            'nim_mhs',
			            'ktp',
			            'nama_mahasiswa',
			            'tempat_lahir',
			            'tgl_lahir',
			            'jenis_kelamin',
			   
			            
			        ],
			    ]) ?>
	          </div>
	      </div>
	  	</div>

		
   
	</div>
</div>
<div class="row">
	<div class="col-sm-12 col-lg-6 col-md-6">
	      <div class="widget-box widget-color-red">
	        <div class="widget-header">
	          <h4 class="widget-title lighter smaller">Data Hukuman</h4>
	        </div>
	        <div class="widget-body">
	          	<div class="widget-main">
		          	
				<div class="row">
			   		<label class="col-sm-3 control-label no-padding-right">Status Kasus</label>
					<div class="col-sm-9">
					<?= $form->field($model,'status_kasus')->radioList(['0'=>'WAITING','1'=>'ON-PROCESS','2'=>'CLOSED'])->label(false) ?>

					<label class="error_diagnosis"></label>
					</div>
				</div>
		          	<div class="row">
			   		<label class="col-sm-3 control-label no-padding-right">Pelanggaran</label>
					<div class="col-sm-9">
					<?= $form->field($model,'pelanggaran_id')->dropDownList(ArrayHelper::map(Pelanggaran::find()->all(),'id',function($data){
						return '['.$data->kategori->nama.'] '.$data->kode.' - '.$data->nama;
					}),['class'=>'form-control'])->label(false) ?>
					<label class="error_diagnosis"></label>
					</div>
				</div>
				<div class="row">
			   		<label class="col-sm-3 control-label no-padding-right">Deskripsi Pelanggaran</label>
					<div class="col-sm-9">
					 <?= $form->field($model, 'deskripsi')->widget(CKEditor::className(), [
				        'options' => ['rows' => 6],
				        'preset' => 'advance'
				    ])->label(false) ?>
					<label class="error_diagnosis"></label>
					</div>
				</div>
				
				<div class="row">
			   		<label class="col-sm-3 control-label no-padding-right">Tanggal Pelanggaran</label>
					<div class="col-sm-9">
						<?= $form->field($model, 'tanggal')->widget(DateTimePicker::classname(), [
				            'options' => ['placeholder' => 'Input tanggal & jam pelanggaran ...'],
				            'pluginOptions' => [
				                'autoclose' => true,
				                'todayHighlight' => true,
				                'format' => 'yyyy-mm-dd hh:mm:ss'
				            ]
				        ])->label(false); ?>

					
					
					<label class="error_tanggal"></label>
					</div>
				</div>
					<div class="row">
			   		<label class="col-sm-3 control-label no-padding-right">Pelapor</label>
					<div class="col-sm-9">
					<?= $form->field($model,'pelapor')->textInput(['class'=>'form-control'])->label(false) ?>
					<label class="error_diagnosis"></label>
					</div>
				</div>
				<div class="row">
			   		<label class="col-sm-3 control-label no-padding-right">Bukti/Foto<br>(max 2MB and filetype: jpg, jpeg, png)</label>
					<div class="col-sm-9">
					<?= $form->field($model,'bukti')->fileInput(['accept'=>'image/*','class'=>'form-control'])->label(false) ?>
					<label class="error_diagnosis"></label>
					</div>
				</div>
				<div class="row">
			   		<label class="col-sm-3 control-label no-padding-right">Surat Pernyataan<br>(PDF only and maxsize 3MB) </label>
					<div class="col-sm-9">
					<?= $form->field($model,'surat_pernyataan')->fileInput(['accept'=>'application/pdf','class'=>'form-control'])->label(false) ?>

					<label class="error_diagnosis"></label>
					</div>
				</div>
		   	<?php
		   	$index =1 ;

		   	if(!$model->isNewRecord)
		   	{
		   		foreach($model->riwayatHukumen as $item)
		   		{
		   			
		   	?>
		   	
		   	<div class="row">
		   		<label class="col-sm-3 control-label no-padding-right">Hukuman <span class="tnumbering"><?=$index;?></span></label>
				<div class="col-sm-8">
				<input name="tindakan[]" value="<?=$item->hukuman->nama;?>"  class="tindakan form-control" placeholder="Type and Enter to add new item" />
				<input name="tindakan_id[]" value="<?=$item->hukuman_id;?>"  type="hidden"/>
				<label class="error_diagnosis"></label>
				</div>
				<div class="col-sm-3"><a href="javascript:void(0)" class="btn btn-danger tremove"><i class="fa fa-trash"></i>&nbsp;Remove</a></div>
			</div>
		   	<?php
		   			$index++;
		   		}	
		   	}
		   	?>
			<div class="row">
		   		<label class="col-sm-3 control-label no-padding-right">Hukuman <span class="tnumbering"><?=$index;?></span></label>
				<div class="col-sm-9">
				<input name="tindakan[]" class="tindakan form-control" placeholder="Type and Enter to add new item" />
				<input name="tindakan_id[]" type="hidden"/>
				<label class="error_diagnosis"></label>
				</div>
			</div>
			<div class="row">
		   		<label class="col-sm-3 control-label no-padding-right">Rekomendasi DKP</label>
				<div class="col-sm-9">
				<?= $form->field($model,'rekomendasi_dkp')->dropDownList($list_rekomendasi,['separator' => '&nbsp;&nbsp;&nbsp;','prompt' => '- Pilih Rekomendasi -'])->label(false) ?>
				
				<label class="error_diagnosis"></label>
				</div>
			</div>
			<div class="row">
		   		<label class="col-sm-3 control-label no-padding-right">Rekomendasi Pimpinan</label>
				<div class="col-sm-9">
				<?= $form->field($model,'rekomendasi_pimpinan')->dropDownList($list_rekomendasi,['separator' => '&nbsp;&nbsp;&nbsp;','prompt' => '- Pilih Rekomendasi -'])->label(false) ?>
				
				<label class="error_diagnosis"></label>
				</div>
			</div>
			<div class="row">
			   		<label class="col-sm-3 control-label no-padding-right">Deskripsi Pelanggaran untuk Pelaporan PDDIKTI</label>
					<div class="col-sm-9">
					<?= $form->field($model,'deskripsi_pddikti')->textInput(['class'=>'form-control'])->label(false) ?>
					
					<label class="error_diagnosis"></label>
					</div>
				</div>
	          </div>
	      </div>
	    </div>
	</div>

</div>

	<div class="clearfix form-actions">
        <div class="col-sm-offset-2 col-sm-9">
		<button class="btn btn-info" type="submit">
            <i class="ace-icon fa fa-check bigger-110"></i>
            Simpan
          </button>
	  </div>
      </div>
      <?php ActiveForm::end(); ?>
<?php

$this->registerJs(' 

function refreshNumbering(){
	
	$("span.tnumbering").each(function(i,obj){
		$(this).html(eval(i+1));
	});
}


$(document).on(\'keydown\',\'input.tindakan\', function(e) {
 	var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;

	if (key == 13) {
		var row = \'	<div class="row">\';
   		row += \'<label class="col-sm-3 control-label no-padding-right">Hukuman <span class="tnumbering"></span></label>\';
		row += \'<div class="col-sm-8">\';
		row += \'<input name="tindakan[]" class="tindakan form-control" placeholder="Type and Enter to add new item" />\';
		row += \'<input name="tindakan_id[]" type="hidden"/>\';
		row += \'<label class="error_tindakan"></label>\';
		row += \'</div>\';
		row += \'<div class="col-sm-3"><a href="javascript:void(0)" class="btn btn-danger tremove"><i class="fa fa-trash"></i>&nbsp;Remove</a></div>\';
		row += \'</div>\';  		      

		$(this).parent().parent().parent().append(row);
		
		refreshNumbering();
		$(\'input.tindakan\').last().focus();
	}
});


$(document).bind("keyup.autocomplete",function(){
	$(\'.tindakan\').autocomplete({
      minLength:1,
      select:function(event, ui){
       
        $(this).next().val(ui.item.id);
                
      },
      
      focus: function (event, ui) {
      	$(".ui-helper-hidden-accessible").hide();
        $(this).next().val(ui.item.id);

      },
      source:function(request, response) {
        $.ajax({
                url: "'. Url::to(["api/get-hukuman"]).'",
                dataType: "json",
                data: {
                    term: request.term,
                    
                },
                success: function (data) {
                    response(data);
                }
            })
        },
       
  }); 
});


$(document).on(\'click\',\'a.tremove\',function(e){
	e.preventDefault();
	
	$(this).parent().parent().remove();
	refreshNumbering();
});

    ', \yii\web\View::POS_READY);

?>