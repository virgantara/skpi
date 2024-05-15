<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SimakPrestasi */

$this->title = $model->nim;
$this->params['breadcrumbs'][] = ['label' => 'Simak Prestasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

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
                if(Yii::$app->user->can('akpamPusat') || Yii::$app->user->can('sekretearis')||Yii::$app->user->can('fakultas')){
                    echo Html::a('<i class="fa fa-check"></i> Validasi', ['validasi', 'id' => $model->id], ['class' => 'btn btn-success']) ;
                }
                 ?>
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
            
            'nim',
            [
                'attribute' => 'namaMahasiswa',
                'value' => function($data){
                    return !empty($data->nim0) ? $data->nim0->nama_mahasiswa : null;
                }
            ],
        
            [
                'label' => 'Prodi',
                // 'filter' => $list_prodi,
                'value' => function($data){
                    return $data->nim0->kodeProdi->nama_prodi;
                }
            ],
            [
                'label' => 'Kelas',
                // 'filter' => $list_kampus,
                'value' => function($data){
                    return $data->nim0->kampus0->nama_kampus;
                }
            ],
            [
                'attribute' => 'kegiatan_id',
                'label' => 'Prestasi',
                'value' => function($data){
                    $label = '';
                    if(!empty($data->kegiatan) && !empty($data->kegiatan->kegiatan)){

                        $label .= $data->kegiatan->tema.' - '.$data->kegiatan->kegiatan->nama_kegiatan.' - '.$data->kegiatan->instansi;

                        if(!empty($data->kegiatan->jenisKegiatan))
                            $label .= ' - '.$data->kegiatan->jenisKegiatan->nama_jenis_kegiatan;
                    }

                    

                    

                    return $label;
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
            'catatan:html',
            'updated_at',
            'created_at',
        ],
    ]) ?>

            </div>
        </div>

    </div>
</div>