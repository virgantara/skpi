<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
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
        <?php
        if (Yii::$app->user->identity->access_role != 'operatorUnit') {
            echo Html::a('Create Pelanggaran', ['cari-mahasiswa'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>


    <?php
    $gridColumns = [
        [
            'class' => 'kartik\grid\SerialColumn',
            'contentOptions' => ['class' => 'kartik-sheet-style'],
            'width' => '36px',
            'pageSummary' => 'Total',
            'pageSummaryOptions' => ['colspan' => 6],
            'header' => '',
            'headerOptions' => ['class' => 'kartik-sheet-style']
        ],
        [
            'header' => 'Foto',
            'format' => 'raw',
            'value' => function ($data) {
                if (!empty($data->nim0->foto_path)) {
                    // // return Html::img(Url::to(['simak-mastermahasiswa/foto','id'=>$data->id]),['width'=>'70px']);
                    // return Html::a(Html::img($data->foto_path,['width'=>'70px']),'',['class'=>'popupModal','data-pjax'=>0,'data-item'=>$data->foto_path]);
                    return Html::a(Html::img(Url::to(['mahasiswa/foto', 'id' => $data->nim0->id]), ['width' => '70px']), '', ['class' => 'popupModal', 'data-pjax' => 0, 'loading' => 'lazy', 'data-item' => Url::to(['mahasiswa/foto', 'id' => $data->nim0->id])]);
                } else
                    return '';
            }
        ],

        'nim',
        'namaMahasiswa',

        [
            'attribute' => 'namaProdi',
            'label' => 'Prodi',
            'format' => 'raw',
            'filter' => $prodis,
            'value' => function ($model, $url) {
                return $model->namaProdi;
            },
        ],
        'semester',
        [
            'attribute' => 'namaAsrama',
            'label' => 'Asrama',
            'format' => 'raw',
            'filter' => $asramas,
            'value' => function ($model, $url) {
                return $model->namaAsrama;
            },
        ],
        'namaKamar',
        'kodePelanggaran',
        'namaPelanggaran',
        [
            'attribute' => 'tanggal',
            'value' => 'tanggal',
            'filterType' => GridView::FILTER_DATE_RANGE,
            // 'filter' => \yii\jui\DatePicker::widget(['language' => 'en', 'dateFormat' => 'yyyy-MM-dd']),
            // 'format' => 'html',
        ],
        [
            'attribute' => 'namaKategori',
            'label' => 'Kategori',
            'format' => 'raw',
            'filter' => ["RINGAN" => "RINGAN", "SEDANG" => "SEDANG", "BERAT" => "BERAT"],
            'value' => function ($model, $url) {

                $st = '';
                $label = '';

                $label = $model->namaKategori;
                if ($model->namaKategori == 'RINGAN')
                    $st = 'success';
                else if ($model->namaKategori == 'SEDANG')
                    $st = 'warning';
                else if ($model->namaKategori == 'BERAT')
                    $st = 'danger';



                return '<button type="button" class="btn btn-' . $st . ' btn-sm" >
                       <span>' . $label . '</span>
                    </button>';
            },
        ],

        [
            'attribute' => 'status_kasus',
            'format' => 'raw',
            'filter' => ["0" => "WAITING", "1" => "ON-PROCESS", "2" => "CLOSED"],
            'value' => function ($model, $url) {
                $val = ["0" => "WAITING", "1" => "ON-PROCESS", "2" => "CLOSED"];
                $st = '';
                $label = !empty($val[$model->status_kasus]) ? $val[$model->status_kasus] : '-';
                if ($model->status_kasus == '2')
                    $st = 'success arrowed-in arrowed-in-right';
                else if ($model->status_kasus == '1')
                    $st = 'warning arrowed-in-right';
                else if ($model->status_kasus == '0')
                    $st = 'default arrowed-in';



                return '<span type="button" class="label label-' . $st . ' " >' . $label . '</span>';
            },
        ],
        [
            'header' => 'Unduh Dokumen',
            'format' => 'raw',
            'value' => function ($data) {
                $html = '';
                if (!empty($data->surat_pernyataan)) {
                    $html .= Html::a('<i class="fa fa-download"></i> Surat Pernyataan', ['riwayat-pelanggaran/download-surat-pernyataan', 'id' => $data->id], ['title' => 'Download Surat Pernyataan', 'style' => 'margin-bottom:3px', 'class' => 'btn btn-primary btn-sm']);
                }

                if (!empty($data->bukti)) {
                    $html .= Html::a('<i class="fa fa-download"></i> Bukti/Foto', ['riwayat-pelanggaran/download-bukti', 'id' => $data->id], ['title' => 'Download Bukti', 'target' => '_blank', 'class' => 'btn btn-primary btn-sm']);
                }

                return $html;
            }
        ],
        [
            'attribute' => 'statusAktif',
            'label' => 'Status Aktif',
            'format' => 'raw',
            'filter' => $status_aktif,
            'value' => function ($model, $url) {
                return $model->statusAktif;
            },
        ],


        //'created_at',
        //'updated_at',

        ['class' => 'yii\grid\ActionColumn'],
    ];
    ?>
    <div class="table-responsive">

        <?= GridView::widget([
            'responsiveWrap' => false,
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'containerOptions' => ['style' => 'overflow: auto'],
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'containerOptions' => ['style' => 'overflow: auto'],
            'beforeHeader' => [
                [
                    'columns' => [
                        ['content' => $this->title, 'options' => ['colspan' => 14, 'class' => 'text-center warning']], //cuma satu 
                    ],
                    'options' => ['class' => 'skip-export']
                ]
            ],
            'exportConfig' => [
                GridView::PDF => ['label' => 'Save as PDF'],
                GridView::EXCEL => ['label' => 'Save as EXCEL'], //untuk menghidupkan button export ke Excell
                GridView::HTML => ['label' => 'Save as HTML'], //untuk menghidupkan button export ke HTML
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


</div>

<?php
yii\bootstrap\Modal::begin(['id' => 'modal', 'size' => 'modal-lg',]);
echo '<div class="text-center">';
echo '<img width="100%" id="img">';
echo '</div>';
yii\bootstrap\Modal::end();
?>
<?php

$this->registerJs('

    $(document).on("click",".popupModal",function(e){
        e.preventDefault();
        var m = $("#modal").modal("show").find("#img");

        m.attr("src",$(this).data("item"))
    })

    $("#btn-tambah-pelanggaran").on(ace.click_event, function() {
        
    });

    
', \yii\web\View::POS_READY);

?>

</div>