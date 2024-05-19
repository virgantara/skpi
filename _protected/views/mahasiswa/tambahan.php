<?php

use yii\helpers\Html;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model app\models\SkpiPermohonan */

$this->title = 'Kegiatan Tambahan '.$mhs->nama_mahasiswa;
$this->params['breadcrumbs'][] = ['label' => 'SKPI', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;

Yii::$app->language = 'id-ID'; 


?>

<div class="row">
   <div class="col-md-12">
        <div class="panel">
            

            <div class="panel-body ">
                
                <div class="alert alert-info">
                    <h3>Data Magang berasal dari fitur Magang di SIAKAD. Data yang diambil hanya kegiatan magang dengan status <strong>Lulus</strong></h3>
                </div>
                <h3>Data Magang</h3>
                <table class="table table-striped table-bordered" id="tabel-magang">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th width="40%">Instansi</th>
                            <th width="10%" >Jenis Magang</th>
                            <th width="10%">Pembina Magang</th>
                            <th width="10%">Dosen Pembimbing Magang</th>
                            <th width="10%">Durasi Magang</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">
                                <span id="loading_magang" style="display: none"><img width="24px" src="<?=$this->theme->baseUrl;?>/images/loading.gif" /></span>
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


getMagang("'.$mhs->nim_mhs.'")

function getMagang(nim){

  var obj = new Object;
  obj.nim = nim;
  var ajax_url= "/magang/ajax-get";
  $.ajax({

        type : "POST",
        url : ajax_url,
        data : {
            dataPost : obj
        },
        beforeSend: function(){
            $("#loading_magang").show()
        },
        error: function(e){
            $("#loading_magang").hide()
        },
        success: function(data){
            $("#loading_magang").hide()
            var hasil = $.parseJSON(data);

            var row = \'\';
            $(\'#tabel-magang > tbody\').empty();
            
            var counter = 0;

            $.each(hasil.items, function(i, obj){
              
                counter++;
               
                row += "<tr>";
                row += "<td>"+(counter)+"</td>";
                row += "<td>"+obj.instansi+"</td>";
                row += "<td style=\'text-align:center\'>"+obj.jenis+"</td>";
                row += "<td>"+obj.pembina+"</span></td>";
                row += "<td>"+obj.pembimbing+"</span></td>";
                row += "<td>"+obj.durasi+"</span></td>";
                row += "</tr>";

            
            });

           
            $(\'#tabel-magang > tbody\').append(row);          
        }
    });
  

  
}
', \yii\web\View::POS_READY);

?>