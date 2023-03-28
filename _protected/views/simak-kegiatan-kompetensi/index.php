<?php

use app\models\SimakKegiatanKompetensi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SimakKegiatanKompetensiSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kegiatan Kompetensi';
$this->params['breadcrumbs'][] = $this->title;

$results = $hasil['results'][0];
$predikat = $hasil['predikat'][$hasil['kpt_id']];

?>
<div class="simak-kegiatan-kompetensi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Kategori</th>
                <th rowspan="2">Nama Kegiatan</th>
                <th rowspan="2">Nilai</th>
                
            </tr>
            
        </thead>
        <tbody>
            <?php 
            $i = 0;
            $total = 0;

            foreach($results as $keg){
                // echo '<pre>';
                // print_r($keg);
                // print_r();exit;
                $keg = (object)$keg;
                $is_approved = $keg->is_approved;
                

                if($is_approved)
                {
                    $total += $keg->nilai;
                }
             ?>
            
            <tr>
                <td><?=$i+1?></td>
                <td><?=$keg->kategori?></td>
                <td><?=$keg->tema?></td>
                <td><?=$keg->nilai?></td>
        
            </tr>
            <?php 
                $i++;
                
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right">Total AKPAM</td>
                <td><?=$total?></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right" style="font-size:1.5em">Total Nilai Kompetensi</td>
                <td style="font-size:1.5em"><?=$predikat['nilai_akhir']?></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right" style="font-size:1.5em">Predikat</td>
                <td ><span style="font-size:1.5em;height: 32px" class="label label-<?= $predikat['color']; ?>"><?= $predikat['label']; ?></span></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

</div>
