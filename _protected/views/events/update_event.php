<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = 'Update Events: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

// $list_prodi = \app\models\SimakMasterprogramstudi::getList();
$list_fakultas = \app\models\SimakMasterfakultas::getList();
$listDosen = \app\models\SimakMasterdosen::find()->orderBy(['nama_dosen'=>SORT_ASC])->all();

$id_jenis_kegiatan = !empty($model) && !empty($model->kegiatan) ? $model->kegiatan->id_jenis_kegiatan : null;

?>
<div class="col-lg-6">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="events-form">

        <?php $form = ActiveForm::begin([
            'options' => [
                'id' => 'form_validation',
                'enctype' => 'multipart/form-data'
            ]
        ]); ?>
        <?php
            foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
              echo '<div class="flash alert alert-' . $key . '">' . $message . '<button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button></div>';
            }

        ?>
        <?= $form->field($model, 'id')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'tahun_id')->dropDownList(ArrayHelper::map($listTahun,'tahun_id','nama_tahun'),['prompt'=>'- Pilih Tahun -']) ?>
        <div class="form-group">
            <label for="">Jenis Kegiatan</label>
        <?=Html::dropDownList('id_jenis_kegiatan',$id_jenis_kegiatan,ArrayHelper::map(\app\models\SimakJenisKegiatan::find()->all(),'id','nama_jenis_kegiatan'),['id'=>'id_jenis_kegiatan','class'=>'form-control','prompt'=>'-Pilih Jenis Kegiatan-']);?>
        </div>

        <?= $form->field($model, 'kegiatan_id')->dropDownList([],['id'=>'kegiatan_id','prompt'=>'- Pilih Kegiatan -']) ?>

        <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'venue')->dropDownList(ArrayHelper::map(\app\models\Venue::find()->all(),'nama','nama'),['class'=>'form-control','prompt'=>'-Pilih Venue-']);?>

        <?= $form->field($model, 'tanggal_mulai')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => 'Enter event time ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
                'format' => 'yyyy-mm-dd hh:mm:ss'
            ]
        ]); ?>

        <?= $form->field($model, 'toleransi_masuk')->dropDownList(\app\helpers\MyHelper::getToleransiWaktu()) ?>

        <?= $form->field($model, 'tanggal_selesai')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => 'Enter event time ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
                'format' => 'yyyy-mm-dd hh:mm:ss'
            ]
        ]); ?>

        <?= $form->field($model, 'toleransi_keluar')->dropDownList(\app\helpers\MyHelper::getToleransiWaktu()) ?>

        <?= $form->field($model, 'penyelenggara')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'tingkat')->dropDownList(['Prodi'=>'Prodi','Fakultas'=>'Fakultas','Universitas'=>'Universitas','Lokal'=>'Lokal','Provinsi'=>'Provinsi','Nasional'=>'Nasional','Internasional'=>'Internasional'],['id'=>'tingkat','class'=>'form-control','prompt'=>'-Pilih Tingkat-']);?>

        <?= $form->field($model, 'fakultas')->dropDownList(ArrayHelper::map($list_fakultas,'kode_fakultas',function($data){
            return $data->kode_fakultas.' - '.$data->nama_fakultas;
        }),['id'=>'fakultas','class'=>'form-control','prompt'=>'-Pilih Prodi-']);?>

        <?= $form->field($model, 'prodi')->dropDownList([],['id'=>'prodi','class'=>'form-control','prompt'=>'-Pilih Prodi-']);?>

        <?= $form->field($model, 'dosen_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map($listDosen,'nidn','nama_dosen'),

            'options'=>['id'=>'dosen_id','placeholder'=>Yii::t('app','- Pilih Dosen -')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>

        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'priority')->dropDownList(['success'=>'Low','yellow'=>'Medium','warning'=>'High','danger'=>'Important'],['id'=>'priority','class'=>'form-control','prompt'=>'-Pilih Prioritas-']);?>

         <div class="form-group">
            <label class="">Upload Foto Poster Event *</label>
            
            <?= $form->field($model, 'file_path')->widget(FileInput::classname(), [
                'options' => ['accept' => ''],
                'pluginOptions' => [
                    'showUpload' => false,
                ]
            ])->label(false) ?>

            <div class="alert alert-danger">NB: Ekstensi file adalah png, jpeg, dan jpg dengan ukuran maksimal adalah 1 MB</div>
            </div>
        </div>       
       

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>


<?php

$this->registerJs("
    
$(\"#id_jenis_kegiatan\").change(function(){
    getListKegiatan($(this).val(),$('#kegiatan_id'));
});



getListKegiatan($(\"#id_jenis_kegiatan\").val(),$('#kegiatan_id'));

$('#fakultas').change(function(){
    getProdyByFakultas($(this).val())
})

function getProdyByFakultas(kode_fakultas){
    var obj = new Object;
    obj.kode_fakultas = kode_fakultas;
    var prodi = $('#prodi');
    $.ajax({
       url: '".Url::to(['api/get-prodi-by-fakultas'])."',
       data: {
        dataPost : obj
       },
       type: \"POST\",
       async: true,
       success: function(json) {
            var res = $.parseJSON(json)
            var row = '';
            prodi.empty();
            row += '<option  value=\"\">- Pilih Prodi -</option>'
            $.each(res, function(i, obj){
              row += '<option  value=\"'+obj.kode_prodi+'\">'+obj.nama_prodi+'</option>';
            });

            prodi.append(row);
            prodi.val('".$model->prodi."');
       }
    });
}

function getListKegiatan(jenis_kegiatan, kegiatan_selector){
    var obj = new Object;
    obj.id = jenis_kegiatan;
  
    $.ajax({
       url: '".Url::to(['simak-kegiatan/ajax-list-kegiatan'])."',
       data: {
        dataPost : obj
       },
       type: \"POST\",
       async: true,
       success: function(json) {
            var res = $.parseJSON(json)
            var row = '';
            kegiatan_selector.empty();
            $.each(res, function(i, obj){
              row += '<option  value=\"'+obj.id+'\">'+obj.name+'</option>';
            });

            kegiatan_selector.append(row);
            kegiatan_selector.val('".$model->kegiatan_id."');
       }
    });
  


  
}

", \yii\web\View::POS_READY);
