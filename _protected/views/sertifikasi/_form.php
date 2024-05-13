<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\SimakSertifikasi */
/* @var $form yii\widgets\ActiveForm */

$list_jenis_sertifikasi = \app\helpers\MyHelper::getJenisSertifikasi();

$list_tahun = \app\models\SimakTahunakademik::find()->orderBy(['tahun_id' => SORT_DESC])->cache(60 * 10)->all();

$list_tahun = ArrayHelper::map($list_tahun,'tahun_id','nama_tahun');
?>

<div class="body">

    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'form_validation',
        ]
    ]); ?>
<?php

    echo $form->errorSummary($model,['header'=>'<div class="alert alert-danger">','footer'=>'</div>']);
?>
         
            <?= $form->field($model, 'jenis_sertifikasi')->dropDownList($list_jenis_sertifikasi,['class'=>'form-control','prompt' => '- Pilih Jenis Sertifikasi -']) ?>
            <?= $form->field($model, 'lembaga_sertifikasi')->textInput(['class'=>'form-control','maxlength' => true]) ?>
            <?= $form->field($model, 'nomor_registrasi_sertifikasi')->textInput(['class'=>'form-control','maxlength' => true]) ?>
            <?= $form->field($model, 'predikat')->textInput(['class'=>'form-control','maxlength' => true]) ?>
            <?= $form->field($model, 'tahun_sertifikasi')->widget(Select2::classname(), [
                    'data' => $list_tahun,
                    'options'=>['id'=>'tahun_akademik','placeholder'=>Yii::t('app','- Pilih Tahun Akademik -')],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])?>
            <?= $form->field($model, 'tmt_sertifikasi')->widget(DatePicker::className(), [
                'readonly' => true,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                ]
            ]) ?>
            <?= $form->field($model, 'tst_sertifikasi')->widget(DatePicker::className(), [
                'readonly' => true,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                ]
            ]) ?>

            
            <?= $form->field($model, 'file_path')->fileInput(['accept'=>'application/pdf']) ?>
            
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary waves-effect']) ?>
    
    <?php ActiveForm::end(); ?>

</div>
