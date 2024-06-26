<?php
use app\rbac\models\AuthItem;
use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\SimakKampus;

use yii\helpers\ArrayHelper;
use app\models\Perusahaan;


$list=Perusahaan::find()->all();
$listData=ArrayHelper::map($list,'id_perusahaan','nama');

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => 'form-user']); ?>

        <?= $form->field($user, 'username')->textInput(
                ['placeholder' => Yii::t('app', 'Create username'), 'autofocus' => true]) ?>
        
        <?= $form->field($user, 'email')->input('email', ['placeholder' => Yii::t('app', 'Enter e-mail')]) ?>
        <?= $form->field($user, 'uuid')->textInput() ?>
        <?php if ($user->scenario === 'create'): ?>

            <?= $form->field($user, 'password')->widget(PasswordInput::classname(), 
                ['options' => ['placeholder' => Yii::t('app', 'Create password')]]) ?>

        <?php else: ?>

            <?= $form->field($user, 'password')->widget(PasswordInput::classname(),
                     ['options' => ['placeholder' => Yii::t('app', 'Change password ( if you want )')]]) ?> 

        <?php endif ?>

    <div class="row">
    <div class="col-md-6">

        <?= $form->field($user, 'status')->dropDownList($user->statusList) ?>
        <?= $form->field($user, 'kampus')->dropDownList(\yii\helpers\ArrayHelper::map(SimakKampus::find()->all(),'kode_kampus','nama_kampus'),['prompt'=>'- Pilih Kelas -']) ?>

        <?php foreach (AuthItem::getRoles() as $item_name): ?>
            <?php $roles[$item_name->name] = $item_name->name ?>
        <?php endforeach ?>
        <?= $form->field($user, 'item_name')->dropDownList($roles) ?>
        <?= $form->field($user, 'perusahaan_id')->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..']);?>
    </div>
    </div>

    <div class="form-group">     
        <?= Html::submitButton($user->isNewRecord ? Yii::t('app', 'Create') 
            : Yii::t('app', 'Update'), ['class' => $user->isNewRecord 
            ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?= Html::a(Yii::t('app', 'Cancel'), ['user/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
 
</div>
