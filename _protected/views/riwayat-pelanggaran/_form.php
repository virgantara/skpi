<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use app\models\Pelanggaran;
use app\models\Hukuman;

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
    		'class' => 'form-horizontal'
    	]
    ]); ?>
<div class="row">
	<div class="col-sm-12">
	      <div class="widget-box widget-color-blue2">
	        <div class="widget-header">
	          <h4 class="widget-title lighter smaller">Data Hukuman</h4>
	        </div>
	        <div class="widget-body">
	          <div class="widget-main">
	          	<div class="row">
		   		<label class="col-sm-2 control-label no-padding-right">Pelanggaran</label>
				<div class="col-sm-10">
				<?= $form->field($model,'pelanggaran_id')->dropDownList(ArrayHelper::map(Pelanggaran::find()->all(),'id','nama'),['class'=>'form-control'])->label(false) ?>
				<label class="error_diagnosis"></label>
				</div>
			</div>
		   	<?php
		   	$index = 0;
		   	?>
			<div class="row">
		   		<label class="col-sm-2 control-label no-padding-right">Hukuman <span class="tnumbering"><?=$index+1;?></span></label>
				<div class="col-sm-10">
				<input name="tindakan[]" class="tindakan form-control" placeholder="Type and Enter to add new item" />
				<input name="tindakan_id[]" type="hidden"/>
				<label class="error_diagnosis"></label>
				</div>
			</div>
	          </div>
	      </div>
	    </div>
	</div>

</div>

	<div class="clearfix form-actions">
        <div class="col-sm-offset-2 col-sm-10">
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
   		row += \'<label class="col-sm-2 control-label no-padding-right">Hukuman <span class="tnumbering"></span></label>\';
		row += \'<div class="col-sm-8">\';
		row += \'<input name="tindakan[]" class="tindakan form-control" placeholder="Type and Enter to add new item" />\';
		row += \'<input name="tindakan_id[]" type="hidden"/>\';
		row += \'<label class="error_tindakan"></label>\';
		row += \'</div>\';
		row += \'<div class="col-sm-2"><a href="javascript:void(0)" class="btn btn-danger tremove"><i class="fa fa-trash"></i>&nbsp;Remove</a></div>\';
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