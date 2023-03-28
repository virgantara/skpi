<?php

use app\models\SimakKegiatanKompetensi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SimakKegiatanKompetensiSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Rincian Kegiatan Mahasiswa per Kompetensi';
$this->params['breadcrumbs'][] = $this->title;

$results = $hasil['results'][0];
$predikat = $hasil['predikat'][$hasil['kpt_id']];
//                 echo '<pre>';
//                 print_r($predikat);
// exit;
?>
<div class="simak-kegiatan-kompetensi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th >No</th>
                <th>Kompetensi</th>
                <th >Kategori</th>
                <th >Nama Kegiatan</th>
                <th>Instansi</th>
                <th >Nilai</th>
                
            </tr>
            
        </thead>
        <tbody>
            <?php 
            $i = 0;
            $total = 0;

            foreach($results as $keg){

                $keg = (object)$keg;
                $is_approved = $keg->is_approved;
                

                if($is_approved)
                {
                    $total += $keg->nilai;
                }
             ?>
            
            <tr>
                <td><?=$i+1?></td>
                <td><?=$predikat['kompetensi']?></td>
                <td><?=$keg->kategori?></td>
                <td><?=$keg->tema?></td>
                <td><?=$keg->instansi?></td>
                <td><?=$keg->nilai?></td>
        
            </tr>
            <?php 
                $i++;
                
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right">Total AKPAM</td>
                <td><?=$total?></td>
               
            </tr>
            <tr>
                <td colspan="6" class="text-center" style="font-size:1.5em">Total Nilai Kompetensi : <?=$predikat['nilai_akhir']?></td>
                
            </tr>
            <tr>
                <td colspan="6" class="text-center" style="font-size:1.5em;height: 32px">Predikat <span style="height: 32px;font-size: 100%" class="label label-<?= $predikat['color']; ?>"><?= $predikat['label']; ?></span></td>
                
            </tr>
        </tfoot>
    </table>

</div>
