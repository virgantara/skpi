<?php

use yii\helpers\Html;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model app\models\SkpiPermohonan */

$this->title = $model->nim0->nama_mahasiswa;
$this->params['breadcrumbs'][] = ['label' => 'Skpi Permohonans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

Yii::$app->language = 'id-ID'; 


$list_status_pengajuan = [
    '0' =>'BELUM DISETUJUI',
    '1' =>'DISETUJUI',
    '2' =>'DITOLAK'
];
?>
<div class="block-header">
    <h2><?= Html::encode($this->title) ?></h2>
</div>
<div class="row">
   <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <?= Html::a('<i class="fa fa-save"></i> Simpan', '#', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-check"></i> Approval', ['update', 'id' => $model->id], ['class' => 'btn btn-inverse']) ?>
                <?= Html::a('<i class="fa fa-download"></i> Download', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            </div>

            <div class="panel-body ">
                <h3>Mahasiswa</h3>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th style='width: 20%;' >NIM</th>
                        <td><?=$model->nim?></td>
                    </tr>
                    <tr>
                        <th>Nama Mahasiswa</th>
                        <td><?=$model->nim0->nama_mahasiswa?></td>
                    </tr>
                    <tr>
                        <th>Tempat & Tanggal Lahir</th>
                        <td><?=$model->nim0->tempat_lahir.', '.\app\helpers\MyHelper::convertTanggalIndo($model->nim0->tgl_lahir)?></td>
                    </tr>
                    <tr>
                        <th>Prodi</th>
                        <td><?=$model->nim0->kodeProdi->nama_prodi?></td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td><?=$model->nim0->kampus0->nama_kampus?></td>
                    </tr>
                    <tr>
                        <th>Tahun Lulus</th>
                        <td><?=(isset($model->nim0->tgl_lulus) ? date('Y',strtotime($model->nim0->tgl_lulus)) : null)?></td>
                    </tr>
                    <tr>
                        <th>Lama Studi</th>
                        <td>
                        <?php
                            if(!empty($model->nim0->tgl_lulus) && $model->nim0->tgl_lulus != '1970-01-01' && !empty($model->nim0->tgl_masuk)){
                                $d1 = new DateTime($model->nim0->tgl_masuk);
                                $d2 = new DateTime($model->nim0->tgl_lulus);

                                $diff = $d2->diff($d1);

                                echo round($diff->y + ($diff->m / 12),1).' tahun';
                            }

                        ?>
                                
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <td><?=\app\helpers\MyHelper::convertTanggalIndo($model->tanggal_pengajuan)?></td>
                    </tr>
                    <tr>
                        <th>Nomor Ijazah</th>
                        <td><?=$model->nim0->no_ijazah?></td>
                    </tr>
                    <tr>
                        <th>Nomor SKPI</th>
                        <td><?=Html::textInput('nomor_skpi',$model->nomor_skpi,['class' => 'form-control'])?></td>
                    </tr>
                    <tr>
                        <th>Link Barcode</th>
                        <td><?=Html::textInput('link_barcode',$model->link_barcode,['class' => 'form-control'])?></td>
                    </tr>
                    <tr>
                        <th>Status Pengajuan</th>
                        <td><?=$list_status_pengajuan[$model->status_pengajuan]?></td>
                    </tr>
                </table>
                <h3>Evaluasi</h3>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th style='width: 20%;' ><?=Yii::t('app', 'Description')?><br><i>Description</i></th>
                        <td width="40%">
                            <?= CKEditor::widget([
                                'name' => 'deskripsi',
                                'value' => $model->deskripsi,
                                'options' => ['rows' => 6],
                                'preset' => 'advance',
                                'clientOptions' => [
                                    'enterMode' => 2,
                                    'forceEnterMode' => false,
                                    'shiftEnterMode' => 1
                                ]
                            ]) ?>        
                        </td>
                        <td>
                            <?= CKEditor::widget([
                                'name' => 'deskripsi_en',
                                'value' => $model->deskripsi_en,
                                'options' => ['rows' => 6],
                                'preset' => 'advance',
                                'clientOptions' => [
                                    'enterMode' => 2,
                                    'forceEnterMode' => false,
                                    'shiftEnterMode' => 1
                                ]
                            ]) ?>    
                        </td>
                    </tr>
                </table>

                <h3>Nilai Induk Kompetensi</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                    </tbody>
                </table>

                <h3>Nilai Kompetensi</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>