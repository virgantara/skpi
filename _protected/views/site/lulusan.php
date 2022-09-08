<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="asrama-form">

    <?php $form = ActiveForm::begin((['options' => ['enctype' => 'multipart/form-data']])); ?>

      <?= $form->field($model, 'dataLulusan')->fileInput() ?>
  

    <div class="form-group">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
