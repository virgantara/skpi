<?php

use app\helpers\MyHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMbkm $model */

$this->title = $model->nama_program;
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa MBKM', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => ucwords(str_replace('-', ' ', $model->jenis_simkatmawa)), 'url' => [$model->jenis_simkatmawa]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="simkatmawa-mbkm-view">

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

                             
                        </div>

                        <div class="widget-body">
                            <div class="widget-main padding-24">
                                <div class="row">

                                    <?php
                                    if (!Yii::$app->user->isGuest) :
                                    ?>
                                        <p>
                                            <?= Html::a('<i class="fa fa-pencil"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                                            <?= Html::a('<i class="fa fa-trash"></i> Delete', ['delete', 'id' => $model->id, 'jenisSimkatmawa' => $model->jenis_simkatmawa], [
                                                'class' => 'btn btn-danger',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete this item?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>
                                        </p>
                                    <?php
                                    endif;
                                    ?>
                                </div>

                                <div class="space"></div>

                                <div class="row">
                                    <div class="col-md-6">

                                        <?= DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                'nama_program',
                                                'tempat_pelaksanaan',
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
                                                [
                                                    'attribute' => 'sk_penerimaan_path',
                                                    'label' => 'Surat Keterangan sebagai Peserta Program Wirausaha',
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        if (empty($model->sk_penerimaan_path)) {
                                                            return '-';
                                                        }
                                                        return Html::a('Unduh <i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'sk_penerimaan_path'], ['target' => '_blank', 'data-pjax' => 0]);
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'surat_tugas_path',
                                                    'label' => 'Surat Izin dari Fakultas',
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        if (empty($model->surat_tugas_path)) {
                                                            return '-';
                                                        }
                                                        return Html::a('Unduh <i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'surat_tugas_path'], ['target' => '_blank', 'data-pjax' => 0]);
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'laporan_path',
                                                    'label' => 'Laporan Akademik Pelaksanakan Kegiatan',
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        if (empty($model->laporan_path)) {
                                                            return '-';
                                                        }
                                                        return Html::a('Unduh <i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'laporan_path'], ['target' => '_blank', 'data-pjax' => 0]);
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