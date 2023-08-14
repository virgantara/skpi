<?php

use app\helpers\MyHelper;
use app\models\SimkatmawaBelmawa;
use app\models\SimkatmawaBelmawaKategori;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaBelmawa $model */

$this->title = $model->nama_kegiatan;
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Belmawa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="simkatmawa-belmawa-view">

    <div class="row">
        <div class="col-xs-12">
            <div class="space-6"></div>

            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="widget-box transparent">
                        <div class="widget-header widget-header-large">
                            <h3 class="widget-title grey lighter">
                                <i class="ace-icon fa fa-leaf green"></i>
                                <?= Html::encode($this->title) ?>
                            </h3>

                            <div class="widget-toolbar no-border invoice-info">
                                <span class="invoice-info-label">Program Studi: </span>
                                <span class="blue"><?= $model->user->prodi->prodi->nama_prodi ?? "-" ?></span>

                                <br />
                                <span class="invoice-info-label">Tanggal:</span>
                                <span class="blue"><?= $model->tanggal_mulai ?> / <?= $model->tanggal_selesai ?></span>
                            </div>

                            <div class="widget-toolbar hidden-480">
                                <a href="#">
                                    <i class="ace-icon fa fa-print"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main padding-24">
                                <div class="row">

                                    <p>
                                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                                        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'jenisSimkatmawa' => $model->jenis_simkatmawa], [
                                            'class' => 'btn btn-danger',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this item?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </p>
                                </div>

                                <div class="space"></div>

                                <div class="row">
                                    <div class="col-md-6">

                                        <?= DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'simkatmawa_belmawa_kategori_id',
                                                    'label' => 'Kategori Kegiatan',
                                                    'value' => function ($model) {
                                                        return SimkatmawaBelmawaKategori::findOne($model->simkatmawa_belmawa_kategori_id)->nama;
                                                    }
                                                ],
                                                'nama_kegiatan',
                                                [
                                                    'attribute' => 'tanggal_mulai',
                                                    'value' => function ($model) {
                                                        return MyHelper::converTanggalIndoLengkap($model->tanggal_mulai);
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'tanggal_selesai',
                                                    'value' => function ($model) {
                                                        return MyHelper::converTanggalIndoLengkap($model->tanggal_selesai);
                                                    }
                                                ],
                                            ],
                                        ]) ?>
                                    </div>
                                    <div class="col-md-6">

                                        <?= DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                'peringkat',
                                                'keterangan',
                                                [
                                                    'attribute' => 'laporan_path',
                                                    'label' => 'Laporan Pelaksanakan Kegiatan',
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        if (empty($model->laporan_path)) {
                                                            return '-';
                                                        }
                                                        return Html::a('Download <i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'laporan_path'], ['target' => '_blank', 'data-pjax' => 0]);
                                                    }
                                                ],
                                            ],
                                        ]) ?>
                                    </div>
                                </div>

                                <div class="hr hr8 hr-double hr-dotted"></div>

                                <?php echo $this->render('detail_mahasiswa', [
                                    'model' => $model,
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>