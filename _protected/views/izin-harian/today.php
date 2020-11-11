<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\assets\DatatableAsset;
DatatableAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\IzinHarianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Perizinan Keluar-Masuk Hari Ini tanggal '.date('d M Y');
$this->params['breadcrumbs'][] = $this->title;
?>
<h3><?=$this->title;?></h3>
<!-- <div class="row">
    <div class="col-xs-12">
        <h3 class="header smaller lighter blue">jQuery dataTables</h3>

        <div class="clearfix">
            <div class="pull-right tableTools-container"></div>
        </div>
        <div class="table-header">
            Results for "Latest Registered Domains"
        </div>
        <div>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th>Domain</th>
                        <th>Price</th>
                        <th class="hidden-480">Clicks</th>

                        <th>
                            <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                            Update
                        </th>
                        <th class="hidden-480">Status</th>

                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </td>

                        <td>
                            <a href="#">app.com</a>
                        </td>
                        <td>$45</td>
                        <td class="hidden-480">3,330</td>
                        <td>Feb 12</td>

                        <td class="hidden-480">
                            <span class="label label-sm label-warning">Expiring</span>
                        </td>

                        <td>
                            
                        </td>
                    </tr>
                    <tr>
                        <td class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </td>

                        <td>
                            <a href="#">app.com</a>
                        </td>
                        <td>$35</td>
                        <td class="hidden-480">3,130</td>
                        <td>Feb 12</td>

                        <td class="hidden-480">
                            <span class="label label-sm label-warning">Expiring</span>
                        </td>

                        <td>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div> -->
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th  class="hidden-xs hidden-sm">NIM</th>
                        <th>NAMA</th>
                        <th class="hidden-xs hidden-sm">Smt</th>
                        <th class="hidden-xs hidden-sm">Prodi / Asrama</th>
                        <th>Waktu Keluar</th>
                        <th>Waktu Masuk</th>
                        <th>Durasi</th>
                        <th class="hidden-xs hidden-sm">Total Izin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($results as $q => $m)
                    {
                        $mhs = $m['mhs'];

                        $rows = count($m['izin']);

                        $izin = $m['izin'][0];
                        $date1 = new DateTime($izin->waktu_masuk);
                        $date2 = new DateTime($izin->waktu_keluar);
                        $durasi = $date2->diff($date1);
                        $durasi_label = $durasi->h.' jam '.$durasi->i.' menit '.$durasi->s.' detik';
                    ?>
                    <tr>
                        <td  rowspan="<?=$rows;?>"><?=$q+1;?></td>
                        <td class="hidden-xs hidden-sm" rowspan="<?=$rows;?>"><?=$mhs->nim_mhs;?></td>
                        <td  rowspan="<?=$rows;?>"><?=$mhs->nama_mahasiswa;?></td>
                        <td class="hidden-xs hidden-sm"  rowspan="<?=$rows;?>"><?=$mhs->semester;?></td>
                        <td class="hidden-xs hidden-sm"  rowspan="<?=$rows;?>">
                            <?=$mhs->namaProdi;?>
                            <br><?=$mhs->kamar->asrama->nama;?> (<?=$mhs->kamar->nama;?>)
                        </td>
                        <td><?=$izin->waktu_keluar;?></td>
                        <td><?=$izin->waktu_masuk;?></td>
                        <td><?=$durasi_label;?></td>
                        <td class="hidden-xs hidden-sm" rowspan="<?=$rows;?>"><?=$rows;?> kali</td>
                    </tr>
                    <?php 
                        for($i=1;$i<$rows;$i++)
                        {
                            $izin = $m['izin'][$i];
                            $date1 = new DateTime($izin->waktu_masuk);
                            $date2 = new DateTime($izin->waktu_keluar);
                            $durasi = $date2->diff($date1);
                            $durasi_label = $durasi->h.' jam '.$durasi->i.' menit '.$durasi->s.' detik';
                        ?>
                        <tr>
                        <?php 
                        if($rows == 1){
                        ?>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <?php 
                        }
                        ?>
                        <td><?=$izin->waktu_keluar;?></td>
                        <td><?=$izin->waktu_masuk;?></td>
                        <td><?=$durasi_label;?></td>
                    </tr>
                        <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 

$script = '
    var myTable = $(\'#dynamic-table\')
    .DataTable( {
        bAutoWidth: false,
        "aoColumns": [
          { "bSortable": false },
          null, null,null, null, null,
          { "bSortable": false }
        ],
        "aaSorting": [],
        select: {
            style: \'multi\'
        }
    } );
';

$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);
?>