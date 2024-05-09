<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProgramStudi */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Program Studis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="block-header">
    <h2><?= Html::encode($this->title) ?></h2>
</div>
<div class="row">
   <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>

            <div class="panel-body ">
        
<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'kode_fakultas',
            'kode_jurusan',
            'kode_prodi',
            'kode_prodi_dikti',
            'kode_jenjang_studi',
            'gelar_lulusan',
            'gelar_lulusan_en',
            'gelar_lulusan_short',
            'nama_prodi',
            'nama_prodi_en',
            'domain_email:email',
            'semester_awal',
            'no_sk_dikti',
            'tgl_sk_dikti',
            'tgl_akhir_sk_dikti',
            'jml_sks_lulus',
            'kode_status',
            'tahun_semester_mulai',
            'email_prodi:email',
            'tgl_pendirian_program_studi',
            'no_sk_akreditasi',
            'tgl_sk_akreditasi',
            'tgl_akhir_sk_akreditasi',
            'kode_status_akreditasi',
            'frekuensi_kurikulum',
            'pelaksanaan_kurikulum',
            'nidn_ketua_prodi',
            'telp_ketua_prodi',
            'fax_prodi',
            'nama_operator',
            'hp_operator',
            'telepon_program_studi',
            'singkatan',
            'kode_feeder',
            'kode_nim',
        ],
    ]) ?>

            </div>
        </div>

    </div>
</div>