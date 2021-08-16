<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SimakKegiatanHarianMahasiswaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kegiatan Harian Mahasiswa';
$this->params['breadcrumbs'][] = $this->title;

$list_prodi = ArrayHelper::map(\app\models\SimakMasterprogramstudi::find()->orderBy(['kode_fakultas' => SORT_ASC,'kode_prodi'=> SORT_ASC])->all(),'kode_prodi','nama_prodi');

?>
<div class="simak-kegiatan-harian-mahasiswa-index">

    <h1><?= Html::encode($this->title) ?></h1>

  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'kode_kegiatan',
                'value' => function ($data){
                    return !empty($data->kodeKegiatan) && !empty($data->kodeKegiatan->kegiatan) ? $data->kodeKegiatan->kegiatan->nama_kegiatan.' - '.$data->kodeKegiatan->kegiatan->sub_kegiatan : '-';
                }
            ],
            'nim',
            'namaMahasiswa',
            [
                'attribute' => 'namaProdi',
                'filter' => $list_prodi,
                
            ],
            'semester',
            'tahun_akademik',

            'poin',
            'waktu',
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'view' => function ($model) {
                        return \Yii::$app->user->can('admin');
                    },
                    'update' => function ($model) {
                        return \Yii::$app->user->can('admin');
                    },
                    'delete' => function ($model) {
                        return \Yii::$app->user->can('admin');
                    },
                ]
            ],
        ]; ?>
     <?= GridView::widget([
        'responsiveWrap' => false,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'containerOptions' => ['style' => 'overflow: auto'], 
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'beforeHeader'=>[
            [
                'columns'=>[
                    ['content'=> $this->title, 'options'=>['colspan'=>18, 'class'=>'text-center warning']], //cuma satu kolom header
            //        ['content'=>'', 'options'=>['colspan'=>0, 'class'=>'text-center warning']], //uncomment kalau mau membuat header kolom-2
              //      ['content'=>'', 'options'=>['colspan'=>0, 'class'=>'text-center warning']],
                ], //uncomment kalau mau membuat header kolom-3
                'options'=>['class'=>'skip-export'] 
            ]
        ],
        'exportConfig' => [
              // GridView::PDF => ['label' => 'Save as PDF'],
              GridView::EXCEL => ['label' => 'Save as EXCEL'], //untuk menghidupkan button export ke Excell
              // GridView::HTML => ['label' => 'Save as HTML'], //untuk menghidupkan button export ke HTML
              GridView::CSV => ['label' => 'Save as CSV'], //untuk menghidupkan button export ke CVS
          ],
          
        'toolbar' =>  [
            '{export}', 

           '{toggleData}' //uncoment untuk menghidupkan button menampilkan semua data..
        ],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
    // set export properties
        'export' => [
            'fontAwesome' => true
        ],
        'pjax' => true,
        'pjaxSettings' =>[
            'neverTimeout'=>true,
            'options'=>[
                'id'=>'pjax_id',
            ]
        ],  
        'bordered' => true,
        'striped' => true,
        // 'condensed' => false,
        // 'responsive' => false,
        'hover' => true,
        // 'floatHeader' => true,
        // 'showPageSummary' => true, //true untuk menjumlahkan nilai di suatu kolom, kebetulan pada contoh tidak ada angka.
        'panel' => [
            'type' => GridView::TYPE_PRIMARY
        ],
    ]); ?>
</div>


<?php

$this->registerJs(' 


setInterval(function(){ 
    $.pjax.reload({container:"#pjax_id"}) 
}, 30000);

', \yii\web\View::POS_READY);

?>
