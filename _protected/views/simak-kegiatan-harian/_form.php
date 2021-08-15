<?php
use app\helpers\MyHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatanHarian */
/* @var $form yii\widgets\ActiveForm */

setlocale(LC_ALL, 'id_ID');
?>

<div class="col-md-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tahun_akademik')->dropDownList(ArrayHelper::map($listTahun,'tahun_id','nama_tahun')) ?>

    <div class="control-group">
        <label class="control-label" for="inputPatient">Jenis Kegiatan:</label>
        <div class="field desc">
            <?=Html::dropDownList('id_jenis_kegiatan','',ArrayHelper::map(\app\models\SimakJenisKegiatan::find()->all(),'id','nama_jenis_kegiatan'),['id'=>'id_jenis_kegiatan','class'=>'form-control','prompt'=>'-Pilih Jenis Kegiatan-']);?>
  
            <div class="help-block"></div>      
        </div>

    </div>

    <?= $form->field($model, 'kegiatan_id')->dropDownList([],['id' => 'kegiatan_id']) ?>
    
    <?= $form->field($model, 'kode_venue')->dropDownList(ArrayHelper::map(\app\models\Venue::find()->all(),'kode','nama'),['id'=>'venue','class'=>'form-control','prompt'=>'-Pilih Venue/Lokasi Acara-']);?>
    
    <?= $form->field($model, 'poin')->textInput(['id' => 'poin']) ?>

    <?= $form->field($model, 'jam_mulai')->widget(TimePicker::className(),[
        'options' => ['placeholder' => 'Select start operating time ...'],
        'pluginOptions' => [
            'showSeconds' => true,
            'secondStep' => 10, 
            'showMeridian' => false,
            'minuteStep' => 5,
  
        ]
    ]) ?>

    <?= $form->field($model, 'jam_selesai')->widget(TimePicker::className(),[
        'options' => ['placeholder' => 'Select end operating time ...'],
            'pluginOptions' => [
                'showSeconds' => true,
                'secondStep' => 10,
                  'showMeridian' => false,
                'minuteStep' => 5,
            ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJs("
    
$(\"#id_jenis_kegiatan\").change(function(){
    getListKegiatan($(this).val(),$('#kegiatan_id'));
});

$(\"#kegiatan_id\").change(function(){
    var obj = new Object
    obj.id = $(this).val()
    $.ajax({
       url: '".Url::to(['simak-kegiatan/ajax-get-kegiatan'])."',
       data: {
        dataPost : obj
       },
       type: \"POST\",
       async: true,
       success: function(json) {
            var res = $.parseJSON(json)
            $('#poin').val(res.nilai)
       }
    });
});



function getListKegiatan(jenis_kegiatan, kegiatan_selector){
    var obj = new Object;
    obj.id = jenis_kegiatan;
  
    $.ajax({
       url: '".Url::to(['simak-kegiatan/ajax-list-kegiatan'])."',
       data: {
        dataPost : obj
       },
       type: \"POST\",
       async: true,
       success: function(json) {
            var res = $.parseJSON(json)
            var row = '';
            kegiatan_selector.empty();
            $.each(res, function(i, obj){
              row += '<option  value=\"'+obj.id+'\">'+obj.name+'</option>';
            });

            kegiatan_selector.append(row);
            kegiatan_selector.val('".(!$model->isNewRecord ? $model->kegiatan_id : '')."');
            
       }
    });

  
}

$(\"#id_jenis_kegiatan\").val('".(!empty($model) && !$model->isNewRecord ? $model->kegiatan->id_jenis_kegiatan : '')."')

    
$(\"#id_jenis_kegiatan\").trigger('change');

", \yii\web\View::POS_READY);
