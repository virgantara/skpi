<?php

use yii\helpers\Html;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model app\models\SkpiPermohonan */

$this->title = $model->nim0->nama_mahasiswa;
$this->params['breadcrumbs'][] = ['label' => 'Skpi Permohonans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

Yii::$app->language = 'id-ID'; 


$list_status_pengajuan = [
    '0' =>'BELUM DISETUJUI',
    '1' =>'DISETUJUI',
    '2' =>'DITOLAK'
];
?>
<div class="block-header">
    <h2><?= Html::encode($this->title) ?></h2>
</div>
<div class="row">
   <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <?= Html::a('<i class="fa fa-save"></i> Simpan', '#', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-check"></i> Approval', ['update', 'id' => $model->id], ['class' => 'btn btn-inverse']) ?>
                <?= Html::a('<i class="fa fa-download"></i> Download', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            </div>

            <div class="panel-body ">
                <h3>Mahasiswa</h3>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th style='width: 20%;' >NIM</th>
                        <td><?=$model->nim?></td>
                    </tr>
                    <tr>
                        <th>Nama Mahasiswa</th>
                        <td><?=$model->nim0->nama_mahasiswa?></td>
                    </tr>
                    <tr>
                        <th>Tempat & Tanggal Lahir</th>
                        <td><?=$model->nim0->tempat_lahir.', '.\app\helpers\MyHelper::convertTanggalIndo($model->nim0->tgl_lahir)?></td>
                    </tr>
                    <tr>
                        <th>Prodi</th>
                        <td><?=$model->nim0->kodeProdi->nama_prodi?></td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td><?=$model->nim0->kampus0->nama_kampus?></td>
                    </tr>
                    <tr>
                        <th>Tahun Lulus</th>
                        <td><?=(isset($model->nim0->tgl_lulus) ? date('Y',strtotime($model->nim0->tgl_lulus)) : null)?></td>
                    </tr>
                    <tr>
                        <th>Lama Studi</th>
                        <td>
                        <?php
                            if(!empty($model->nim0->tgl_lulus) && $model->nim0->tgl_lulus != '1970-01-01' && !empty($model->nim0->tgl_masuk)){
                                $d1 = new DateTime($model->nim0->tgl_masuk);
                                $d2 = new DateTime($model->nim0->tgl_lulus);

                                $diff = $d2->diff($d1);

                                echo round($diff->y + ($diff->m / 12),1).' tahun';
                            }

                        ?>
                                
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <td><?=\app\helpers\MyHelper::convertTanggalIndo($model->tanggal_pengajuan)?></td>
                    </tr>
                    <tr>
                        <th>Nomor Ijazah</th>
                        <td><?=$model->nim0->no_ijazah?></td>
                    </tr>
                    <tr>
                        <th>Nomor SKPI</th>
                        <td><?=Html::textInput('nomor_skpi',$model->nomor_skpi,['class' => 'form-control'])?></td>
                    </tr>
                    <tr>
                        <th>Link Barcode</th>
                        <td><?=Html::textInput('link_barcode',$model->link_barcode,['class' => 'form-control'])?></td>
                    </tr>
                    <tr>
                        <th>Status Pengajuan</th>
                        <td><?=$list_status_pengajuan[$model->status_pengajuan]?></td>
                    </tr>
                </table>
                <h3>Evaluasi</h3>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th style='width: 20%;' ><?=Yii::t('app', 'Description')?><br><i>Description</i></th>
                        <td width="40%">
                            <?= CKEditor::widget([
                                'name' => 'deskripsi',
                                'value' => $model->deskripsi,
                                'options' => ['rows' => 6],
                                'preset' => 'advance',
                                'clientOptions' => [
                                    'enterMode' => 2,
                                    'forceEnterMode' => false,
                                    'shiftEnterMode' => 1
                                ]
                            ]) ?>        
                        </td>
                        <td>
                            <?= CKEditor::widget([
                                'name' => 'deskripsi_en',
                                'value' => $model->deskripsi_en,
                                'options' => ['rows' => 6],
                                'preset' => 'advance',
                                'clientOptions' => [
                                    'enterMode' => 2,
                                    'forceEnterMode' => false,
                                    'shiftEnterMode' => 1
                                ]
                            ]) ?>    
                        </td>
                    </tr>
                </table>

                <h3>Nilai Induk Kompetensi</h3>
                <table class="table table-striped table-bordered" id="tabel-induk-kompetensi">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th width="40%">Induk Kompetensi</th>
                            <th width="10%" >Nilai</th>
                            <th width="10%">Persentase</th>
                            <th>Predikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5">
                                <span id="loading" style="display: none"><img width="24px" src="<?=$this->theme->baseUrl;?>/images/loading.gif" /></span>
                            </td>
                            
                        </tr>
                        
                    </tbody>
                </table>

                <h3>Nilai Kompetensi</h3>
                <table class="table table-striped table-bordered" id="tabel-kompetensi">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th width="40%">Kompetensi</th>
                            <th width="20%">Nilai</th>
                            <th>Predikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4">
                                <span id="loading_kompetensi" style="display: none"><img width="24px" src="<?=$this->theme->baseUrl;?>/images/loading.gif" /></span>
                            </td>
                            
                        </tr>
                        
                    </tbody>
                </table>

                <h3>Nilai AKPAM</h3>
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

                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <h3>SERTIFIKAT PROFESIONAL</h3>
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
                        </table>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <h3>PRESTASI</h3>
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
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<?php 

$this->registerJs(' 


getKompetensi("'.$model->nim.'")
getIndukKompetensi("'.$model->nim.'")
getRekapAkpam("'.$model->nim.'")
getSertifikasi("'.$model->nim.'")
getPrestasi("'.$model->nim.'")

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
                row += "<td style=\'text-align:center\'><a class=\'btn btn-primary\' target=\'_blank\' href=\'"+url+"\'><i class=\'fa fa-download\'></i>Unduh</a></td>";
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
                row += "<td style=\'text-align:center\'><a class=\'btn btn-primary\' target=\'_blank\' href=\'"+url+"\'><i class=\'fa fa-download\'></i>Unduh</a></td>";
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