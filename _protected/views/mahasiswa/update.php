<?php


use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\SimakPilihan;
use app\models\SimakPropinsi;

use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\SimakMastermahasiswa */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Update Mahasiswa';

$negara = !empty($model->konsulat0) ? $model->konsulat0->country->name : '';
$states = !empty($model->konsulat0) ? $model->konsulat0->state_id : '';
?>
<?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'form_validation',
        ]
    ]); ?>

    
<?php
    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
      echo '<div class="flash alert alert-' . $key . '">' . $message . '<button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button></div>';
    }

    echo $form->errorSummary($model,['header'=>'<div class="alert alert-danger">','footer'=>'</div>']);
?>

<div class="row">
<div class="col-xs-12 col-lg-6">
    <div class="panel">
      <div class="panel-heading">
              <h3>      Data Akademik</h3>
                
            </div>
            <div class="panel-body ">

                 <div class="form-group">
            <label class="control-label no-padding-right">Kelas</label>
        <div class="">
            <?= $form->field($model, 'kampus')->dropDownList(ArrayHelper::map(\app\models\SimakKampus::find()->all(),'kode_kampus','nama_kampus'),['class'=>'form-control','maxlength' => true,'disabled' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="control-label no-padding-right">Kode fakultas</label>
        <div class="">
            <?= $form->field($model, 'kode_fakultas')->dropDownList(ArrayHelper::map(\app\models\SimakMasterfakultas::find()->all(),'kode_fakultas','nama_fakultas'),['class'=>'form-control','disabled' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="control-label no-padding-right">Kode prodi</label>
        <div class="">
            <?= $form->field($model, 'kode_prodi')->dropDownList(ArrayHelper::map(\app\models\SimakMasterprogramstudi::find()->all(),'kode_prodi','nama_prodi'),['class'=>'form-control','disabled' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="control-label no-padding-right">Kode jenjang studi</label>
        <div class="">
            <?= $form->field($model, 'kode_jenjang_studi')->dropDownList(ArrayHelper::map(\app\models\SimakPilihan::find()->where(['kode'=>'04'])->all(),'value','label'),['class'=>'form-control','disabled' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="control-label no-padding-right">Nim mhs</label>
        <div class="">
            <?= $form->field($model, 'nim_mhs')->textInput(['class'=>'form-control','disabled' => true])->label(false) ?>

            
            </div>
        </div>
                <div class="form-group">
            <label class="control-label no-padding-right">Nama mahasiswa</label>
        <div class="">
            <?= $form->field($model, 'nama_mahasiswa')->textInput(['class'=>'form-control','disabled' => true])->label(false) ?>

            
            </div>
        </div>

      
        </div>
    </div>

</div>
<div class="col-xs-12 col-lg-6">
    <div class="panel">
      <div class="panel-heading">
                   <h3> Data Kepengasuhan</h3>
                
            </div>
            <div class="panel-body ">




                
        <div class="form-group">
            <label class="control-label no-padding-right">Countries</label>
        <div class="">
            <?= Html::dropDownList('countries',$negara,ArrayHelper::map(\app\models\Countries::find()->all(),'id','name'),['id'=>'negara','class'=>'form-control','prompt'=>'- Choose a Country -']);?>

            
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label no-padding-right">States</label>
        <div class="">
            <?= Html::dropDownList('states',$states,[],['id'=>'states','prompt'=>'- Choose a state -']);?>

            
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label no-padding-right">Cities</label>
        <div class="">
            <?php echo $form->field($model,'konsulat')->dropDownList([],['prompt'=>'- Choose a city -','class'=>'','id' => 'konsulat'])->label(false);?>

            
            </div>
        </div> 
         <?= Html::submitButton('<i class="fa fa-save"></i> Simpan', ['class' => 'btn btn-primary btn-lg']) ?>
        </div>
    </div>

</div>
</div>
<?php ActiveForm::end(); ?>


<?php

$this->registerJs(' 

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
        $("#kode_prodi").val('.$model->kode_prodi.');
    },500);

    setInterval(function(){
        $(\'.numbering\').each(function(i, obj) {
            $(this).html(i+1);
        });
    },500);

', \yii\web\View::POS_READY);

?>

    
       
              
           
    
        
                
        
