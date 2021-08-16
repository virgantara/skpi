<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\daterange\DateRangePicker;

setlocale(LC_TIME, 'id_ID.utf8');
/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatanHarian */

$this->title = 'Rekap Kegiatan Harian';
$this->params['breadcrumbs'][] = ['label' => 'Kegiatan Harian', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$jenis_kegiatan = !empty($_GET['jenis_kegiatan']) ? $_GET['jenis_kegiatan'] : '';
$tanggal = !empty($_GET['tanggal']) ? $_GET['tanggal'] : '';

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
        <?=Html::dropDownList('jenis_kegiatan',$jenis_kegiatan,ArrayHelper::map($list_kategori,'kode','nama'));?>
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
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Kegiatan</th>
                    <th rowspan="2">Tanggal</th>
                    <th rowspan="2">Kampus</th>
                    <th colspan="2" class="text-center">Total (mhs)</th>
                </tr>
                <tr>
                    <th class="text-center">Hadir</th>
                    <th class="text-center" class="text-center">Ghoib</th>
                </tr>
            </thead>
            <tbody>
                <?php 


                $i = 0;
                foreach($results as $res)
                {
                    $total_mhs = $list_kampus[$res['kode_kampus']];

                    $hari = new \DateTime($res['tgl']);
                    $d = strftime('%A, %d %B %Y', $hari->getTimestamp());
                ?>
                <tr>
                    <td><?=$i+1;?></td>
                    <td><?=$res['nama_kegiatan'];?></td>
                    <td><?=$d;?></td>
                    <td><?=$res['nama_kampus'];?></td>
                    <td class="text-center"><?=$res['total'];?></td>
                    <td class="text-center"><?=$total_mhs - $res['total'];?></td>
                </tr>
                <?php 
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>