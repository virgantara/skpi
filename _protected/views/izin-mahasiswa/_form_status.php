<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model app\models\IzinMahasiswa */
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
              <h4 class="widget-title lighter smaller">Data Perizinan</h4>
            </div>
            <div class="widget-body">
              <div class="widget-main">
                <div class="row">
                <label class="col-sm-2 control-label no-padding-right">Keperluan</label>
                <div class="col-sm-10">
                <?= $form->field($model,'keperluan_id')->radioList(['1'=>'Pribadi','2'=>'Kampus'],['class'=>'form-control'])->label(false) ?>
                <label class="error_diagnosis"></label>
                </div>
            </div>
  
            <div class="row">
                <label class="col-sm-2 control-label no-padding-right">Tanggal Pulang</label>
                <div class="col-sm-10">
                <?php 
                echo $form->field($model, 'tanggal_pulang')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Input tanggal pulang ...'],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd-mm-yyyy'
    ]
])->label(false);
                 ?>
                <label class="error_tanggal"></label>
                </div>
            </div>

                <div class="row">
                <label class="col-sm-2 control-label no-padding-right">Alasan</label>
                <div class="col-sm-10">
                <?= $form->field($model,'alasan')->textInput(['class'=>'form-control'])->label(false) ?>
                <label class="error_diagnosis"></label>
                </div>
            </div>
             <div class="row">
                <label class="col-sm-2 control-label no-padding-right">Status Izin</label>
                <div class="col-sm-10">
                <?= $form->field($model,'status')->dropDownList(['1'=>'Belum Pulang','2'=>'Sudah Pulang'])->label(false) ?>
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



    ', \yii\web\View::POS_READY);

?>