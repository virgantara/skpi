<?php
use yii\helpers\Url;
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
            [
                // 'attribute' => 'foto_path',
                'format' => 'raw',
                'label' => 'Foto',
                'value' => function($data){
                    if(!empty($data->nim0->foto_path))
                        return Html::a(Html::img(Url::to(['mahasiswa/foto','id' => $data->nim0->id]),['width'=>'70px','loading' => 'lazy']),'',['class'=>'popupModal','data-item'=>Url::to(['mahasiswa/foto','id' => $data->nim0->id])]);
                    else
                        return '';
                }
            ],
            'nim',
            'namaMahasiswa',
            'namaDosen:raw',
            'namaProdi',
            'namaJenisMagang',
            'namaKotaInstansi',
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
            
            'status_magang_id',
            // 'file_laporan:raw',
            // 'file_sk_penerimaan_magang:raw',
            // 'file_surat_tugas:raw',
            // 'nilai_angka',
            // 'nilai_huruf',
            // 'matakuliah_id',
            // 'updated_at',
            // 'created_at',
        ],
    ]) ?>

            </div>
        </div>

    </div>
</div>
<?php
        yii\bootstrap\Modal::begin(['id' =>'modal','size'=>'modal-lg',]);
        echo '<div class="text-center">';
        echo '<img width="100%" id="img">';
        echo '</div>';
        yii\bootstrap\Modal::end();
    ?>

<?php

$this->registerJs("$(function() {

    $(document).on('click','.popupModal',function(e){
        e.preventDefault();
        var m = $('#modal').modal('show').find('#img');

        m.attr('src',$(this).data('item'))
    })
    
});");
?>