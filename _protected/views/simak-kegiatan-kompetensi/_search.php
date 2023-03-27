<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimakKegiatanKompetensiSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simak-kegiatan-kompetensi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pilihan_id') ?>

    <?= $form->field($model, 'kegiatan_id') ?>

    <?= $form->field($model, 'bobot') ?>

    <?= $form->field($model, 'persentase_bobot') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
