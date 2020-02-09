<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RiwayatPelanggaranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Riwayat Pelanggaran';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="riwayat-pelanggaran-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Pelanggaran', ['cari-mahasiswa'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
     <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'tanggal',
            'nim',
            'namaMahasiswa',
            'namaFakultas',
            'namaProdi',
            'semester',
            [
                'attribute' => 'namaAsrama',
                'label' => 'Kategori',
                'format' => 'raw',
                'filter'=>$asramas,
                'value'=>function($model,$url){
                    $label = $model->namaAsrama;
                    return '<span class="label label-info " >'.$label.'</span>';
                    
                },
            ],
            'namaKamar',
            'namaPelanggaran',
            [
                'attribute' => 'namaKategori',
                'label' => 'Kategori',
                'format' => 'raw',
                'filter'=>["RINGAN"=>"RINGAN","SEDANG"=>"SEDANG","BERAT"=>"BERAT"],
                'value'=>function($model,$url){

                    $st = '';
                    $label = '';

                    $label = $model->namaKategori;
                    if($model->namaKategori == 'RINGAN')
                        $st = 'success';
                    else if($model->namaKategori == 'SEDANG')
                        $st = 'warning';
                    else if($model->namaKategori == 'BERAT')
                        $st = 'danger';
                    
                    
                    
                    return '<button type="button" class="btn btn-'.$st.' btn-sm" >
                               <span>'.$label.'</span>
                            </button>';
                    
                },
            ],
            
            'pelapor',
            'statusAktif',
            

            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
    <?php Pjax::end(); ?>

</div>
