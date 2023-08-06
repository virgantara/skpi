<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMandiri $model */

$this->title = $model->nama_kegiatan;
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Mandiri', 'url' => [$model->jenis_simkatmawa]];
$this->params['breadcrumbs'][] = ['label' => ucwords($model->jenis_simkatmawa), 'url' => [$model->jenis_simkatmawa]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="simkatmawa-mandiri-view">

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

                                <div>
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            'nama_kegiatan',
                                            'penyelenggara',
                                            'tempat_pelaksanaan',
                                            'simkatmawaRekognisi.nama',
                                            'level',
                                            'apresiasi',
                                            [
                                                'attribute' => 'url_kegiatan',
                                                'format' => 'raw',
                                                'hAlign' => 'center',
                                                'value' => function ($model) {
                                                    return Html::a('<i class="fa fa-link"></i>', $model->url_kegiatan, ['target' => '_blank']);
                                                }
                                            ],
                                            'tanggal_mulai',
                                            'tanggal_selesai',
                                            [
                                                'attribute' => 'sertifikat_path',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return Html::a('<i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'sertifikat_path'], ['target' => '_blank', 'data-pjax' => 0]);
                                                }
                                            ],
                                            [
                                                'attribute' => 'foto_penyerahan_path',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return Html::a('<i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'foto_penyerahan_path'], ['target' => '_blank', 'data-pjax' => 0]);
                                                }
                                            ],
                                            [
                                                'attribute' => 'foto_kegiatan_path',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return Html::a('<i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'foto_kegiatan_path'], ['target' => '_blank', 'data-pjax' => 0]);
                                                }
                                            ],
                                            [
                                                'attribute' => 'foto_karya_path',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return Html::a('<i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'foto_karya_path'], ['target' => '_blank', 'data-pjax' => 0]);
                                                }
                                            ],
                                            [
                                                'attribute' => 'surat_tugas_path',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return Html::a('<i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'surat_tugas_path'], ['target' => '_blank', 'data-pjax' => 0]);
                                                }
                                            ],
                                            [
                                                'attribute' => 'laporan_path',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return Html::a('<i class="fa fa-download"> </i>', ['download', 'id' => $model->id, 'file' => 'laporan_path'], ['target' => '_blank', 'data-pjax' => 0]);
                                                }
                                            ],
                                        ],
                                    ]) ?>
                                </div>

                                <div class="hr hr8 hr-double hr-dotted"></div>

                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th>NIM</th>
                                            <th>Nama Mahasiswa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($dataMahasiswa as $mhs) : ?>
                                            <tr>
                                                <td class="center"><?= $no ?></td>
                                                <td><?= $mhs->nim ?></td>
                                                <td><?= $mhs->nim0->nama_mahasiswa ?></td>
                                            </tr>
                                        <?php
                                            $no++;
                                        endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


</div>