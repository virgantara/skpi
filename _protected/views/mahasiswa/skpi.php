<?php

use yii\helpers\Html;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model app\models\SkpiPermohonan */

$this->title = $mhs->nama_mahasiswa;
$this->params['breadcrumbs'][] = ['label' => 'SKPI', 'url' => ['mahasiswa/skpi']];
$this->params['breadcrumbs'][] = $this->title;

Yii::$app->language = 'id-ID'; 


$list_status_pengajuan = \app\helpers\MyHelper::getStatusPengajuan();
?>
<style>
    .status-bar {
        margin-top: 20px;
    }
    .status-item {
        text-align: center;
        padding: 10px;
        border-right: 1px solid #ddd;
    }
    .status-item:last-child {
        border-right: none;
    }
</style>
<div class="row">
   <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h2><?= Html::encode($this->title) ?></h2>              
            </div>

            <div class="panel-body ">
                <div class="row">
                    <div class="col-lg-4">
                        <h3>Mahasiswa</h3>
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Nama Lengkap</th>
                                <td><?=$mhs->nama_mahasiswa?></td>
                            </tr>
                            <tr>
                                <th>NIM</th>
                                <td><?=$mhs->nim_mhs?></td>
                            </tr>
                            
                            <tr>
                                <th>Tempat & Tanggal Lahir</th>
                                <td><?=$mhs->tempat_lahir.', '.\app\helpers\MyHelper::convertTanggalIndo($mhs->tgl_lahir)?></td>
                            </tr>
                            <tr>
                                <th>Program Studi</th>
                                <td><?=$mhs->kodeProdi->nama_prodi?></td>
                            </tr>
                            <tr>
                                <th>Tahun Lulus</th>
                                <td><?=(isset($mhs->tgl_lulus) ? date('Y',strtotime($mhs->tgl_lulus)) : null)?></td>
                            </tr>
                            <tr>
                                <th>Nomor Ijazah</th>
                                <td><?=$mhs->no_ijazah?></td>
                            </tr>
                            <tr>
                                <th>Jenjang Pendidikan</th>
                                <td><?=(!empty($mhs->kodeProdi->jenjang) ? $mhs->kodeProdi->jenjang->label : '-')?></td>
                            </tr>
                            <tr>
                                <th>Gelar yang diberikan</th>
                                <td><?=(!empty($mhs->kodeProdi) ? $mhs->kodeProdi->gelar_lulusan.' ('.$mhs->kodeProdi->gelar_lulusan_short.')' : '-')?></td>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <?php 
                                    if(!empty($model) && $model->status_pengajuan == '1'){
                                        echo '<span class="btn btn-success btn-block">TELAH DIAJUKAN</span>';
                                    }
                                    
                                    else{
                                        echo Html::a('Ajukan Permohonan SKPI', ['skpi-permohonan/create'], ['class' => 'btn btn-success btn-block','id' => 'btn-apply']);
                                    }
                                     ?>
                                    
                                </th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-4">
                        <h3>Prestasi</h3>
                        <table class="table table-striped table-bordered" id="tabel-akpam">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th width="40%">Program</th>
                                    <th width="20%">Nilai</th>
                                    <!-- <th>Predikat</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3">
                                        <span id="loading_akpam" style="display: none"><img width="24px" src="<?=$this->theme->baseUrl;?>/images/loading.gif" /></span>
                                    </td>
                                    
                                </tr>
                                
                            </tbody>
                        </table>
                        <table class="table table-striped table-bordered" id="tabel-prestasi">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th width="40%">Nama Prestasi</th>
                                    <th width="20%">Opsi</th>
                                    <!-- <th>Predikat</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3">
                                        <span id="loading_prestasi" style="display: none"><img width="24px" src="<?=$this->theme->baseUrl;?>/images/loading.gif" /></span>
                                    </td>
                                    
                                </tr>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                <th colspan="3"><?= Html::a('<i class="fa fa-plus"></i> Tambah Data Prestasi', ['tes/create'], ['class' => 'btn btn-primary btn-block']) ?>
                                    
                                </th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-lg-4">
                        <h3>Sertifikasi</h3>
                        <table class="table table-striped table-bordered" id="tabel-sertifikasi">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th width="40%">Nama Sertifikasi</th>
                                    <th width="20%">Opsi</th>
                                    <!-- <th>Predikat</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3">
                                        <span id="loading_sertifikasi" style="display: none"><img width="24px" src="<?=$this->theme->baseUrl;?>/images/loading.gif" /></span>
                                    </td>
                                    
                                </tr>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                <th colspan="3"><?= Html::a('<i class="fa fa-plus"></i> Tambah Data Sertifikasi', ['sertifikasi/create'], ['class' => 'btn btn-warning btn-block']) ?>
                                    
                                </th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="col-lg-12">
                        <div class="row status-bar">
                            <?php 
                            foreach($list_status_pengajuan as $q => $v){
                                $state = 'default';

                                if(empty($model) && $q == '0'){
                                    $state = 'success';
                                }

                                else if(!empty($model) && $model->status_pengajuan == $q){
                                    $state = 'success';
                                }
                             ?>
                            
                            <div class="col-xs-3 status-item">
                                <button class="btn btn-<?=$state?> btn-block"><?=$v?></button>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                
             
               
            </div>
        </div>

    </div>
</div>



<?php 

$this->registerJs(' 

$(document).on("click","#btn-apply",function(e){
    e.preventDefault()
    Swal.fire({
      title: \'Do you want to apply this?\',
      text: "You won\'t be able to revert this!",
      icon: \'warning\',
      showCancelButton: true,
      confirmButtonColor: \'#3085d6\',
      cancelButtonColor: \'#d33\',
      confirmButtonText: \'Yes, apply!\'
    }).then((result) => {
        if (result.value) {
            $.ajax({

                type : "POST",
                url : "/skpi-permohonan/ajax-apply",
                success: function(data){
                    var hasil = $.parseJSON(data);
                    if(hasil.code == 200){
                        Swal.fire(
                        \'Yeay!\',
                          hasil.message,
                          \'success\'
                        ).then(res=>{
                            window.location.reload();
                        })



                    }
                    else{
                        Swal.fire(
                        \'Oops!\',
                          hasil.message,
                          \'error\'
                        )
                    }
                }
            });
        }
    })
})
getRekapAkpam("'.$mhs->nim_mhs.'")
getSertifikasi("'.$mhs->nim_mhs.'")
getPrestasi("'.$mhs->nim_mhs.'")

function getPrestasi(nim){

  var obj = new Object;
  obj.nim = nim;
  var ajax_url= "/tes/ajax-get";
  $.ajax({

        type : "POST",
        url : ajax_url,
        data : {
            dataPost : obj
        },
        beforeSend: function(){
            $("#loading_prestasi").show()
        },
        error: function(e){
            $("#loading_prestasi").hide()
        },
        success: function(data){
            $("#loading_prestasi").hide()
            var hasils = $.parseJSON(data);

            var row = \'\';
            $(\'#tabel-prestasi > tbody\').empty();
            
            var counter = 0;

            $.each(hasils.items, function(i, obj){
              
                counter++;
                let url = \'/tes/download?id=\'+obj.id
                row += "<tr>";
                row += "<td>"+(counter)+"</td>";
                row += "<td>"+obj.jenis_tes+" - "+obj.nama_tes+"</td>";
                row += "<td style=\'text-align:center\'></td>";
                row += "</tr>";

            
            });

            
           
            $(\'#tabel-prestasi > tbody\').append(row);          
        }
    });
  

  
}

function getSertifikasi(nim){

  var obj = new Object;
  obj.nim = nim;
  var ajax_url= "/sertifikasi/ajax-get";
  $.ajax({

        type : "POST",
        url : ajax_url,
        data : {
            dataPost : obj
        },
        beforeSend: function(){
            $("#loading_sertifikasi").show()
        },
        error: function(e){
            $("#loading_sertifikasi").hide()
        },
        success: function(data){
            $("#loading_sertifikasi").hide()
            var hasils = $.parseJSON(data);

            var row = \'\';
            $(\'#tabel-sertifikasi > tbody\').empty();
            
            var counter = 0;

            $.each(hasils.items, function(i, obj){
              
                counter++;
                let url = \'/sertifikasi/download?id=\'+obj.id
                row += "<tr>";
                row += "<td>"+(counter)+"</td>";
                row += "<td>"+obj.jenis_sertifikasi+" - "+obj.lembaga_sertifikasi+"</td>";
                row += "<td style=\'text-align:center\'></td>";
                // row += "<td></td>";
                row += "</tr>";

            
            });

            
           
            $(\'#tabel-sertifikasi > tbody\').append(row);          
        }
    });
  

  
}

function getRekapAkpam(nim){

  var obj = new Object;
  obj.nim = nim;
  var ajax_url= "/simak-kegiatan-mahasiswa/ajax-get-rekap-akpam";
  $.ajax({

        type : "POST",
        url : ajax_url,
        data : {
            dataPost : obj
        },
        beforeSend: function(){
            $("#loading_akpam").show()
        },
        error: function(e){
            $("#loading_akpam").hide()
        },
        success: function(data){
            $("#loading_akpam").hide()
            var hasils = $.parseJSON(data);

            var row = \'\';
            $(\'#tabel-akpam > tbody\').empty();
            
            var counter = 0;

            $.each(hasils.items, function(i, obj){
              
                counter++;
               
                row += "<tr>";
                row += "<td>"+(counter)+"</td>";
                row += "<td>"+obj.nama+"</td>";
                row += "<td style=\'text-align:center\'>"+obj.nilai+"</td>";
                // row += "<td></td>";
                row += "</tr>";

            
            });

            row += "<tr>";
            row += "<td colspan=\'2\' style=\'text-align:right\'>Total</td>";
            row += "<td style=\'text-align:center\'>"+hasils.total+"</td>";
            // row += "<td></td>";
            row += "</tr>";
            row += "<tr>";
            row += "<td colspan=\'2\' style=\'text-align:right\'>Indeks</td>";
            row += "<td style=\'text-align:center\'>"+hasils.ipks+"</td>";
            // row += "<td></td>";
            row += "</tr>";
           
            $(\'#tabel-akpam > tbody\').append(row);          
        }
    });
  

  
}

function getIndukKompetensi(nim){


  var obj = new Object;
  obj.nim = nim;
  var ajax_url= "/simak-kegiatan-mahasiswa/ajax-get-induk-kompetensi";
  $.ajax({

        type : "POST",
        url : ajax_url,
        data : {
            dataPost : obj
        },
        beforeSend: function(){
            $("#loading").show()
        },
        error: function(e){
            $("#loading").hide()
        },
        success: function(data){
            $("#loading").hide()
            var hasils = $.parseJSON(data);

            var row = \'\';
    
            var counter = 0;
            var list_kategori = []
            var list_values = []


            $(\'#tabel-induk-kompetensi > tbody\').empty();
            
            row = \'\';
            counter = 0;
            $.each(hasils, function(i, objects){
              list_kategori.push(objects.induk)
              list_values.push(objects.persentase)
              counter++;
              
              row += \'<tr>\';
              row += \'<td>\'+counter+\'</td>\';
              row += \'<td>\'+objects.induk+\'</td>\';
              row += \'<td  style="text-align:center">\'+objects.akpam+\'</td>\';
              row += \'<td  style="text-align:center">\'+objects.persentase+\' %</td>\';
              row += \'<td><span class="label label-\'+objects.color+\'">\'+objects.label+\'</span></td>\';
              row += \'</tr>\';
            });
            
            
            $(\'#tabel-induk-kompetensi > tbody\').append(row);
        }
    });

  
}

function getKompetensi(nim){

  var obj = new Object;
  obj.nim = nim;
  var ajax_url= "/simak-kegiatan-mahasiswa/ajax-get-kompetensi";
  $.ajax({

        type : "POST",
        url : ajax_url,
        data : {
            dataPost : obj
        },
        beforeSend: function(){
            $("#loading_kompetensi").show()
        },
        error: function(e){
            $("#loading_kompetensi").hide()
        },
        success: function(data){
            $("#loading_kompetensi").hide()
            var hasils = $.parseJSON(data);

            var row = \'\';
            $(\'#tabel-kompetensi > tbody\').empty();
            
            var counter = 0;

            $.each(hasils, function(i, obj){
              
                counter++;
               
                row += "<tr>";
                row += "<td>"+(counter)+"</td>";
                row += "<td>"+obj.komponen+"</td>";
                row += "<td style=\'text-align:center\'>"+obj.total+"</td>";
                row += "<td><span class=\'label label-"+obj.color+"\'>"+obj.label+"</span></td>";
                row += "</tr>";

            
            });

           
            $(\'#tabel-kompetensi > tbody\').append(row);          
        }
    });
  

  
}
', \yii\web\View::POS_READY);

?>