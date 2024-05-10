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
                            <td colspan="5"><h3>Loading...</h3></td>
                            
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
                            <td colspan="4"><h3>Loading...</h3></td>
                            
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>



<?php 

$this->registerJs(' 

function getIndukKompetensi(ta,nim){


  var obj = new Object;
  obj.tahun_akademik = ta;
  obj.nim = nim;
  var ajax_url= "/simak-kegiatan-mahasiswa/ajax-get-induk-kompetensi";
  $.ajax({

        type : "POST",
        url : ajax_url,
        data : {
            dataPost : obj
        },
        success: function(data){
            var hasils = $.parseJSON(data);

            var row = \'\';
    
            var counter = 0;
            var list_kategori = []
            var list_values = []

            tahun_aktif = ta;
            $("#tahun_akademik").val(ta)
            

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
              row += \'<td>\'+objects.akpam+\'</td>\';
              row += \'<td>\'+objects.persentase+\' %</td>\';
              row += \'<td><span class="label label-\'+objects.color+\'">\'+objects.label+\'</span></td>\';
              row += \'</tr>\';
            });
            
            
            $(\'#tabel-induk-kompetensi > tbody\').append(row);
        }
    });

  
}


var tahun_aktif = "";

var list_kompetensi = []

function getKompetensi(ta,nim){

  var obj = new Object;
  obj.tahun_akademik = ta;
  obj.nim = nim;
  var ajax_url= "/simak-kegiatan-mahasiswa/ajax-get-kompetensi";
  $.ajax({

        type : "POST",
        url : ajax_url,
        data : {
            dataPost : obj
        },
        success: function(data){
            var hasils = $.parseJSON(data);

            var row = \'\';
            $(\'#tabel-kompetensi > tbody\').empty();
            
            var counter = 0;
            var list_kategori = []
            var list_values = []

            tahun_aktif = ta;


            $.each(hasils, function(i, objects){
              
              $.each(objects.komponen, function(i, obj){
                var induk_kom = "";
                var counter_label = "";
                if(!list_kategori.includes(objects.induk)){
                  list_kategori.push(objects.induk)
                  
                  induk_kom = objects.induk
                  
                  counter_label = counter
                }

                counter++;
               
                row += \'<tr>\';
                row += \'<td>\'+(counter)+\'</td>\';
                // row += \'<td>\'+induk_kom+\'</td>\';
                row += \'<td>\'+obj.kompetensi+\'</td>\';
                row += \'<td class="text-center"><a target="_blank" href="/simak-kegiatan-mahasiswa/kompetensi?nim=\'+nim+\'&tahun_id=\'+tahun_aktif+\'&induk_id=\'+objects.induk_id+\'">\'+obj.nilai_akhir+\'</a></td>\';

                row += \'<td><span class="label label-\'+obj.color+\'">\'+obj.label+\'</span></td>\';
                row += \'</tr>\';

                list_kompetensi.push(obj.kompetensi_id)
              });
            });

           
            $(\'#tabel-kompetensi > tbody\').append(row);          
        }
    });
  

  
}

getKompetensi("20221","'.$model->nim.'")
getIndukKompetensi("20221","'.$model->nim.'")


', \yii\web\View::POS_READY);

?>