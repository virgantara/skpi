<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SimakMagang */

$this->title = $model->nama_instansi;
$this->params['breadcrumbs'][] = ['label' => 'Magang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
   <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3><?= Html::encode($this->title) ?></h3>
               
            </div>

            <div class="panel-body ">
        
<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'nim',
            'jenis_magang_id',
            'nama_instansi',
            'alamat_instansi',
            'telp_instansi',
            'email_instansi:email',
            'nama_pembina_instansi',
            'jabatan_pembina_instansi',
            'kota_instansi',
            'is_dalam_negeri',
            'tanggal_mulai_magang',
            'tanggal_selesai_magang',
            'status',
            'keterangan:ntext',
            'pembimbing_id',
            'status_magang_id',
            'file_laporan:raw',
            'file_sk_penerimaan_magang:raw',
            'file_surat_tugas:raw',
            'nilai_angka',
            'nilai_huruf',
            'matakuliah_id',
            'updated_at',
            'created_at',
        ],
    ]) ?>

            </div>
        </div>

    </div>
</div>