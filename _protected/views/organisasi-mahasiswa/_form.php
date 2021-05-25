<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

$listOrganisasi = \app\models\Organisasi::find()->all();
$listDosen = \app\models\SimakMasterdosen::find()->all();

/* @var $this yii\web\View */
/* @var $model app\models\OrganisasiMahasiswa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="organisasi-mahasiswa-form">

    <?php $form = ActiveForm::begin(); ?>
    
     <?= $form->field($model, 'tahun_akademik')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\app\models\SimakTahunakademik::getList(),'tahun_id','nama_tahun'),

            'options'=>['id'=>'tahun_akademik','placeholder'=>Yii::t('app','- Pilih Tahun Akademik -')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>
     <?= $form->field($model, 'organisasi_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map($listOrganisasi,'id','nama'),

            'options'=>['id'=>'propinsi_id','placeholder'=>Yii::t('app','- Pilih Organisasi -')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>
    <?= $form->field($model, 'pembimbing_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map($listDosen,'id','nama_dosen'),

            'options'=>['id'=>'pembimbing_id','placeholder'=>Yii::t('app','- Pilih Dosen -')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>

     <?= $form->field($model, 'tanggal_mulai')->widget(DatePicker::className(),[
        // 'readonly' => true,
        'pluginOptions' => [
            'autoclose'=>true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd'
        ]
     ])
     ?>
     <?= $form->field($model, 'tanggal_selesai')->widget(DatePicker::className(),[
        // 'readonly' => true,
        'pluginOptions' => [
            'autoclose'=>true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd'
        ]
     ])
     ?>
 
    <?= $form->field($model, 'no_sk')->textInput(['maxlength' => true]) ?>


     <?= $form->field($model, 'tanggal_sk')->widget(DatePicker::className(),[
        // 'readonly' => true,
        'pluginOptions' => [
            'autoclose'=>true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd'
        ]
     ])
     ?>
   
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php

$this->registerJs("
    
", \yii\web\View::POS_READY);
