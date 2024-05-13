<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\SimakTes */
/* @var $form yii\widgets\ActiveForm */


$list_jenis_tes = \app\helpers\MyHelper::getJenisTes();

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
         <?= $form->field($model, 'tanggal_tes')->widget(DatePicker::className(), [
            'readonly' => true,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true,
            ]
        ]) ?>

        <?= $form->field($model, 'tahun')->widget(Select2::classname(), [
                'data' => $list_tahun,
                'options'=>['id'=>'tahun_akademik','placeholder'=>Yii::t('app','- Pilih Tahun Akademik -')],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])?>
        <?= $form->field($model, 'jenis_tes')->widget(Select2::classname(), [
                'data' => $list_jenis_tes,
                'options'=>['id'=>'list_jenis_tes','placeholder'=>Yii::t('app','- Pilih Jenis Tes -')],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])?>

        
        <?= $form->field($model, 'nama_tes')->textInput(['class'=>'form-control','maxlength' => true]) ?>

        <?= $form->field($model, 'penyelenggara')->textInput(['class'=>'form-control','maxlength' => true]) ?>


        
        <?= $form->field($model, 'skor_tes')->textInput() ?>

        <?= $form->field($model, 'file_path')->fileInput(['accept'=>'application/pdf']) ?>


            <?= Html::submitButton('Save', ['class' => 'btn btn-primary waves-effect']) ?>
    
    <?php ActiveForm::end(); ?>

</div>
