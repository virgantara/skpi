<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimakKampusKoordinator $model */
/** @var yii\widgets\ActiveForm $form */

$list_kampus = ArrayHelper::map(\app\models\SimakKampus::find()->all(),'id','nama_kampus');
?>

<div class="simak-kampus-koordinator-form">

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'form_validation',
        'enctype' => 'multipart/form-data'
    ]
]); ?>

    <?= $form->field($model, 'kampus_id')->dropDownList($list_kampus) ?>

    <?= $form->field($model, 'nama_cabang')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'niy')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nama_koordinator')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ttd_path')->fileInput(['accept'=>'image/*','class'=>'form-control']) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
