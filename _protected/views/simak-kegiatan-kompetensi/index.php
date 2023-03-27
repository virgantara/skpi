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
            foreach($results[0] as $keg){
                // echo '<pre>';
                // print_r($results);exit;
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
                <td colspan="3" class="text-right">Total</td>
                <td><?=$total?></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

</div>
