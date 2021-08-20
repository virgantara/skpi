<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\daterange\DateRangePicker;
use app\assets\DatatableAsset;
DatatableAsset::register($this);

setlocale(LC_TIME, 'id_ID.utf8');
/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatanHarian */

$this->title = 'Rekap Kegiatan Harian';
$this->params['breadcrumbs'][] = ['label' => 'Kegiatan Harian', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$jenis_kegiatan = !empty($_GET['jenis_kegiatan']) ? $_GET['jenis_kegiatan'] : '';
$tanggal = !empty($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d').' hingga '.date('Y-m-d');
$kampus = !empty($_GET['kampus']) ? $_GET['kampus'] : '';
$kegiatan = !empty($_GET['kegiatan']) ? $_GET['kegiatan'] : '';
$list_kampus = ArrayHelper::map(\app\models\SimakKampus::getList(),'kode_kampus','nama_kampus');
?>
<div class="simak-kegiatan-harian-view">

    <h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'options' => [
            'tag' => false,
        ],
    ],
    'method' => 'GET',
    'action' => Url::to(['simak-kegiatan-harian/rekap']),
    'options' => [
        'class' => 'form-horizontal'
    ]
]); ?>
<div class="form-group" >
    <label class="col-sm-3 control-label no-padding-right">Jenis Kegiatan</label>
    <div class="col-sm-9">
        <?=Html::dropDownList('jenis_kegiatan',$jenis_kegiatan,ArrayHelper::map($list_kategori,'kode','nama'),['id'=>'jenis_kegiatan']);?>
    </div>
</div> 
<div class="form-group" >
    <label class="col-sm-3 control-label no-padding-right">Kegiatan</label>
    <div class="col-sm-9">
        <?=Html::dropDownList('kegiatan',$kegiatan,[],['id'=>'kegiatan']);?>
    </div>
</div>  
<div class="form-group" >
    <label class="col-sm-3 control-label no-padding-right">Kelas</label>
    <div class="col-sm-9">
        <?=Html::dropDownList('kampus',$kampus,$list_kampus);?>
    </div>
</div>  
<div class="form-group" >
    <label class="col-sm-3 control-label no-padding-right">Periode</label>
    <div class="col-sm-9">
        <?php 

// echo '<div class="drp-container">';
echo DateRangePicker::widget([
    'name'=>'tanggal',
    'convertFormat'=>true,
    'value' => $tanggal,
    // 'presetDropdown'=>true,
    // 'includeMonthsFilter'=>true,
    'pluginOptions' => [
        'locale' => [
            'format' => 'Y-m-d',
            'separator'=>' hingga ',
        ],
        // 'opens' => 'left'

    ],
    'options' => ['placeholder' => 'Select range...','class'=>'form-control']
]);
// echo '</div>';
        ?>
    </div>
</div>  

<div class="clearfix form-actions">
    <div class="col-md-offset-3 col-md-9">

        <button class="btn btn-info" value="1" type="submit" name="btn-search">
            <i class="ace-icon glyphicon glyphicon-search bigger-110"></i>
            Apply Filter
        </button>

    </div>
</div>
<?php ActiveForm::end(); ?>

</div>

<div class="row">
    <div class="col-md-12">
        <table id="dynamic-table" class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kegiatan</th>
                    <th>Tanggal</th>
                    <th>Prodi</th>
                    <th class="text-center">Hadir</th>
                    <th class="text-center">Ghoib</th>
                    <th class="text-center">Kehadiran (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php 


                $i = 0;
                foreach($results as $res)
                {
                    $total_mhs = $list_prodi[$res['kode_prodi']];

                    $hari = new \DateTime($res['tgl']);
                    $d = strftime('%A, %d %B %Y', $hari->getTimestamp());
                    $ghoib = $total_mhs - $res['total'];
                    $persentase = round($res['total'] / $total_mhs * 100,2);
                ?>
                <tr>
                    <td><?=$i+1;?></td>
                    <td><?=$res['nama_kegiatan'];?> - <?=$res['sub_kegiatan'];?></td>
                    <td><?=$d;?></td>
                    <td><?=$res['nama_prodi'];?></td>
                    <td class="text-center"><?=$res['total'];?></td>
                    <td class="text-center"><?=$ghoib;?></td>
                    <td class="text-center"><?=$persentase;?></td>
                </tr>
                <?php 
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<?php
$script = '
var myTable = $(\'#dynamic-table\')
    .DataTable( {
        pageLength: 50,
        bAutoWidth: false,
        "aoColumns": [
          { "bSortable": false },
          null, null,null, null, null,
          null
        ],
        "aaSorting": [],
        select: {
            style: \'multi\'
        }
    } );
$("#jenis_kegiatan").change(function(e){
    getListKegiatanHarian($(this).val())
})

$("#jenis_kegiatan").trigger("change")

function getListKegiatanHarian(kategori){
    
    var obj = new Object;
    obj.kategori = kategori;
   
    $.ajax({

        type : "POST",
        url : "'.Url::to(['/simak-kegiatan-harian/ajax-list-kegiatan-harian']).'",
        data : {
          dataPost : obj
        },
        async : true,
        error : function(e){
        },
        beforeSend : function(){

        },
        success: function(hasil){
            $("#kegiatan").empty()
            var hasil = $.parseJSON(hasil);
            
            var row = "";

            $.each(hasil, function(i, obj){
                row += "<option value=\'"+obj.kode+"\'>"+obj.nama+"</option>"
            })

            $("#kegiatan").append(row)
            $("#kegiatan").val("'.$kegiatan.'")
        }
    });
}

';
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);


?>
