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
            <label class="control-label no-padding-right">Kampus</label>
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
            <?php echo DepDrop::widget([
                'name' => 'states',
                'options' => [
                    'class'=> 'states',
                    'id'=>'states'
                ],
                'pluginOptions'=>[
                    'depends'=>['negara'],
                    'initialize' => true,
                    'placeholder' => '...Choose a state...',
                    'url' => Url::to(['/states/states-list']),

                ]   
            ])?>

            
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label no-padding-right">Cities</label>
        <div class="">
            <?php echo $form->field($model,'konsulat')->widget(DepDrop::className(),[
                'name' => 'cities',
                'options' => [
                    'class'=> 'cities'
                ],
                'pluginOptions'=>[
                    'depends'=>['states'],
                    'initialize' => true,
                    'placeholder' => '...Choose a city...',
                    'url' => Url::to(['/cities/cities-list']),

                ]   
            ])->label(false);?>

            
            </div>
        </div> 
         <?= Html::submitButton('<i class="fa fa-save"></i> Simpan', ['class' => 'btn btn-primary btn-lg']) ?>
        </div>
    </div>

</div>
</div>
<?php ActiveForm::end(); ?>


    
       
              
           
    
        
                
        
