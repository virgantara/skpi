<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model app\models\IzinMahasiswa */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'options' => [
            'tag' => false,
        ],
    ],
    'options' => [
        'class' => 'form-horizontal',
        'enctype' => 'multipart/form-data'
    ]
]);

?>


<div class="row">
    <div class="col-sm-12">

        <div class="widget-box widget-color-blue2">
            <div class="widget-header">
                <h4 class="widget-title lighter smaller">Data Perizinan</h4>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <?php

                    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                        echo '<div class="flash alert alert-' . $key . '">' . $message . '<button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button></div>';
                    }


                    echo $form->errorSummary($model, ['header' => '<div class="alert alert-danger">', 'footer' => '</div>']);

                    ?>

                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Ketik Nama Mahasiswa atau NIM</label>
                        <div class="col-sm-10">
                            <input name="nama_mahasiswa" class="form-control" type="text" id="nama_mahasiswa" />

                            <?= $form->field($model, 'nim')->hiddenInput(['id' => 'nim'])->label(false) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">Keperluan</label>
                        <div class="col-sm-10">
                            <?= $form->field($model, 'keperluan_id')->dropDownList(['1' => 'Pribadi', '2' => 'Kampus', '3' => 'Harian'], ['class' => 'form-control'])->label(false) ?>
                            <!-- <label class="error_diagnosis"></label> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Dalam/Luar Negeri</label>
                        <div class="col-sm-10">

                            <label><input type="radio" name="dn_ln" class="dn_ln" value="DN" checked=""> Dalam Negeri</label>
                            <label><input type="radio" name="dn_ln" class="dn_ln" value="LN"> Luar Negeri</label>

                        </div>
                    </div>
                    <div class="form-group" id="negara_tujuan" style="display: none;">
                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Negara Tujuan</label>
                        <div class="col-sm-10">
                            <input name="nama_negara" class="form-control" type="text" id="nama_negara" />

                            <?= $form->field($model, 'negara_id')->hiddenInput(['id' => 'negara_id'])->label(false) ?>

                            <?php
                            AutoComplete::widget([
                                'name' => 'nama_negara',
                                'id' => 'nama_negara',
                                'clientOptions' => [
                                    'source' => Url::to(['api/ajax-cari-negara']),
                                    'autoFill' => true,
                                    'minLength' => '1',
                                    'select' => new JsExpression("function( event, ui ) {
        $('#negara_id').val(ui.item.id);
        
     }")
                                ],
                                'options' => [
                                    // 'size' => '40'
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group" id="daerah_tujuan">
                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Daerah Tujuan</label>
                        <div class="col-sm-10">
                            <input name="nama_kota" class="form-control" type="text" id="nama_kota" />

                            <?= $form->field($model, 'kota_id')->hiddenInput(['id' => 'kota_id'])->label(false) ?>

                            <?php
                            AutoComplete::widget([
                                'name' => 'nama_kota',
                                'id' => 'nama_kota',
                                'clientOptions' => [
                                    'source' => Url::to(['api/ajax-cari-kota']),
                                    'autoFill' => true,
                                    'minLength' => '1',
                                    'select' => new JsExpression("function( event, ui ) {
        $('#kota_id').val(ui.item.id);
        
     }")
                                ],
                                'options' => [
                                    // 'size' => '40'
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">Tanggal Berangkat</label>
                        <div class="col-sm-10">
                            <?php
                            echo $form->field($model, 'tanggal_berangkat')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Input tanggal berangkat ...', 'autocomplete' => 'off'],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-mm-yyyy'
                                ]
                            ])->label(false);
                            ?>
                            <label class="error_tanggal"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">Tanggal Pulang</label>
                        <div class="col-sm-10">
                            <?php
                            echo $form->field($model, 'tanggal_pulang')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Input tanggal pulang ...', 'autocomplete' => 'off'],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-mm-yyyy'
                                ]
                            ])->label(false);
                            ?>
                            <label class="error_tanggal"></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">Alasan</label>
                        <div class="col-sm-10">
                            <?= $form->field($model, 'alasan')->textInput(['class' => 'form-control'])->label(false) ?>
                            <label class="error_diagnosis"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">Upload Peserta</label>
                        <div class="col-sm-10">
                            <?= $form->field($model, 'bulk_upload')->fileInput()->label(false) ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="clearfix form-actions">
    <div class="col-sm-offset-2 col-sm-10">
        <button class="btn btn-info" type="submit">
            <i class="ace-icon fa fa-check bigger-110"></i>
            Simpan
        </button>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php

$this->registerJs(' 

    $(".dn_ln").change(function(){
        var dn_ln = $(this);
        if(dn_ln.val() == "DN"){
            $("#daerah_tujuan").show();
            $("#negara_tujuan").hide();
        }

        else{
            $("#daerah_tujuan").hide();
            $("#negara_tujuan").show();   
        }
    });

    ', \yii\web\View::POS_READY);

?>


<?php
AutoComplete::widget([
    'name' => 'nama_mahasiswa',
    'id' => 'nama_mahasiswa',
    'clientOptions' => [
        'source' => Url::to(['api/ajax-cari-mahasiswa']),
        'autoFill' => true,
        'minLength' => '1',
        'select' => new JsExpression("function( event, ui ) {
        $('#nim').val(ui.item.id);
        
     }")
    ],
    'options' => [
        // 'size' => '40'
    ]
]);
?>