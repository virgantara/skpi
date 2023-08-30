<?php

use app\helpers\MyHelper;
use app\models\SimkatmawaRekognisi;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMbkm $model */

$this->title = $model->nama_kegiatan;
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Mandiri', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => ucwords(str_replace('-', ' ', $model->jenis_simkatmawa)), 'url' => [$model->jenis_simkatmawa]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$rekognisi = ArrayHelper::map(SimkatmawaRekognisi::find()->all(), 'id', 'nama');
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
                                <span class="blue"><?= $model->prodi->nama_prodi ?? "-" ?></span>

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
                                                'nama_kegiatan',
                                                [
                                                    'attribute' => 'simkatmawa_rekognisi_id',
                                                    'label' => 'Tingkat Pengakuan / Jenis Rekognisi',
                                                    'value' => function ($model) use ($rekognisi) {
                                                        return $rekognisi[$model->simkatmawa_rekognisi_id];
                                                    }
                                                ],
                                                'penyelenggara',
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
                                                    'attribute' => 'sertifikat_path',
                                                    'label' => 'Sertifikat',
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        if (empty($model->sertifikat_path)) {
                                                            return '-';
                                                        }
                                                        return Html::a('Unduh <i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'sertifikat_path'], ['target' => '_blank', 'data-pjax' => 0]);
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'surat_tugas_path',
                                                    'label' => 'Surat Undangan',
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        if (empty($model->surat_tugas_path)) {
                                                            return '-';
                                                        }
                                                        return Html::a('Unduh <i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'surat_tugas_path'], ['target' => '_blank', 'data-pjax' => 0]);
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'url_kegiatan',
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        if (empty($model->url_kegiatan)) {
                                                            return '-';
                                                        }
                                                        return Html::a('Link <i class="fa fa-link"></i>', MyHelper::setHttpUrl($model->url_kegiatan), ['target' => '_blank']);
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'foto_kegiatan_path',
                                                    'label' => 'Foto Kegiatan',
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        if (empty($model->foto_kegiatan_path)) {
                                                            return '-';
                                                        }
                                                        return Html::a('Unduh <i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'foto_kegiatan_path'], ['target' => '_blank', 'data-pjax' => 0]);
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'laporan_path',
                                                    'label' => 'Laporan',
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