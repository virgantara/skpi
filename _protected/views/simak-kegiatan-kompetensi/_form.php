<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimakKegiatanKompetensi $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simak-kegiatan-kompetensi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pilihan_id')->textInput() ?>

    <?= $form->field($model, 'kegiatan_id')->textInput() ?>

    <?= $form->field($model, 'bobot')->textInput() ?>

    <?= $form->field($model, 'persentase_bobot')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
