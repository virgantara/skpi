<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SimakLayananSurat */

$this->title = $model->nim . ' - ' . $model->keperluan;
$this->params['breadcrumbs'][] = ['label' => 'Layanan Surat', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$list_status_ajuan = [
    0 => 'BELUM DISETUJUI',
    1 => 'DISETUJUI',
    2 => 'DITOLAK',
];
?>
<div class="block-header">
    <h2><?= Html::encode($this->title) ?></h2>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <?php
                if (Yii::$app->user->can('operatorUnit') || Yii::$app->user->can('operatorCabang')) {
                    echo Html::a('<i class="fa fa-edit"></i> Approval', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                }

                echo ' ';

                if ($model->status_ajuan == '1') {
                    echo Html::a('<i class="fa fa-download"></i> Download', ['download', 'id' => $model->id], ['class' => 'btn btn-success', 'target' => '_blank']);
                }
                ?>
            </div>

            <div class="panel-body ">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'nim',
                        [
                            'attribute' => 'namaMahasiswa',
                            'value' => function($data){
                                return !empty($data->nim0) ? $data->nim0->nama_mahasiswa : null;
                            }
                        ],
                        [
                            'attribute' => 'namaProdi',

                            'value' => function($data){
                                return $data->nim0->kodeProdi->nama_prodi;
                            }
                        ],
                        [
                            'label' => 'Semester',
                            // 'filter' => ArrayHelper::map($list_tahun,'id','nama_tahun'),
                            'value' => function($data){
                                return $data->nim0->semester;
                            }
                        ],
                        'tahun.nama_tahun',
                        'keperluan:ntext',
                        'bahasa',
                        'tanggal_diajukan',
                        'tanggal_disetujui',
                        'nomor_surat',
                        // 'nama_pejabat',
                        [
                            'attribute' => 'status_ajuan',
                            'filter' => $list_status_ajuan,
                            'value' => function ($data) use ($list_status_ajuan) {
                                return $list_status_ajuan[$data->status_ajuan];
                            }
                        ],

                    ],
                ]) ?>

            </div>
        </div>

    </div>
</div>