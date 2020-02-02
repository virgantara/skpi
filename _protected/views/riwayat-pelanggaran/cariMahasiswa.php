<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\RiwayatPelanggaran */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', Yii::$app->name);
?>
<div class="row">
<div class="col-xs-12">

    <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>

    <div class="form-group">
    	 <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Ketik Nama Mahasiswa atau NIM</label>
    	  <div class="col-sm-9">
    	  	<input name="nama_mahasiswa" class="form-control"  type="text" id="nama_mahasiswa" />

    	  	<?= $form->field($model, 'nim')->hiddenInput(['id'=>'nim'])->label(false) ?>
    	  </div>
    </div>
    <div class="clearfix form-actions">

		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-info" type="submit">
				<i class="ace-icon fa fa-search bigger-110"></i>
				Cari
			</button>
		</div>
									
    </div>

           
    <?php 
            AutoComplete::widget([
    'name' => 'nama_mahasiswa',
    'id' => 'nama_mahasiswa',
    'clientOptions' => [
    'source' => Url::to(['api/ajax-cari-mahasiswa']),
    'autoFill'=>true,
    'minLength'=>'1',
    'select' => new JsExpression("function( event, ui ) {
        $('#nim').val(ui.item.id);
        
     }")],
    'options' => [
        // 'size' => '40'
    ]
 ]); 
 ?>

    <?php ActiveForm::end(); ?>

</div>
</div>