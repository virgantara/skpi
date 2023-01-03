<?php
use app\helpers\MyHelper;
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\date\DatePicker;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;

use app\models\Pelanggaran;
use app\models\Hukuman;

$list_rekomendasi = MyHelper::listRekomendasi();
/* @var $this yii\web\View */
/* @var $model app\models\RiwayatPelanggaran */
/* @var $form yii\widgets\ActiveForm */

$list_pelanggaran = ArrayHelper::map(Pelanggaran::find()->all(),'id',function($data){
						return '['.$data->kategori->nama.'] '.$data->kode.' - '.$data->nama;
					});
?>
<?php $form = ActiveForm::begin([
		'fieldConfig' => [
	        'options' => [
	            'tag' => false,
	        ],
	    ],
    	'options' => [
    		'enctype' => 'multipart/form-data',
    		'class' => 'form-horizontal',
    		'id' => 'form-pelanggaran'
    	]
    ]); ?>
    <?= $form->errorSummary($model,['header'=>'<div class="alert alert-danger">','footer'=>'</div>']);?>
<div class="row">
	
	<div class="col-sm-12 col-lg-2">
		<span class="profile-picture">
            <?php 
            $foto_path = '';
            if(!empty($mahasiswa->foto_path)){
                $foto_path = Url::to(['mahasiswa/foto','id'=>$mahasiswa->id]);
                echo  Html::a(Html::img($foto_path,['width'=>'240px']),'',['class'=>'popupModal','data-pjax'=>0,'data-item'=>Url::to(['mahasiswa/foto','id'=>$mahasiswa->id])]);
            }
                
            else{
                if($mahasiswa->jenis_kelamin == 'L')
                    $foto_path = $this->theme->baseUrl."/images/avatars/avatar4.png";
                else
                    $foto_path = $this->theme->baseUrl."/images/avatars/avatar3.png";
                echo '<img id="avatar" width="240px" class="editable img-responsive" alt="Alex\'s Avatar" src="'.$foto_path.'" />';
            }

             ?>
        </span>

	</div>
	<div class="col-sm-12 col-lg-4">
		<div class="widget-box widget-color-blue2">
	        <div class="widget-header">
	          <h4 class="widget-title lighter smaller">Biodata Diri</h4>
	        </div>
	        <div class="widget-body">
	          <div class="widget-main">
	          	<?= DetailView::widget([
			        'model' => $mahasiswa,
			        'attributes' => [
			            [
			            	'attribute' => 'nim_mhs',
			            	'label' => 'NIM',
			            	'contentOptions' => ['width'=>'75%']
			            ],
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
	<div class="col-sm-12 col-lg-6">
	      <div class="widget-box widget-color-blue2">
	        <div class="widget-header">
	          <h4 class="widget-title lighter smaller">Data Ortu</h4>
	        </div>
	        <div class="widget-body">
	          <div class="widget-main">
	          	<div class="table-responsive">
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
		        <h3>Data Pelanggaran</h3>
		        <hr>
				<div class="row">
			   		<label class="col-sm-3 control-label no-padding-right">Status Kasus *</label>
					<div class="col-sm-9">
					<?= $form->field($model,'status_kasus')->radioList(['0'=>'WAITING','1'=>'ON-PROCESS','2'=>'CLOSED'],['separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'])->label(false) ?>

					<label class="error_diagnosis"></label>
					</div>
				</div>
		          	<div class="row">
			   		<label class="col-sm-3 control-label no-padding-right">Pelanggaran *</label>
					<div class="col-sm-9">
					<?= $form->field($model, 'pelanggaran_id')->widget(Select2::classname(), [
			            'data' => $list_pelanggaran,
			            'options'=>['placeholder'=>Yii::t('app','- Pilih Pelanggaran -')],
			            'pluginOptions' => [
			                'allowClear' => true,
			            ],
			        ])->label(false) ?>

					
					<label class="error_diagnosis"></label>
					</div>
				</div>
				<div class="row">
			   		<label class="col-sm-3 control-label no-padding-right">Deskripsi Pelanggaran *</label>
					<div class="col-sm-9">
					 <?= $form->field($model, 'deskripsi')->widget(CKEditor::className(), [
				        'options' => ['rows' => 6],
				        'preset' => 'advance'
				    ])->label(false) ?>
					<label class="error_diagnosis"></label>
					</div>
				</div>
				
				<div class="row">
			   		<label class="col-sm-3 control-label no-padding-right">Tanggal Pelanggaran *</label>
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
			
			
	          </div>
	      </div>
	    </div>
	</div>
	<div class="col-sm-12 col-lg-6 col-md-6">
		<div class="widget-box widget-color-red">
        <div class="widget-header">
          <h4 class="widget-title lighter smaller">Data Rekomendasi</h4>
        </div>
        <div class="widget-body">
        	<div class="widget-main">
        	<h3>Hukuman</h3>
        	<hr>
			<div class="row">
				<label class="col-sm-3"></label>
				<div class="col-sm-9">
					<a href="javascript:void(0)" id="btn-add-hukuman" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Hukuman</a>
					<div class="help-block"></div>
				</div>
			</div>
		   	<?php
		   	$index =1 ;

		   	if(!$model->isNewRecord)
		   	{
		   		foreach($model->riwayatHukumen as $item)
		   		{
		   			
		   	?>
		   	
		   	<div class="row item-hukuman">
		   		<label class="col-sm-3 control-label no-padding-right">Hukuman <span class="tnumbering"><?=$index;?></span></label>
				<div class="col-sm-6">
				<input name="tindakan[]" value="<?=$item->hukuman->nama;?>"  class="tindakan form-control" placeholder="Type a new item" />
				<input name="tindakan_id[]" value="<?=$item->hukuman_id;?>"  type="hidden"/>
				<label class="error_diagnosis"></label>
				</div>
				<div class="col-sm-3"><a href="javascript:void(0)" class="btn btn-danger tremove"><i class="fa fa-trash"></i>&nbsp;Remove</a></div>
			</div>
		   	<?php
		   			$index++;
		   		}	
		   	}

		   	else{
		   	?>
		   	<div class="row item-hukuman"></div>
		   	<?php
		   	}
		   	?>
        	
        	<h3>Rekomendasi</h3>
			<hr>

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
				<?= $form->field($model,'rekomendasi_pimpinan')->dropDownList($list_rekomendasi,['separator' => '&nbsp;&nbsp;&nbsp;','prompt' => '- Pilih Rekomendasi -','id'=>'rekomendasi_pimpinan'])->label(false) ?>
				
				<label class="error_diagnosis"></label>
				</div>
			</div>

			<div class="row deskripsi_pddikti" style="display: none;margin-bottom: 5px;">
				<div class="alert alert-danger">
					<h2><i class="fa fa-warning"></i> Perhatian</h2>
					<p style="font-size: 1.2em;">
						Data di bawah ini akan disinkron ke PDDIKTI. <br>
						Perhatikan dalam penulisan:<br>
						<ul>
							<li>Kolom "Deskripsi Pelanggaran untuk Pelaporan PDDIKTI</li>
							<li>Tanggal SK</li>
							<li>Nomor SK</li>
						</ul>
					</p>
					<!-- <div class="help-block"></div> -->
				</div>
			</div>
			<div class="row deskripsi_pddikti" style="display: none;">
			   		<label class="col-sm-3 control-label no-padding-right">Deskripsi Pelanggaran untuk Pelaporan PDDIKTI</label>
					<div class="col-sm-9">
					<?= $form->field($model,'deskripsi_pddikti')->textInput(['class'=>'form-control'])->label(false) ?>
					
					<label class="error_diagnosis"></label>
					</div>
				</div>
        	</div>
        	<div class="row deskripsi_pddikti" >
		   		<label class="col-sm-3 control-label no-padding-right">Nomor SK</label>
				<div class="col-sm-9">
				<?= $form->field($model,'nomor_sk')->textInput(['class'=>'form-control','autocomplete'=>'off'])->label(false) ?>	
				<label class="error_diagnosis"></label>
				</div>
			</div>
			<div class="row deskripsi_pddikti" >
		   		<label class="col-sm-3 control-label no-padding-right">Tanggal SK</label>
				<div class="col-sm-9">
				<?php 
                echo $form->field($model, 'tanggal_sk')->widget(DatePicker::classname(), [
				    'options' => ['placeholder' => 'Input SK ...','autocomplete'=>'off'],
				    'pluginOptions' => [
				        'autoclose' => true,
				        'format' => 'yyyy-mm-dd',
				        'todayHighlight' => true
				    ]
				])->label(false);
                 ?>
				
				<label class="error_diagnosis"></label>
				</div>
			</div>
        	<div class="clearfix form-actions">
		        <div class="col-sm-12">
				<button class="btn btn-info btn-block btn-xlg" type="submit" id="btn-submit">
		            <i class="ace-icon fa fa-save bigger-110"></i>
		            Simpan
		          </button>
			  </div>
	      </div>
        </div>
    </div>
	</div>
</div>

	
      <?php ActiveForm::end(); ?>

 <?php
        yii\bootstrap\Modal::begin(['id' =>'modal','size'=>'modal-lg',]);
        echo '<div class="text-center">';
        echo '<img width="100%" id="img">';
        echo '</div>';
        yii\bootstrap\Modal::end();
    ?>
<?php

$this->registerJs(' 

let val = $("#rekomendasi_pimpinan option:selected").text()
if(val == "Dikeluarkan"){
	$(".deskripsi_pddikti").show()
}

else{
	$(".deskripsi_pddikti").hide()
}

$(document).on("change","#rekomendasi_pimpinan",function(e){
    e.preventDefault();
    $(".deskripsi_pddikti").hide()
    let val = $("#rekomendasi_pimpinan option:selected").text()
    if(val == "Dikeluarkan"){
    	$(".deskripsi_pddikti").show()
    }
})

$(document).on("click",".popupModal",function(e){
    e.preventDefault();
    var m = $("#modal").modal("show").find("#img");

    m.attr("src",$(this).data("item"))
})

function refreshNumbering(){
	
	$("span.tnumbering").each(function(i,obj){
		$(this).html(eval(i+1));
	});
}


$(document).on(\'click\',\'#btn-add-hukuman\', function(e) {

	var row = \'	<div class="row item-hukuman">\';
		row += \'<label class="col-sm-3 control-label no-padding-right">Hukuman <span class="tnumbering"></span></label>\';
	row += \'<div class="col-sm-6">\';
	row += \'<input name="tindakan[]" class="tindakan form-control" placeholder="Type a new item" />\';
	row += \'<input name="tindakan_id[]" type="hidden"/>\';
	row += \'<label class="error_tindakan"></label>\';
	row += \'</div>\';
	row += \'<div class="col-sm-3"><a href="javascript:void(0)" class="btn btn-danger tremove"><i class="fa fa-trash"></i>&nbsp;Remove</a></div>\';
	row += \'</div>\';  		      

	$(".item-hukuman:last").after(row)
	// $(this).parent().parent().parent().append(row);
	
	refreshNumbering();
	$(\'input.tindakan\').last().focus();
	
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

$(document).on(\'click\',\'#btn-submit\',function(e){
	e.preventDefault();
	Swal.fire({
		title: \'Do you want to save this?\',
		text: "You won\'t be able to revert this!",
		icon: \'warning\',
		showCancelButton: true,
		confirmButtonColor: \'#3085d6\',
		cancelButtonColor: \'#d33\',
		confirmButtonText: \'Yes, save now!\'
	}).then((result) => {
		if(result.isConfirmed)
			$("#form-pelanggaran").submit()
	})
	
});

    ', \yii\web\View::POS_READY);

?>