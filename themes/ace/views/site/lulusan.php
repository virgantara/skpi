<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Update Lulusan';
?>
<div class="asrama-form">
	<?php if (Yii::$app->session->hasFlash('warning')): ?>
	    <div class="alert alert-warning alert-dismissable">
	         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	         <h4><i class="icon fa fa-check"></i>Warning!</h4>
	         <?= Yii::$app->session->getFlash('warning') ?>
	    </div>
	<?php endif; ?>
	<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <h4><i class="icon fa fa-check"></i>Saved!</h4>
         <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>
    <?php $form = ActiveForm::begin((['options' => ['enctype' => 'multipart/form-data']])); ?>

      <?= $form->field($model, 'dataLulusan')->fileInput() ?>
  

    <div class="form-group">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
