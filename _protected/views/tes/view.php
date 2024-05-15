<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SimakTes */

$this->title = $model->nama_tes;
$this->params['breadcrumbs'][] = ['label' => 'Simak Tes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$list_jenis_tes= \app\helpers\MyHelper::getJenisTes();
$list_status_validasi = \app\helpers\MyHelper::getStatusValidasi();

?>
<div class="block-header">
    <h2><?= Html::encode($this->title) ?></h2>
</div>
<div class="row">
   <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <?php 
                if(Yii::$app->user->can('akpamPusat')|| Yii::$app->user->can('sekretearis')||Yii::$app->user->can('fakultas')){
                    echo Html::a('<i class="fa fa-check"></i> Validasi', ['validasi', 'id' => $model->id], ['class' => 'btn btn-success']) ;
                }
                
                else if(Yii::$app->user->can('Mahasiswa')){

                    echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                }
             ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>

            <div class="panel-body ">

<h3>Info Mahasiswa</h3>
<?= DetailView::widget([
        'model' => $mhs,
        'attributes' => [
            'nim_mhs',
            [
                'label' => 'Nama Mahasiswa',
                'value' => function($data){
                    return $data->nama_mahasiswa;
                }
            ],
            [
                'label' => 'Prodi',
                'value' => function($data){
                    return $data->kodeProdi->nama_prodi;
                }
            ],
            [
                'label' => 'Angkatan',
                'value' => function($data){
                    return $data->tahun_masuk;
                }
            ],
            
        ],
    ]) ?>
    <h3>Info Tes</h3>
<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            [
                'attribute' => 'jenis_tes',
                'value' => function($data) use ($list_jenis_tes){
                    return $list_jenis_tes[$data->jenis_tes];
                }
            ],
            'nama_tes',
            'penyelenggara',
            'tanggal_tes',
            'tahun',
            'skor_tes',
            [
                'attribute'=>'file_path',
                'format'=>'raw',
                'value' => function($data){
                if(!empty($data->file_path)){
                  return Html::a('<i class="fa fa-download"></i> Download', ['tes/download', 'id' => $data->id],['class' => 'btn btn-primary','target'=>'_blank']);
                }
                else
                {
                    return "<p class='btn btn-danger' align='center'>No File</p>";
                }
                }
            ],
            [
                'attribute' => 'status_validasi',
                'value' => function($data) use ($list_status_validasi){
                    return $list_status_validasi[$data->status_validasi];
                }
            ],
            [
                'attribute' => 'approved_by',
                'value' => function($data) {
                    return (!empty($data->approvedBy) ? $data->approvedBy->display_name : '-');
                }
            ],
            'catatan',
        ],
    ]) ?>

            </div>
        </div>

    </div>
</div>