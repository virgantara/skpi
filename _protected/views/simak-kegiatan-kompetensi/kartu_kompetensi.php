<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\HighchartAsset;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SimakJadwalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kartu Hasil Kesantrian Mahasiswa';
$this->params['breadcrumbs'][] = $this->title;

?>
<style type="text/css">
  .swal2-popup {
    font-size: 1.6rem !important;
  }
</style>

<?php

$tglnow = date('Y-m-d H:i:s');

$tahun_id = $tahun_akademik->tahun_id;
?>
<?php $form = ActiveForm::begin([
  'method' => 'GET',
  'action' => ['simak-kegiatan-kompetensi/kartu-kompetensi'],
  'options' => [
    'id' => 'form_validation',
  ]
]); ?>
<div class="row">


  <div class="col-md-offset-3 col-md-6">
    <h3 class="page-title"><?= $this->title; ?></h3>
    <div class="form-group">
      <label class="control-label ">Tahun Akademik: </label>
      <?= Html::dropDownList('tahun_id', $tahun_akademik->tahun_id, \yii\helpers\ArrayHelper::map($listTahun, 'tahun_id', 'nama_tahun'), ['class' => 'form-control', 'id' => 'tahun_akademik', 'prompt' => Yii::t('app', '- Pilih Tahun Akademik -')]) ?>

    </div>
     <div class="form-group">
        <label class="control-label ">Mahasiswa</label>
        <?= Html::textInput('nama_mahasiswa', !empty($mhs) ? $mhs->nama_mahasiswa : '', ['id' => 'nama_mahasiswa', 'class' => 'form-control', 'placeholder' => 'Ketik NIM atau Nama Mahasiswa']) ?>
        <?= Html::hiddenInput('nim', !empty($mhs) ? $mhs->nim_mhs : '', ['id' => 'nim']) ?>
      </div>
      <div class="form-group">
        <label class="control-label ">Verification Code</label>
      <?php echo $form->field($model, 'captcha')->widget(Captcha::className(), [
          'options' => ['placeholder' => 'Please type above captcha',],
          'imageOptions' => [
              'id' => 'my-captcha-image'
          ]
      ])->label(FALSE); ?>
    </div>
    <div class="form-group clearfix">
      <button type="submit" class="btn btn-primary" name="btn-cari" value="1"><i class="fa fa-search"></i> Cari</button>

     
    </div>

  </div>

</div>
<?php ActiveForm::end(); ?>
<div class="row">
  <div class="col-md-offset-3 col-md-6">
    <div class="panel">

      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-info"></i> Nilai Kompetensi</h3>

      </div>
      <div class="panel-body">
        <span id="loading" style="display:none">
          <img width="40px" src="<?= Yii::$app->view->theme->baseUrl; ?>/assets/img/loading.gif">

        </span>
        <table class="table table-bordered table-striped">

          <thead>
            <tr>
              <th>No</th>

              <th>Kompetensi</th>
              <th>Nilai Akhir</th>
              <th>Predikat</th>

            </tr>
          </thead>
          <tbody>
            <?php
            $counter = 0;
            $list_kategori = [];
            $list_values = [];
            foreach ($results as $q => $v) {

              foreach ($v['komponen'] as $kom) {

                $counter++;

            ?>
                <tr>
                  <td><?= $counter; ?></td>
                  <td><?= $kom['kompetensi']; ?></td>
                  <td class="text-center"><?= Html::a($kom['nilai_akhir'],['simak-kegiatan-kompetensi/index','id' => $kom['kompetensi_id'],'nim' => $nim,'tahun_akademik' => $tahun_id],['class' =>'btn-detil-kompetensi']) ?></td>

                  <td><span class="label label-<?= $kom['color']; ?>"><?= $kom['label']; ?></span></td>
                </tr>

            <?php
              }
            }
            ?>
          </tbody>
        </table>

      </div>
    </div>
    <?=Html::a('* Rubrik Kompetensi',['simak-kegiatan-kompetensi/rubrik']);?>
  </div>
</div>


<?php

$this->registerJs(' 

$("#my-captcha-image").yiiCaptcha("refresh");

$(document).bind("keyup.autocomplete",function(){
  $(\'#nama_mahasiswa\').autocomplete({
      minLength:3,
      select:function(event, ui){
       
        $(\'#nim\').val(ui.item.nim);
                
      },
      
      focus: function (event, ui) {
        $(\'#nim\').val(ui.item.nim);
       
      },
      source:function(request, response) {
        $.ajax({
                url: "/mahasiswa/ajax-cari-mahasiswa",
                dataType: "json",
                data: {
                    term: request.term,
                    prodi : $("#prodi").val(),
                    kampus : $("#kampus").val(),
                    semester : $("#semester").val(),
                    status : $("#status_aktivitas").val()
                },
                success: function (data) {
                    response(data);
                }
            })
        },
       
  }); 

});

', \yii\web\View::POS_READY);

?>