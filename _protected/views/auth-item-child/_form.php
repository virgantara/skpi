<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\rbac\models\AuthItem;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItemChild */
/* @var $form yii\widgets\ActiveForm */
$listAuth1 = AuthItem::find()->where(['type' => 1])->orderBy(['name' => SORT_ASC])->all();
$listAuth = ArrayHelper::map($listAuth1, 'name', 'name');
?>

<div class="auth-item-child-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent', ['options' => ['tag' => false]])->dropDownList($listAuth, ['prompt' => '- pilih parent -']) ?>

    <?= $form->field($model, 'child', ['options' => ['tag' => false]])->dropDownList($listAuth, ['prompt' => '- pilih child -']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
