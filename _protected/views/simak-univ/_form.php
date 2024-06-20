<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
/** @var yii\web\View $this */
/** @var app\models\SimakUniv $model */
/** @var yii\widgets\ActiveForm $form */

$list_jenjang = \app\models\SimakPilihan::find()->where(['kode' => '04'])->all();
$list_jenjang = ArrayHelper::map($list_jenjang,'id','label');
?>

<div class="simak-univ-form">

    <?php $form = ActiveForm::begin(); ?>
    <table class="table">
        <tr>
            <td colspan="2"><?= $form->field($model, 'pilihan_id')->dropDownList($list_jenjang,['prompt' => '- Pilih Jenjang -'])?></td>
            
        </tr>
        <tr>
            <td><?= $form->field($model, 'header')->textInput(['maxlength' => true])?></td>
            <td><?= $form->field($model, 'header_en')->textInput(['maxlength' => true])?></td>
        </tr>
        <tr>
            <td>
                <?= $form->field($model, 'nama')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'advance',
                    'clientOptions' => [
                        'enterMode' => 2,
                        'forceEnterMode' => false,
                        'shiftEnterMode' => 1
                    ]
                ]) ?>
            </td>
            <td>
                <?= $form->field($model, 'nama_en')->widget(CKEditor::className(), [
                'options' => ['rows' => 6],
                'preset' => 'advance',
                'clientOptions' => [
                    'enterMode' => 2,
                    'forceEnterMode' => false,
                    'shiftEnterMode' => 1
                ]
            ]) ?>
            </td>
        </tr>
    </table>
    
    
    
    

    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
