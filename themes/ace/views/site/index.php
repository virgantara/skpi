<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\assets\HighchartAsset;
use app\helpers\MyHelper;
use app\models\SimakTahunakademik;
use kartik\select2\Select2;
use richardfan\widget\JSRegister;

$this->title = Yii::t('app', Yii::$app->name);

HighchartAsset::register($this);

\app\assets\LeafletAsset::register($this);
$query = \app\models\Asrama::find();



if (!Yii::$app->user->isGuest && Yii::$app->user->identity->access_role == 'operatorCabang') {
  $query->where(['kampus_id' => Yii::$app->user->identity->kampus]);
}
$listAsrama = $query->all();
?>
<style type="text/css">
  .containerAsrama {
    height: 130px;
  }
</style>

<style>
  #map {
    width: 800px;
    height: 500px;
  }

  .info {
    padding: 6px 8px;
    font: 14px/16px Arial, Helvetica, sans-serif;
    background: white;
    background: rgba(255, 255, 255, 0.8);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    border-radius: 5px;
  }

  .info h4 {
    margin: 0 0 5px;
    color: #777;
  }

  .legend {
    text-align: left;
    line-height: 18px;
    color: #555;
  }

  .legend i {
    width: 18px;
    height: 18px;
    float: left;
    margin-right: 8px;
    opacity: 0.7;
  }
</style>

<div class="tabbable">
  <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">


    <li class="active">
      <a data-toggle="tab" href="#event" aria-expanded="false">Events</a>
    </li>

    <li class="">
      <a data-toggle="tab" href="#asrama" aria-expanded="false">Asrama</a>
    </li>

    <li class="">
      <a data-toggle="tab" href="#konsulat" id="tab_konsulat" aria-expanded="false">Peta Konsulat</a>
    </li>
    <li class="">
      <a data-toggle="tab" href="#akpam" aria-expanded="true">Akpam</a>
    </li>
    <?php
    if (!Yii::$app->user->isGuest) {
    ?>
      <li class="">
        <a data-toggle="tab" href="#dropdown14" aria-expanded="false">Pelanggaran Disiplin</a>
      </li>
    <?php
    }
    ?>
    <li class="">
      <a data-toggle="tab" href="#simkatmawa" aria-expanded="true">SIMKATMAWA</a>
    </li>
  </ul>

  <div class="tab-content">
    <div id="akpam" class="tab-pane">
      <div class="row">
        <div class="col-md-4">
          <div class="widget-box transparent">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Rekapitulasi Kelulusan AKPAM

              </h4>

            </div>

            <div class="widget-body">
              <div class="widget-main padding-4">
                <div class="tab-content padding-8">

                  <?= Html::dropDownList('tahun_id', '', ArrayHelper::map(SimakTahunakademik::getList(), 'tahun_id', 'nama_tahun'), ['prompt' => '- Pilih Tahun Akademik-', 'id' => 'tahun_akpam_id']); ?>
                  <span id="loading_akpam_lulus" style="display: none">
                    <img width="50px" src="<?= $this->theme->baseUrl; ?>/images/loading.gif" />
                  </span>
                  <div class="chart-container">
                    <div id="container-akpam-lulus" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                  </div>
                </div>
              </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
          </div><!-- /.widget-box -->
        </div>
        <div class="col-md-4">
          <div class="widget-box transparent">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Rekapitulasi Kelulusan AKPAM Per Fakultas

              </h4>

            </div>

            <div class="widget-body">
              <div class="widget-main padding-4">
                <div class="tab-content padding-8">
                  <span id="loading_akpam_lulus_fakultas" style="display: none">
                    <img width="50px" src="<?= $this->theme->baseUrl; ?>/images/loading.gif" />
                  </span>
                  <div class="chart-container">
                    <div id="container-akpam-lulus-fakultas" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                  </div>
                </div>
              </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
          </div><!-- /.widget-box -->
        </div>
        <div class="col-md-4">
          <div class="widget-box transparent">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Rekapitulasi Kelulusan AKPAM Per Prodi

              </h4>

            </div>

            <div class="widget-body">
              <div class="widget-main padding-4">
                <div class="tab-content padding-8">
                  <span id="loading_akpam_lulus_prodi" style="display: none">
                    <img width="50px" src="<?= $this->theme->baseUrl; ?>/images/loading.gif" />
                  </span>
                  <div class="chart-container">
                    <div id="container-akpam-lulus-prodi" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                  </div>
                </div>
              </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
          </div><!-- /.widget-box -->
        </div>
      </div>

    </div>

    <div id="event" class="tab-pane">


      <div class="row">
        <div class="col-md-6">
          <div class="widget-box transparent">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Perbandingan Event tiap Tingkatan

              </h4>
            </div>
            <div class="widget-body">
              <div class="widget-main padding-4">
                <div class="tab-content padding-8">
                  <?= Html::dropDownList('periode', '', \app\helpers\MyHelper::getPeriodeEvent(), ['prompt' => '- Pilih Periode Event-', 'id' => 'periode']); ?>
                  <span id="loadingEvent" style="display:none"><img width="50px" src="<?= $this->theme->baseUrl; ?>/images/loading.gif" /></span>
                  <div class="chart-container">
                    <div id="container-event" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>
        <div class="col-md-6">
          <div class="widget-box transparent">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Top 5 Prodi dengan Event Teraktif

              </h4>

              <div class="pull-right">

              </div>
            </div>

            <div class="widget-body">
              <div class="widget-main padding-4">
                <div class="tab-content padding-8">

                  <?= Html::dropDownList('tahun_id', '', ArrayHelper::map(\app\models\SimakTahunakademik::getList(), 'tahun_id', 'nama_tahun'), ['prompt' => '- Pilih Tahun Akademik-', 'id' => 'tahun_id']); ?>
                  <span id="loadingTopProdiAktif" style="display: none"><img width="50px" src="<?= $this->theme->baseUrl; ?>/images/loading.gif" /></span>
                  <div class="containerProdiAktif" id="containerProdiAktif" style="min-width: 200;  margin: 0 auto">

                  </div>

                </div>
              </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
          </div><!-- /.widget-box -->
        </div>
      </div>
    </div>

    <div id="asrama" class="tab-pane">

      <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
          <div class="widget-box transparent">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Kapasitas Asrama
              </h4>
              <div id="loadingGauge" style="display: none"><img width="50px" src="<?= $this->theme->baseUrl; ?>/images/loading.gif" /></div>
            </div>

            <div class="widget-body">
              <div class="widget-main padding-4">
                <div class="tab-content padding-8">


                  <?php

                  foreach ($listAsrama as $a) {
                  ?><div class="table-responsive">
                      <div class="containerAsrama" id="containerAsrama<?= $a->id; ?>" style="min-width: 200;  margin: 0 auto"></div>
                    </div>
                  <?php
                  }
                  ?>

                </div>
              </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
          </div><!-- /.widget-box -->
        </div><!-- /.col -->

      </div>
    </div>

    <div id="konsulat" class="tab-pane">
      <div class="row">

        <div class="col-xs-12 ">
          <div class="widget-box transparent">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Peta Sebaran Konsulat
              </h4>
            </div>

            <div class="widget-body">
              <div class="widget-main padding-4">
                <div class="tab-content padding-8">
                  <div class="col-lg-offset-1 col-lg-10 col-xs-12" id="mapid" style="height: 700px;"></div>

                </div>
              </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
          </div><!-- /.widget-box -->
        </div><!-- /.col -->

      </div>

    </div>

    <div id="dropdown14" class="tab-pane">
      <div class="row">

        <div class="col-xs-12 col-sm-12 col-lg-4 col-md-4">
          <div class="widget-box transparent">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Top Pelanggaran Ringan
                <span id="loadingringan" style="display: none"><img width="50px" src="<?= $this->theme->baseUrl; ?>/images/loading.gif" /></span>
              </h4>

              <div class="pull-right">
                <a href="javascript:void(0)" class="btn btn-xs btn-info" id="kembalilv2ringan" style="display: none"> <i class="glyphicon glyphicon-step-backward"></i> Kembali</a>
                <a href="javascript:void(0)" class="btn btn-xs btn-info" id="kembalilv3ringan" style="display: none"> <i class="glyphicon glyphicon-step-backward"></i> Kembali</a>
              </div>
            </div>

            <div class="widget-body">
              <div class="widget-main padding-4">
                <div class="tab-content padding-8">


                  <div class="containerringan" id="containerringan" style="min-width: 200;  margin: 0 auto">

                  </div>

                </div>
              </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
          </div><!-- /.widget-box -->
        </div><!-- /.col -->
        <div class="col-xs-12 col-sm-12 col-lg-4 col-md-4">
          <div class="widget-box transparent">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Top Pelanggaran Sedang
                <span id="loadingsedang" style="display: none"><img width="50px" src="<?= $this->theme->baseUrl; ?>/images/loading.gif" /></span>
              </h4>
              <div class="pull-right">
                <a href="javascript:void(0)" class="btn btn-xs btn-warning" id="kembalilv2sedang" style="display: none"> <i class="glyphicon glyphicon-step-backward"></i> Kembali</a>
                <a href="javascript:void(0)" class="btn btn-xs btn-warning" id="kembalilv3sedang" style="display: none"> <i class="glyphicon glyphicon-step-backward"></i> Kembali</a>
              </div>
            </div>

            <div class="widget-body">
              <div class="widget-main padding-4">
                <div class="tab-content padding-8">


                  <div class="table-responsive">
                    <div class="containersedang" id="containersedang" style="min-width: 200;  margin: 0 auto">

                    </div>
                  </div>

                </div>
              </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
          </div><!-- /.widget-box -->
        </div><!-- /.col -->
        <div class="col-xs-12 col-sm-12 col-lg-4 col-md-4">
          <div class="widget-box transparent">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Top Pelanggaran Berat
                <span id="loadingberat" style="display: none"><img width="50px" src="<?= $this->theme->baseUrl; ?>/images/loading.gif" /></span>
              </h4>
              <div class="pull-right">
                <a href="javascript:void(0)" class="btn btn-xs btn-danger" id="kembalilv2berat" style="display: none"> <i class="glyphicon glyphicon-step-backward"></i> Kembali</a>
                <a href="javascript:void(0)" class="btn btn-xs btn-danger" id="kembalilv3berat" style="display: none"> <i class="glyphicon glyphicon-step-backward"></i> Kembali</a>
              </div>
            </div>

            <div class="widget-body">
              <div class="widget-main padding-4">
                <div class="tab-content padding-8">


                  <div class="table-responsive">
                    <div class="containerberat" id="containerberat" style="min-width: 200;  margin: 0 auto">

                    </div>
                  </div>

                </div>
              </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
          </div><!-- /.widget-box -->
        </div><!-- /.col -->

      </div>
      <div class="row">

        <div class="col-xs-12 col-sm-12 col-lg-6 col-md-6">
          <div class="widget-box transparent">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Grafik Jumlah Pelanggaran
              </h4>
              <div id="loadingBuy" style="display: none"><img width="50px" src="<?= $this->theme->baseUrl; ?>/images/loading.gif" /></div>
            </div>

            <div class="widget-body">
              <div class="widget-main padding-4">
                <div class="tab-content padding-8">
                  <select name="year" id="tahun_pelanggan_kategori">
                    <option value=''>Select Year</option>
                    <?php
                    for ($year = 2014; $year <= 2030; $year++) {
                      $selected = (date('Y') == $year) ? 'selected' : '';
                      echo "<option value=$year $selected>$year</option>";
                    }
                    ?>
                  </select>
                  <div class="table-responsive">
                    <div id="container" style="min-width: 310px; height: 500px; margin: 0 auto"></div>
                  </div>
                </div>
              </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
          </div><!-- /.widget-box -->
        </div><!-- /.col -->

      </div>
    </div>


    <div id="simkatmawa" class="tab-pane active">

      <div class="row">
        <div class="col-md-3">
          <?= Select2::widget([
            'name' => 'tahun_simkatmawa',
            'data' => MyHelper::getYears(),
            'options' => [
              'id' => 'tahun_simkatmawa_id',
              'prompt' => '- Pilih Tahun -',
            ],
          ]); ?>
        </div>
      </div>

      <div class="row">

        <div class="col-md-6">
          <div class="widget-box transparent">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Data SIMKATMAWA
              </h4>
            </div>

            <div class="widget-body">
              <div class="widget-main padding-4">
                <div class="tab-content padding-8">

                  <span id="loading_akpam_lulus" style="display: none">
                    <img width="50px" src="<?= $this->theme->baseUrl; ?>/images/loading.gif" />
                  </span>
                  <div class="chart-container">

                    <div class="row">

                      <!-- Pertukaran Pelajar -->
                      <div class="col-xs-6 col-sm-3 pricing-box">

                        <div class="widget-box widget-color-blue">
                          <div class="widget-body">
                            <div class="widget-main">

                              <h2>
                                <p style="text-align: center;" id="data-pertukaran-pelajar">0</p>
                              </h2>
                              <p style="text-align: center;">Pertukaran Pelajar</p>

                            </div>
                            <div>
                              <?php
                              echo Html::a(
                                '<i class="ace-icon fa fa-plus bigger-110"></i> Input Data',
                                ['simkatmawa-mbkm/pertukaran-pelajar'],
                                ['class' => 'btn btn-block btn-primary']
                              ) ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Magang -->
                      <div class="col-xs-6 col-sm-3 pricing-box">

                        <div class="widget-box widget-color-blue">
                          <div class="widget-body">
                            <div class="widget-main">

                              <h2>
                                <p style="text-align: center;" id="data-magang">0</p>
                              </h2>
                              <p style="text-align: center;">Magang</p>

                            </div>
                            <div>
                              <?php
                              echo Html::a(
                                '<i class="ace-icon fa fa-plus bigger-110"></i> Input Data',
                                ['simkatmawa-mbkm/magang'],
                                ['class' => 'btn btn-block btn-primary']
                              ) ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Mengajar di Sekolah -->
                      <div class="col-xs-6 col-sm-3 pricing-box">

                        <div class="widget-box widget-color-blue">
                          <div class="widget-body">
                            <div class="widget-main">

                              <h2>
                                <p style="text-align: center;" id="data-mengajar-di-sekolah">0</p>
                              </h2>
                              <p style="text-align: center;">Mengajar di Sekolah</p>

                            </div>
                            <div>
                              <?php
                              echo Html::a(
                                '<i class="ace-icon fa fa-plus bigger-110"></i> Input Data',
                                ['simkatmawa-mbkm/mengajar-di-sekolah'],
                                ['class' => 'btn btn-block btn-primary']
                              ) ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Penelitian / Riset -->
                      <div class="col-xs-6 col-sm-3 pricing-box">

                        <div class="widget-box widget-color-blue">
                          <div class="widget-body">
                            <div class="widget-main">

                              <h2>
                                <p style="text-align: center;" id="data-penelitian">0</p>
                              </h2>
                              <p style="text-align: center;">Penelitian / Riset</p>

                            </div>
                            <div>
                              <?php
                              echo Html::a(
                                '<i class="ace-icon fa fa-plus bigger-110"></i> Input Data',
                                ['simkatmawa-mbkm/penelitian'],
                                ['class' => 'btn btn-block btn-primary']
                              ) ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Proyek Kemanusiaan -->
                      <div class="col-xs-6 col-sm-3 pricing-box">

                        <div class="widget-box widget-color-blue">
                          <div class="widget-body">
                            <div class="widget-main">

                              <h2>
                                <p style="text-align: center;" id="data-proyek-kemanusiaan">0</p>
                              </h2>
                              <p style="text-align: center;">Proyek Kemanusiaan</p>

                            </div>
                            <div>
                              <?php
                              echo Html::a(
                                '<i class="ace-icon fa fa-plus bigger-110"></i> Input Data',
                                ['simkatmawa-mbkm/proyek-kemanusiaan'],
                                ['class' => 'btn btn-block btn-primary']
                              ) ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Proyek Desa -->
                      <div class="col-xs-6 col-sm-3 pricing-box">

                        <div class="widget-box widget-color-blue">
                          <div class="widget-body">
                            <div class="widget-main">

                              <h2>
                                <p style="text-align: center;" id="data-proyek-desa">0</p>
                              </h2>
                              <p style="text-align: center;">Proyek Desa</p>

                            </div>
                            <div>
                              <?php
                              echo Html::a(
                                '<i class="ace-icon fa fa-plus bigger-110"></i> Input Data',
                                ['simkatmawa-mbkm/proyek-desa'],
                                ['class' => 'btn btn-block btn-primary']
                              ) ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Wirausaha -->
                      <div class="col-xs-6 col-sm-3 pricing-box">

                        <div class="widget-box widget-color-blue">
                          <div class="widget-body">
                            <div class="widget-main">

                              <h2>
                                <p style="text-align: center;" id="data-wirausaha">0</p>
                              </h2>
                              <p style="text-align: center;">Wirausaha</p>

                            </div>
                            <div>
                              <?php
                              echo Html::a(
                                '<i class="ace-icon fa fa-plus bigger-110"></i> Input Data',
                                ['simkatmawa-mbkm/wirausaha'],
                                ['class' => 'btn btn-block btn-primary']
                              ) ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Studi / Proyek Independen -->
                      <div class="col-xs-6 col-sm-3 pricing-box">

                        <div class="widget-box widget-color-blue">
                          <div class="widget-body">
                            <div class="widget-main">

                              <h2>
                                <p style="text-align: center;" id="data-studi">0</p>
                              </h2>
                              <p style="text-align: center;">Studi / Proyek Independen</p>

                            </div>
                            <div>
                              <?php
                              echo Html::a(
                                '<i class="ace-icon fa fa-plus bigger-110"></i> Input Data',
                                ['simkatmawa-mbkm/studi'],
                                ['class' => 'btn btn-block btn-primary']
                              ) ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Pembinaan Mental Kebangsaan -->
                      <div class="col-xs-6 col-sm-3 pricing-box">

                        <div class="widget-box widget-color-blue">
                          <div class="widget-body">
                            <div class="widget-main">

                              <h2>
                                <p style="text-align: center;" id="data-pembinaan-mental-kebangsaan">0</p>
                              </h2>
                              <p style="text-align: center;">Pembinaan Mental Kebangsaan</p>

                            </div>
                            <div>
                              <?php
                              echo Html::a(
                                '<i class="ace-icon fa fa-plus bigger-110"></i> Input Data',
                                ['simkatmawa-non-lomba/pembinaan-mental-kebangsaan'],
                                ['class' => 'btn btn-block btn-primary']
                              ) ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Rekognisi -->
                      <div class="col-xs-6 col-sm-3 pricing-box">

                        <div class="widget-box widget-color-blue">
                          <div class="widget-body">
                            <div class="widget-main">

                              <h2>
                                <p style="text-align: center;" id="data-rekognisi">0</p>
                              </h2>
                              <p style="text-align: center;">Rekognisi</p>

                            </div>
                            <div>
                              <?php
                              echo Html::a(
                                '<i class="ace-icon fa fa-plus bigger-110"></i> Input Data',
                                ['simkatmawa-mandiri/rekognisi'],
                                ['class' => 'btn btn-block btn-primary']
                              ) ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Kegiatan Mandiri -->
                      <div class="col-xs-6 col-sm-3 pricing-box">

                        <div class="widget-box widget-color-blue">
                          <div class="widget-body">
                            <div class="widget-main">

                              <h2>
                                <p style="text-align: center;" id="data-kegiatan-mandiri">0</p>
                              </h2>
                              <p style="text-align: center;">Kegiatan Mandiri</p>

                            </div>
                            <div>
                              <?php
                              echo Html::a(
                                '<i class="ace-icon fa fa-plus bigger-110"></i> Input Data',
                                ['simkatmawa-mandiri/kegiatan-mandiri'],
                                ['class' => 'btn btn-block btn-primary']
                              ) ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Belmawa -->
                      <div class="col-xs-6 col-sm-3 pricing-box">

                        <div class="widget-box widget-color-blue">
                          <div class="widget-body">
                            <div class="widget-main">

                              <h2>
                                <p style="text-align: center;" id="data-belmawa">0</p>
                              </h2>
                              <p style="text-align: center;">Belmawa</p>

                            </div>
                            <div>
                              <?php
                              echo Html::a(
                                '<i class="ace-icon fa fa-plus bigger-110"></i> Input Data',
                                ['simkatmawa-belmawa/index'],
                                ['class' => 'btn btn-block btn-primary']
                              ) ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Pengabdian Mahasiswa Kepada Masyarakat -->
                      <div class="col-xs-6 col-sm-3 pricing-box">

                        <div class="widget-box widget-color-blue">
                          <div class="widget-body">
                            <div class="widget-main">

                              <h2>
                                <p style="text-align: center;" id="data-pengabdian-masyarakat">0</p>
                              </h2>
                              <p style="text-align: center;">Pengabdian Mahasiswa Kepada Masyarakat</p>

                            </div>
                            <div>
                              <?php
                              echo Html::a(
                                '<i class="ace-icon fa fa-plus bigger-110"></i> Input Data',
                                ['simkatmawa-mbkm/pengabdian-masyarakat'],
                                ['class' => 'btn btn-block btn-primary']
                              ) ?>
                            </div>
                          </div>
                        </div>
                      </div>


                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="widget-box transparent">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller"> <i class="ace-icon fa fa-rss orange"></i>Rekapitulasi SIMKATMAWA</h4>
            </div>

            <div class="widget-body">
              <div class="widget-main padding-4">
                <div class="tab-content padding-8">
                  <span id="loadingSimkatmawa" style="display:none"><img width="50px" src="<?= $this->theme->baseUrl; ?>/images/loading.gif" /></span>
                  <div class="chart-container">
                    <div id="container-simkatmawa" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>

      </div>

    </div>
  </div>
</div>

<?php
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->access_role != 'asesor') {
?>


<?php
}
?>

<?php JSRegister::begin() ?>
<script>
  $("#periode").change(function() {
    countEventByTingkat($(this).val())
  })

  let limit = 5;

  function getRandColor(same, darkness) {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    return "rgb(" + r + "," + g + "," + b + ")";
  }


  $("#tahun_id").change(function() {

    countProdiEventTop($(this).val(), limit)
  })

  $("#tahun_akpam_id").change(function() {

    getKelulusanAkpam($(this).val());
    getKelulusanAkpamFakultas($(this).val())
    getKelulusanAkpamProdi($(this).val(), null)
  })

  countProdiEventTop($("#tahun_id").val(), limit)
  countEventByTingkat($("#periode").val())
  getKelulusanAkpam($("#tahun_akpam_id").val())

  function getKelulusanAkpamProdi(tahun_akademik, fakultas) {

    var obj = new Object;
    obj.tahun_akademik = tahun_akademik;
    obj.fakultas = fakultas

    $.ajax({

      type: "POST",
      url: "/api/ajax-rekap-kelulusan-akpam-prodi",
      data: {
        dataPost: obj
      },
      async: true,
      error: function(e) {
        $("#loading_akpam_lulus_prodi").hide();
      },
      beforeSend: function() {
        $("#loading_akpam_lulus_prodi").show();

      },
      success: function(hasil) {
        var hasil = $.parseJSON(hasil);
        $("#loading_akpam_lulus_prodi").hide();

        var kategori = [];

        var chartData = [];
        var chartDataBelum = [];

        $.each(hasil, function(i, obj) {
          kategori.push(obj.prodi)

          chartData.push(obj.count_lulus);
          chartDataBelum.push(obj.count_belum);
        });

        $("#container-akpam-lulus-prodi").highcharts({
          chart: {
            type: "column"
          },
          title: {
            text: "Persentase Kelulusan AKPAM Per Prodi"
          },

          xAxis: {
            categories: kategori,
            crosshair: true
          },
          yAxis: {
            title: {
              text: "Jumlah"
            },

            startOnTick: false,
            endOnTick: false
          },
          tooltip: {
            headerFormat: "<span style=\"font-size:10px\">{point.key}</span><table>",
            pointFormat: "<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>" +
              "<td style=\"padding:0\"><b>{point.y}</b></td></tr>",
            footerFormat: "</table>",
            shared: true,
            useHTML: true
          },
          plotOptions: {
            column: {
              pointPadding: 0.2,
              borderWidth: 0
            },
            series: {
              cursor: 'pointer',
              point: {
                events: {
                  click: function(tes) {

                  }
                }
              }
            }


          },

          series: [{
              name: "Jumlah Mahasiswa Lulus AKPAM",
              data: chartData,
              color: "rgb(0,200,0)"
            },
            {
              name: "Jumlah Mahasiswa Belum Lulus AKPAM",
              data: chartDataBelum,
              color: "rgb(200,0,0)"
            },
          ],

          responsive: {
            rules: [{
              condition: {
                maxWidth: 500
              },
              chartOptions: {
                legend: {
                  layout: "horizontal",
                  align: "center",
                  verticalAlign: "bottom"
                }
              }
            }]
          }
        });
      }
    });
  }

  function getKelulusanAkpamFakultas(tahun_akademik) {

    var obj = new Object;
    obj.tahun_akademik = tahun_akademik;

    $.ajax({

      type: "POST",
      url: "/api/ajax-rekap-kelulusan-akpam-fakultas",
      data: {
        dataPost: obj
      },
      async: true,
      error: function(e) {
        $("#loading_akpam_lulus_fakultas").hide();
      },
      beforeSend: function() {
        $("#loading_akpam_lulus_fakultas").show();

      },
      success: function(hasil) {
        var hasil = $.parseJSON(hasil);
        $("#loading_akpam_lulus_fakultas").hide();

        var kategori = [];

        var chartData = [];
        var chartDataBelum = [];

        $.each(hasil, function(i, obj) {
          kategori.push(obj.fakultas)

          chartData.push(obj.count_lulus);
          chartDataBelum.push(obj.count_belum);
        });

        $("#container-akpam-lulus-fakultas").highcharts({
          chart: {
            type: "column"
          },
          title: {
            text: "Persentase Kelulusan AKPAM Per Fakultas"
          },

          xAxis: {
            categories: kategori,
            crosshair: true
          },
          yAxis: {
            title: {
              text: "Jumlah"
            },

            startOnTick: false,
            endOnTick: false
          },
          tooltip: {
            headerFormat: "<span style=\"font-size:10px\">{point.key}</span><table>",
            pointFormat: "<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>" +
              "<td style=\"padding:0\"><b>{point.y}</b></td></tr>",
            footerFormat: "</table>",
            shared: true,
            useHTML: true
          },
          plotOptions: {
            column: {
              pointPadding: 0.2,
              borderWidth: 0
            },
            series: {
              cursor: 'pointer',
              point: {
                events: {
                  click: function(tes) {
                    getKelulusanAkpamProdi($("#tahun_akpam_id").val(), tes.point.category)
                  }
                }
              }
            }


          },

          series: [{
              name: "Jumlah Mahasiswa Lulus AKPAM",
              data: chartData,
              color: "rgb(0,200,0)"
            },
            {
              name: "Jumlah Mahasiswa Belum Lulus AKPAM",
              data: chartDataBelum,
              color: "rgb(200,0,0)"
            },
          ],

          responsive: {
            rules: [{
              condition: {
                maxWidth: 500
              },
              chartOptions: {
                legend: {
                  layout: "horizontal",
                  align: "center",
                  verticalAlign: "bottom"
                }
              }
            }]
          }
        });
      }
    });
  }

  function getKelulusanAkpam(tahun_akademik) {

    var obj = new Object;
    obj.tahun_akademik = tahun_akademik;

    $.ajax({

      type: "POST",
      url: "/api/ajax-rekap-kelulusan-akpam",
      data: {
        dataPost: obj
      },
      async: true,
      error: function(e) {
        $("#loading_akpam_lulus").hide();
      },
      beforeSend: function() {
        $("#loading_akpam_lulus").show();

      },
      success: function(hasil) {
        var hasil = $.parseJSON(hasil);
        $("#loading_akpam_lulus").hide();
        var kategori = ["LULUS", "BELUM"];

        var chartData = [{
            y: hasil.count_lulus,
            name: "Lulus"
          },
          {
            y: hasil.count_belum,
            name: "Belum Lulus"
          }
        ];


        $("#container-akpam-lulus").highcharts({
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: "pie"
          },
          title: {
            text: "Persentase Kelulusan AKPAM UNIDA Gontor"
          },

          xAxis: {
            categories: kategori,
            crosshair: true
          },
          yAxis: {
            title: {
              text: "Jumlah"
            },
            min: 0,
            max: 4,
            startOnTick: false,
            endOnTick: false
          },
          tooltip: {
            headerFormat: "<span style=\"font-size:10px\">{point.key}</span><table>",
            pointFormat: "<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>" +
              "<td style=\"padding:0\"><b>{point.y}</b></td></tr>",
            footerFormat: "</table>",
            shared: true,
            useHTML: true
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: "pointer",
              dataLabels: {
                enabled: true,
                format: "<b>{point.name}</b>: {point.percentage:.1f} %"
              }
            }



          },

          series: [{
            name: "Data Kelulusan AKPAM ",
            data: chartData,
            colorByPoint: true,
          }],

          responsive: {
            rules: [{
              condition: {
                maxWidth: 500
              },
              chartOptions: {
                legend: {
                  layout: "horizontal",
                  align: "center",
                  verticalAlign: "bottom"
                }
              }
            }]
          }
        });
      }
    });
  }

  function countProdiEventTop(tahun_id, limit) {
    var obj = new Object
    obj.tahun_id = tahun_id
    obj.limit = limit

    $.ajax({
      type: "POST",
      data: {
        dataPost: obj
      },
      url: "/api/count-prodi-event-top",
      async: true,
      beforeSend: function() {
        $("#loadingTopProdiAktif").show();
      },
      error: function(e) {
        console.log(e.responseText);
        $("#loadingTopProdiAktif").hide();
      },
      success: function(data) {
        $("#loadingTopProdiAktif").hide();
        var hasil = $.parseJSON(data);

        var kategori = []
        var chartData = []
        $.each(hasil, function(i, obj) {
          kategori.push(obj.nama_prodi)

          var tmp = {
            y: obj.total,
            name: obj.nama_prodi
          }

          chartData.push(tmp)
        })

        Highcharts.chart("containerProdiAktif", {
          chart: {
            type: "bar"
          },
          title: {
            text: null
          },
          subtitle: {
            text: null
          },
          xAxis: {
            categories: kategori,
            title: {
              text: 'Top 5 Prodi Teraktif'
            }
          },
          yAxis: {
            min: 0,
            title: {
              text: "Jumlah",
              align: 'high'
            },
            labels: {
              overflow: 'justify'
            }
          },
          tooltip: {
            valueSuffix: " Prodi Ter"
          },
          plotOptions: {
            bar: {
              dataLabels: {
                enabled: true
              }
            },
            series: {
              cursor: 'pointer',
              point: {
                events: {
                  click: function() {

                  }
                }
              }
            }
          },
          credits: {
            enabled: false
          },
          series: [{
            name: "Prodi Teraktif",
            data: chartData,
            // color: warna
          }],

        });
      }
    });


  }

  function countEventByTingkat(periode) {
    var obj = new Object
    obj.periode = periode

    $.ajax({
      type: "POST",
      data: {
        dataPost: obj
      },
      url: "/api/count-event-by-tingkat",
      async: true,
      beforeSend: function() {
        $("#loadingEvent").show();
      },
      error: function(e) {
        console.log(e.responseText);
        $("#loadingEvent").hide();
      },
      success: function(data) {
        $("#loadingEvent").hide();
        var hasil = $.parseJSON(data);

        var kategori = []
        var chartData = []
        $.each(hasil, function(i, obj) {
          kategori.push(obj.tingkat)

          var tmp = {
            y: obj.total,
            name: obj.tingkat
          }

          chartData.push(tmp)
        })

        $("#container-event").highcharts({
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: "pie"
          },
          title: {
            text: "Perbandingan Jumlah Tingkat Kegiatan"
          },

          xAxis: {
            categories: kategori,
            crosshair: true
          },
          yAxis: {
            title: {
              text: "Jumlah"
            },

            startOnTick: false,
            endOnTick: false
          },
          tooltip: {
            headerFormat: "<span style=\"font-size:10px\">{point.key}</span><table>",
            pointFormat: "<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>" +
              "<td style=\"padding:0\"><b>{point.y}</b></td></tr>",
            footerFormat: "</table>",
            shared: true,
            useHTML: true
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: "pointer",
              dataLabels: {
                enabled: true,
                format: "<b>{point.name}</b> : {point.percentage:.1f} %"
              }
            },
            series: {
              cursor: 'pointer',
              point: {
                events: {
                  click: function(tes) {
                    if (tes.point.name) {
                      window.open("/api/list-belum-krs", "_blank")
                    }
                  }
                }
              }
            }
          },

          series: [{
            name: "Total event",
            data: chartData,
            colorByPoint: true,
          }],

          responsive: {
            rules: [{
              condition: {
                maxWidth: 500
              },
              chartOptions: {
                legend: {
                  layout: "horizontal",
                  align: "center",
                  verticalAlign: "bottom"
                }
              }
            }]
          }
        });
      }
    });


  }

  function getPelanggaran(tahun) {

    $.ajax({
      type: "POST",
      data: "tahun=" + tahun,
      url: "/api/ajax-get-jumlah-pelanggaran-by-kategori",
      async: true,
      beforeSend: function() {
        $("#loadingBuy").show();
      },
      error: function(e) {
        console.log(e.responseText);
        $("#loadingBuy").hide();
      },
      success: function(data) {
        $("#loadingBuy").hide();
        var hasil = $.parseJSON(data);

        var kategori = [];
        var chartDataRingan = [];
        var chartDataSedang = [];
        var chartDataBerat = [];

        $.each(hasil.ringan, function(i, obj) {
          kategori.push(obj.bulan);
          chartDataRingan.push(obj.jumlah);
        });

        $.each(hasil.sedang, function(i, obj) {
          chartDataSedang.push(obj.jumlah);
        });

        $.each(hasil.berat, function(i, obj) {
          chartDataBerat.push(obj.jumlah);
        });

        $("#container").highcharts({
          chart: {
            type: "column"
          },
          title: {
            text: "Grafik Pelanggaran " + tahun
          },

          xAxis: {
            categories: kategori,
            crosshair: true
          },
          yAxis: {
            title: {
              text: "Jumlah"
            }
          },
          tooltip: {
            headerFormat: "<span style=\"font-size:10px\">{point.key}</span><table>",
            pointFormat: "<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>" +
              "<td style=\"padding:0\"><b>{point.y}</b></td></tr>",
            footerFormat: "</table>",
            shared: true,
            useHTML: true
          },
          plotOptions: {
            column: {
              pointPadding: 0.2,
              borderWidth: 0
            }
          },

          series: [{
            name: "Pelanggaran Ringan ",
            data: chartDataRingan,
            color: "#19ca07"
          }, {
            name: "Pelanggaran Sedang ",
            data: chartDataSedang,
            color: "#e58b31"
          }, {
            name: "Pelanggaran Berat ",
            data: chartDataBerat,
            color: "#FF0000"
          }],

          responsive: {
            rules: [{
              condition: {
                maxWidth: 500
              },
              chartOptions: {
                legend: {
                  layout: "horizontal",
                  align: "center",
                  verticalAlign: "bottom"
                }
              }
            }]
          }
        });
      }
    });
  }

  $("#tahun_pelanggan_kategori").change(function() {
    getPelanggaran($(this).val());
  });

  var tahun = $("#tahun_pelanggan_kategori").val();
  getPelanggaran(tahun);

  function generateDataAsrama(id, kategori, kapasitas, nilai) {
    Highcharts.chart("containerAsrama" + id, {
      plotOptions: {
        series: {
          pointPadding: 0.25,
          borderWidth: 0,
          color: '#000',
          targetOptions: {
            width: '200%'
          }
        }
      },
      chart: {
        marginTop: 40,
        inverted: true,
        marginLeft: 135,
        type: 'bullet'
      },
      title: {
        text: kategori
      },
      xAxis: {
        categories: ["<span class=\"hc-cat-title\">" + kategori + "</span>"]
      },
      yAxis: {
        plotBands: [{
          from: 0,
          to: kapasitas,
          color: "#18ca2a"
        }, {
          from: kapasitas,
          to: kapasitas + 100,
          color: "#d31414"
        }],
        title: null
      },
      series: [{
        data: [{
          y: nilai,
          target: kapasitas
        }]
      }],
      tooltip: {
        pointFormat: "<b>{point.y}</b> (with target at {point.target})"
      }
    });
  }

  $.ajax({
    type: "POST",
    data: "tahun=" + tahun,
    url: "/api/ajax-get-kapasitas-asrama",
    async: true,
    beforeSend: function() {
      $("#loadingGauge").show();
    },
    error: function(e) {
      console.log(e.responseText);
      $("#loadingGauge").hide();
    },
    success: function(data) {
      $("#loadingGauge").hide();
      var hasil = $.parseJSON(data);

      $.each(hasil, function(i, obj) {
        generateDataAsrama(obj.id, obj.nama, obj.total, obj.terpakai)
      });

    }
  });

  $(document).on("click", "#kembalilv2ringan", function(e) {
    var dataJenis = $(this).attr("data-jenis");
    var dataWarna = $(this).attr("data-warna");
    var dataCategory = $(this).attr("data-category");
    getTopPelanggaran("ringan", "#5890e8");
    $(this).hide();

  });

  $(document).on("click", "#kembalilv3ringan", function(e) {
    var dataJenis = $("#kembalilv2ringan").attr("data-jenis");
    var dataWarna = $("#kembalilv2ringan").attr("data-warna");
    var dataCategory = $("#kembalilv2ringan").attr("data-category");
    getTopPelanggaranFakultas(dataJenis, dataCategory, "#5890e8");
    $("#kembalilv2ringan").show();
    $("#kembalilv3ringan").hide();
  });

  $(document).on("click", "#kembalilv2sedang", function(e) {
    var dataJenis = $(this).attr("data-jenis");
    var dataWarna = $(this).attr("data-warna");
    var dataCategory = $(this).attr("data-category");
    getTopPelanggaran("sedang", "#e58b31");
    $(this).hide();
  });

  $(document).on("click", "#kembalilv3sedang", function(e) {
    var dataJenis = $("#kembalilv2sedang").attr("data-jenis");
    var dataWarna = $("#kembalilv2sedang").attr("data-warna");
    var dataCategory = $("#kembalilv2sedang").attr("data-category");
    getTopPelanggaranFakultas(dataJenis, dataCategory, "#e58b31");
    $("#kembalilv2sedang").show();
    $("#kembalilv3sedang").hide();
  });

  $(document).on("click", "#kembalilv2berat", function(e) {
    var dataJenis = $(this).attr("data-jenis");
    var dataWarna = $(this).attr("data-warna");
    var dataCategory = $(this).attr("data-category");
    getTopPelanggaran("berat", "#d31414");
    $(this).hide();
  });

  $(document).on("click", "#kembalilv3berat", function(e) {
    var dataJenis = $("#kembalilv2berat").attr("data-jenis");
    var dataWarna = $("#kembalilv2berat").attr("data-warna");
    var dataCategory = $("#kembalilv2berat").attr("data-category");
    getTopPelanggaranFakultas(dataJenis, dataCategory, "#d31414");
    $("#kembalilv2berat").show();
    $("#kembalilv3berat").hide();
  });

  function getTopPelanggaran(kat, warna) {

    $.ajax({
      type: "POST",
      url: "/api/ajax-get-pelanggaran-jumlah-terbanyak",
      data: {
        kategori: kat
      },
      async: true,
      beforeSend: function() {
        $("#loading" + kat).show();
      },
      error: function(e) {
        console.log(e.responseText);
        $("#loading" + kat).hide();
      },
      success: function(data) {
        $("#loading" + kat).hide();
        var hasil = $.parseJSON(data);

        var kategori = [];
        var dataitems = [];

        $.each(hasil, function(i, obj) {
          var tmp = new Object;
          tmp.y = obj.total;
          tmp.name = obj.kode;

          dataitems.push(tmp);
          kategori.push(obj.kode);

        });


        Highcharts.chart("container" + kat, {
          chart: {
            type: "bar"
          },
          title: {
            text: null
          },
          subtitle: {
            text: null
          },
          xAxis: {
            categories: kategori,
            title: {
              text: 'Pelanggaran'
            }
          },
          yAxis: {
            min: 0,
            title: {
              text: "Jumlah",
              align: 'high'
            },
            labels: {
              overflow: 'justify'
            }
          },
          tooltip: {
            valueSuffix: " Pelanggaran"
          },
          plotOptions: {
            bar: {
              dataLabels: {
                enabled: true
              }
            },
            series: {
              cursor: 'pointer',
              point: {
                events: {
                  click: function() {
                    getTopPelanggaranFakultas(kat, this.category, warna);
                    $("#kembalilv2" + kat).attr("data-jenis", kat);
                    $("#kembalilv2" + kat).attr("data-category", this.category);
                    $("#kembalilv2" + kat).attr("data-warna", warna);
                    $("#kembalilv2" + kat).show();
                  }
                }
              }
            }
          },
          credits: {
            enabled: false
          },
          series: [{
            name: "Pelanggaran",
            data: dataitems,
            color: warna
          }],

        });

      }
    });
  }

  function getTopPelanggaranFakultas(kat, pel, warna) {

    $.ajax({
      type: "POST",
      url: "/api/ajax-get-pelanggaran-jumlah-terbanyak-fakultas",
      data: {
        kategori: kat,
        pel_nama: pel
      },
      async: true,
      beforeSend: function() {
        $("#loading" + kat).show();
      },
      error: function(e) {
        console.log(e.responseText);
        $("#loading" + kat).hide();
      },
      success: function(data) {
        $("#loading" + kat).hide();
        var hasil = $.parseJSON(data);

        var kategori = [];
        var dataitems = [];

        $.each(hasil, function(i, obj) {
          var tmp = new Object;
          tmp.y = obj.total;
          tmp.name = obj.nama;

          dataitems.push(tmp);
          kategori.push(obj.nama);

        });


        Highcharts.chart("container" + kat, {
          chart: {
            type: "bar"
          },
          title: {
            text: null
          },
          subtitle: {
            text: null
          },
          xAxis: {
            categories: kategori,
            title: {
              text: 'Pelanggaran'
            }
          },
          yAxis: {
            min: 0,
            title: {
              text: "Banyak Pelanggaran",
              align: 'high'
            },
            labels: {
              overflow: 'justify'
            }
          },
          tooltip: {
            valueSuffix: " Pelanggaran"
          },
          plotOptions: {
            bar: {
              dataLabels: {
                enabled: true
              }
            },
            series: {
              cursor: 'pointer',
              point: {
                events: {
                  click: function() {
                    getTopPelanggaranProdi(kat, pel, this.category, warna);
                    $("#kembalilv3" + kat).show();
                    $("#kembalilv2" + kat).hide();
                  }
                }
              }
            }
          },
          credits: {
            enabled: false
          },
          series: [{
            name: "Pelanggaran",
            data: dataitems,
            color: warna
          }],

        });

      }
    });
  }

  function getTopPelanggaranProdi(kat, pel, fak, warna) {

    $.ajax({
      type: "POST",
      url: '/api/ajax-get-pelanggaran-jumlah-terbanyak-prodi',
      data: {
        kategori: kat,
        pel_nama: pel,
        fakultas: fak
      },
      async: true,
      beforeSend: function() {
        $("#loading" + kat).show();
      },
      error: function(e) {
        console.log(e.responseText);
        $("#loading" + kat).hide();
      },
      success: function(data) {
        $("#loading" + kat).hide();
        var hasil = $.parseJSON(data);

        var kategori = [];
        var dataitems = [];

        $.each(hasil, function(i, obj) {
          var tmp = new Object;
          tmp.y = obj.total;
          tmp.name = obj.nama;

          dataitems.push(tmp);
          kategori.push(obj.nama);

        });


        Highcharts.chart("container" + kat, {
          chart: {
            type: "bar"
          },
          title: {
            text: null
          },
          subtitle: {
            text: null
          },
          xAxis: {
            categories: kategori,
            title: {
              text: 'Pelanggaran'
            }
          },
          yAxis: {
            min: 0,
            title: {
              text: "Banyak Pelanggaran",
              align: 'high'
            },
            labels: {
              overflow: 'justify'
            }
          },
          tooltip: {
            valueSuffix: " Pelanggaran"
          },
          plotOptions: {
            bar: {
              dataLabels: {
                enabled: true
              }
            },

          },
          credits: {
            enabled: false
          },
          series: [{
            name: "Pelanggaran",
            data: dataitems,
            color: warna
          }],

        });

      }
    });
  }

  function getDataSimkatmawa(tahun) {
    var tahun = tahun ?? null
    $.ajax({
      url: '/simkatmawa/get-data',
      type: 'POST',
      data: {
        tahun: tahun
      },
      dataType: 'json',
      success: function(response) {
        $('#data-pertukaran-pelajar').text(response['countPertukaranPelajar']);
        $('#data-magang').text(response['countMagang']);
        $('#data-mengajar-di-sekolah').text(response['countMengajarDiSekolah']);
        $('#data-penelitian').text(response['countPenelitian']);
        $('#data-proyek-kemanusiaan').text(response['countProyekKemanusiaan']);
        $('#data-proyek-desa').text(response['countProyekDesa']);
        $('#data-wirausaha').text(response['countWirausaha']);
        $('#data-studi').text(response['countStudi']);
        $('#data-pengabdian-masyarakat').text(response['countPengabdianMasyarakat']);
        $('#data-pembinaan-mental-kebangsaan').text(response['countPembinaanMentalKebangsaan']);
        $('#data-rekognisi').text(response['countRekognisi']);
        $('#data-kegiatan-mandiri').text(response['countKegiatanMandiri']);
        $('#data-belmawa').text(response['countBelmawa']);
      }
    });
  }

  getDataSimkatmawa()

  function countSimkatmawaByJenis(periode) {
    var obj = new Object
    obj.periode = periode

    $.ajax({
      type: "POST",
      data: {
        dataPost: obj
      },
      url: "/simkatmawa/count-simkatmawa-by-jenis",
      async: true,
      beforeSend: function() {
        $("#loadingSimkatmawa").show();
      },
      error: function(e) {
        console.log(e.responseText);
        $("#loadingSimkatmawa").hide();
      },
      success: function(data) {

        $("#loadingSimkatmawa").hide();
        var hasil = $.parseJSON(data);

        var kategori = []
        var chartData = []
        $.each(hasil, function(i, obj) {
          kategori.push(obj.tingkat)
          var tmp = {
            y: obj.total,
            name: obj.tingkat
          }
          chartData.push(tmp)
        })

        $("#container-simkatmawa").highcharts({
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: "pie"
          },
          title: {
            text: "Perbandingan Jumlah Tingkat Kegiatan"
          },

          xAxis: {
            categories: kategori,
            crosshair: true
          },
          yAxis: {
            title: {
              text: "Jumlah"
            },

            startOnTick: false,
            endOnTick: false
          },
          tooltip: {
            headerFormat: "<span style=\"font-size:10px\">{point.key}</span><table>",
            pointFormat: "<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>" +
              "<td style=\"padding:0\"><b>{point.y}</b></td></tr>",
            footerFormat: "</table>",
            shared: true,
            useHTML: true
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: "pointer",
              dataLabels: {
                enabled: true,
                format: "<b>{point.name}</b> : {point.percentage:.1f} %"
              }
            },
            series: {
              cursor: 'pointer',
              point: {
                events: {
                  click: function(tes) {
                    if (tes.point.name) {
                      window.open("/api/list-belum-krs", "_blank")
                    }
                  }
                }
              }
            }
          },
          series: [{
            name: "Total event",
            data: chartData,
            colorByPoint: true,
          }],
          responsive: {
            rules: [{
              condition: {
                maxWidth: 500
              },
              chartOptions: {
                legend: {
                  layout: "horizontal",
                  align: "center",
                  verticalAlign: "bottom"
                }
              }
            }]
          }
        });

      }
    });
  }

  countSimkatmawaByJenis()
  
  
  $("#tahun_simkatmawa_id").change(function() {
    getDataSimkatmawa($(this).val())
    countSimkatmawaByJenis($(this).val())
  });


  getTopPelanggaran("ringan", "#5890e8");
  getTopPelanggaran("sedang", "#e58b31");
  getTopPelanggaran("berat", "#d31414");
</script>
<?php JSRegister::end() ?>



<?php

$html = "
function getPropinsi(map, callback){
  $.ajax({
        url: '" . Url::to(['simak-propinsi-batas/ajax-list-batas']) . "',
        type: 'POST',
        async : true,
        success: function (data) {
          var hasil = $.parseJSON(data)

          callback(null, hasil)
        }

    })
}
  var layerMarker = L.layerGroup()
  var layerProvinsi = L.layerGroup()

  var mymap = L.map('mapid',{
    layers: [layerProvinsi]
    }).setView([-7.9023, 111.4923], 6.5);

  L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    maxZoom: 18,
    attribution: 'Map data &copy; <a href=\"https://www.openstreetmap.org/\">OpenStreetMap</a> contributors, ' +
      '<a href=\"https://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, ' +
      'Imagery © <a href=\"https://www.mapbox.com/\">Mapbox</a>',
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1
  }).addTo(mymap);

  // control that shows state info on hover
  var info = L.control();

  info.onAdd = function (mymap) {
    this._div = L.DomUtil.create('div', 'info');
    this.update();
    return this._div;
  };

  info.update = function (props) {
    this._div.innerHTML = '<h4>Kepadatan Konsulat per provinsi</h4>' +  (props ?
      '<b>' + props.Propinsi + '</b><br />' + props.density + ' mhs'
      : 'Hover over a province');
  };

  info.addTo(mymap);


  // get color depending on population density value
  function getColor(d) {
    return d > 4000 ? '#800026' :
        d > 3000  ? '#BD0026' :
        d > 2000  ? '#E31A1C' :
        d > 1000  ? '#FC4E2A' :
        d > 500   ? '#FD8D3C' :
        d > 250   ? '#FEB24C' :
        d > 50   ? '#FED976' :
              '#FFEDA0';
  }

  function style(feature) {
    return {
      weight: 2,
      opacity: 1,
      color: 'white',
      dashArray: '3',
      fillOpacity: 0.7,
      fillColor: getColor(feature.properties.density)
    };
  }

  function highlightFeature(e) {
    var layer = e.target;

    layer.setStyle({
      weight: 5,
      color: '#666',
      dashArray: '',
      fillOpacity: 0.7
    });

    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
      layer.bringToFront();
    }

    info.update(layer.feature.properties);
  }

  var geojson;

  function resetHighlight(e) {
    geojson.resetStyle(e.target);
    info.update();
  }

  function zoomToFeature(e) {
    mymap.fitBounds(e.target.getBounds());
  }

  function onEachFeature(feature, layer) {
    layer.on({
      mouseover: highlightFeature,
      mouseout: resetHighlight,
      click: zoomToFeature
    });
  }
  
  var overlays = {
    'Kota' : layerMarker,
    'Provinsi' : layerProvinsi
  }
  L.control.layers(null, overlays).addTo(mymap);

  getPropinsi(mymap, function(err, res){
    // console.log(geodata)
    geojson = L.geoJson(res, {
      style: style,
      onEachFeature: onEachFeature
    }).addTo(layerProvinsi);

    var legend = L.control({position: 'bottomright'});

    legend.onAdd = function (map) {

      var div = L.DomUtil.create('div', 'info legend'),
        grades = [0, 50, 250, 500, 1000, 2000, 3000, 4000],
        labels = [],
        from, to;

      for (var i = 0; i < grades.length; i++) {
        from = grades[i];
        to = grades[i + 1];

        labels.push(
          '<i style=\"background:' + getColor(from + 1) + '\"></i> ' +
          from + (to ? '&ndash;' + to : '+'));
      }

      div.innerHTML = labels.join('<br>');
      return div;
    };

    legend.addTo(mymap);
  })

$('#tab_konsulat').click(function(e){
  setTimeout(function(){
      mymap.invalidateSize();
    },500)  
  
})
  
";

foreach ($results as $res) {
  $html .= "

  var marker = L.marker([" . $res['latitude'] . ", " . $res['longitude'] . "]);
  marker.bindPopup('" . $res['name'] . " (" . $res['total'] . " mahasiswa) ');
  marker.addTo(layerMarker)

  ";
}

$this->registerJs($html, \yii\web\View::POS_READY);

?>