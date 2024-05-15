<?php

use yii\helpers\Html;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model app\models\SkpiPermohonan */

$this->title = $mhs->nama_mahasiswa;
$this->params['breadcrumbs'][] = ['label' => 'SKPI', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;

Yii::$app->language = 'id-ID'; 


?>

<div class="row">
   <div class="col-md-12">
        <div class="panel">
            

            <div class="panel-body ">
                
               
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

            </div>
        </div>

    </div>
</div>



<?php 

$this->registerJs(' 


getKompetensi("'.$mhs->nim_mhs.'")
getIndukKompetensi("'.$mhs->nim_mhs.'")


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