<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model app\models\SimakSertifikasi */

$this->title = 'Validasi Prestasi';
$this->params['breadcrumbs'][] = ['label' => 'Prestasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$list_status_validasi = \app\helpers\MyHelper::getStatusValidasi();

?>
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h3><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'form_validation',
        ]
    ]); ?>


    <?= $form->field($model, 'status_validasi')->dropDownList($list_status_validasi)?>
    <?= $form->field($model, 'catatan')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'advance',
        'clientOptions' => [
            'enterMode' => 2,
            'forceEnterMode' => false,
            'shiftEnterMode' => 1
        ]
    ]) ?>
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary waves-effect']) ?>
    
    <?php ActiveForm::end(); ?>
           </div>
        </div>
    </div>
</div>
