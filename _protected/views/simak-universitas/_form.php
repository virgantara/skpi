<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
/** @var yii\web\View $this */
/** @var app\models\SimakUniversitas $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simak-universitas-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        
        <table class="table">
            <tr>
                <td colspan="3"><h3>Informasi Terkait SKPI</h3></td>
            </tr>
            <tr>
                <td>
                    Deskripsi<br><i>Description</i>
                </td>
                <td>
                    <?= $form->field($model, 'deskripsi_skpi')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'advance',
                        'clientOptions' => [
                            'enterMode' => 2,
                            'forceEnterMode' => false,
                            'shiftEnterMode' => 1
                        ]
                    ])->label(false) ?>
                </td>
                <td>
                    <?= $form->field($model, 'deskripsi_skpi_en')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'advance',
                        'clientOptions' => [
                            'enterMode' => 2,
                            'forceEnterMode' => false,
                            'shiftEnterMode' => 1
                        ]
                    ])->label(false) ?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><h3>Informasi Terkait Universitas</h3></td>
            </tr>
            <tr>
                <td>Nama Perguruan Tinggi<br><i>Awarding Institution</i></td>
                <td><?= $form->field($model, 'nama_institusi')->textInput(['maxlength' => true])->label(false) ?></td>
                <td><?= $form->field($model, 'nama_institusi_en')->textInput(['maxlength' => true])->label(false) ?></td>
            </tr>
            <tr>
                <td>SK Pendirian Perguruan Tinggi<br><i>Awarding Institution's License</i></td>
                <td><?= $form->field($model, 'sk_pendirian')->textInput(['maxlength' => true])->label(false) ?></td>
                <td></td>
            </tr>
            <tr>
                <td>Peringkat Akreditasi<br><i>Accreditation Ranking</i></td>
                <td><?= $form->field($model, 'peringkat_akreditasi')->textInput(['maxlength' => true])->label(false) ?></td>
                <td></td>
            </tr>
            <tr>
                <td>Nomor Sertifikat Akreditasi<br><i>Accreditation Decree Number</i></td>
                <td><?= $form->field($model, 'nomor_sertifikat_akreditasi')->textInput(['maxlength' => true])->label(false) ?></td>
                <td></td>
            </tr>
            <tr>
                <td>Lembaga Akreditasi<br><i>Accreditation Organization</i></td>
                <td><?= $form->field($model, 'lembaga_akreditasi')->textInput(['maxlength' => true])->label(false) ?></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    Persyaratan Penerimaan<br><i>Entry Requirements</i>
                </td>
                <td>
                    <?= $form->field($model, 'persyaratan_penerimaan')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'advance',
                        'clientOptions' => [
                            'enterMode' => 2,
                            'forceEnterMode' => false,
                            'shiftEnterMode' => 1
                        ]
                    ])->label(false) ?>
                </td>
                <td>
                    <?= $form->field($model, 'persyaratan_penerimaan_en')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'advance',
                        'clientOptions' => [
                            'enterMode' => 2,
                            'forceEnterMode' => false,
                            'shiftEnterMode' => 1
                        ]
                    ])->label(false) ?>
                </td>
            </tr>
            <tr>
                <td>
                    Sistem Penilaian<br><i>Grading System</i>
                </td>
                <td>
                    <?= $form->field($model, 'sistem_penilaian')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'advance',
                        'clientOptions' => [
                            'enterMode' => 2,
                            'forceEnterMode' => false,
                            'shiftEnterMode' => 1
                        ]
                    ])->label(false) ?>
                </td>
                <td>
                    <?= $form->field($model, 'sistem_penilaian_en')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'advance',
                        'clientOptions' => [
                            'enterMode' => 2,
                            'forceEnterMode' => false,
                            'shiftEnterMode' => 1
                        ]
                    ])->label(false) ?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><h3>Informasi Terkait Kontak</h3></td>
            </tr>
            <tr>
                <td>
                    Alamat<br><i>Address</i>
                </td>
                <td><?= $form->field($model, 'alamat')->textInput(['maxlength' => true])->label(false) ?></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    Telepon<br><i>Telephone</i>
                </td>
                <td><?= $form->field($model, 'telepon')->textInput(['maxlength' => true])->label(false) ?></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    Fax<br><i>Fax</i>
                </td>
                <td><?= $form->field($model, 'fax')->textInput(['maxlength' => true])->label(false) ?></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    Website<br><i>Website</i>
                </td>
                <td><?= $form->field($model, 'website')->textInput(['maxlength' => true])->label(false) ?></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    Email<br><i>Email</i>
                </td>
                <td><?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(false) ?></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"><h3>Informasi Terkait Catatan Resmi</h3></td>
            </tr>
            <tr>
                <td>
                    Deskripsi<br><i>Description</i>
                </td>
                <td>
                    <?= $form->field($model, 'catatan_resmi')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'advance',
                        'clientOptions' => [
                            'enterMode' => 2,
                            'forceEnterMode' => false,
                            'shiftEnterMode' => 1
                        ]
                    ])->label(false) ?>
                </td>
                <td>
                    <?= $form->field($model, 'catatan_resmi_en')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'advance',
                        'clientOptions' => [
                            'enterMode' => 2,
                            'forceEnterMode' => false,
                            'shiftEnterMode' => 1
                        ]
                    ])->label(false) ?>
                </td>
            </tr>
        </table>
    
    </div>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
