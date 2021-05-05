<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\assets\EventAsset;

EventAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = 'Event Registration';
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$list_status = \app\helpers\MyHelper::getStatusEvent();
$list_color = \app\helpers\MyHelper::getStatusEventColor();
?>
<style>
    .besar{
        font-size: 34px
    }
</style>
<div class="row">
   <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?=$this->title;?></h3>
            </div>

            <div class="panel-body ">
        
                <div id="user-profile-2" class="user-profile">
                    <div class="tabbable">
                        <ul class="nav nav-tabs padding-18">
                            <li class="active">
                                <a data-toggle="tab" href="#home">
                                    <i class="green ace-icon fa fa-user bigger-120"></i>
                                    Event
                                </a>
                            </li>

                            

                            <li>
                                <a data-toggle="tab" href="#friends">
                                    <i class="blue ace-icon fa fa-users bigger-120"></i>
                                    Participants
                                </a>
                            </li>

                           
                        </ul>

                        <div class="tab-content no-border padding-24">
                            <div id="home" class="tab-pane in active">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-3 center">
                                        <?php
                                        if($model->status == '1')
                                        {
                                            ?>
                                        <span class="profile-picture">
                                            <img class="editable img-responsive" alt="Alex's Avatar" id="avatar2" src="<?=$result->getDataUri();?>">
                                        </span>

                                        <div class="bigger-300">or</div>
                                        <a href="javascript:void(0)" id="btn-register" class="btn btn-sm btn-block btn-primary">
                                            <i class="ace-icon fa fa-plus-circle bigger-300"></i>
                                            <span class="bigger-300">Tap here to register</span>
                                        </a>
                                        <?php
                                        }
                                         ?>
                                        
                                    </div><!-- /.col -->

                                    <div class="col-xs-12 col-sm-9">
                                        <h4 class="blue">
                                            <span class="middle besar"><?=$model->nama;?></span>

                                            
                                        </h4>

                                        <div class="profile-user-info">
                                            

                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Location/Venue </div>

                                                <div class="profile-info-value">
                                                    <i class="fa fa-map-marker light-orange bigger-110"></i>
                                                    <span><?=$model->venue;?></span>
                                                </div>
                                            </div>

                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Organizer </div>

                                                <div class="profile-info-value">
                                                    <span><?=$model->penyelenggara;?></span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Level </div>

                                                <div class="profile-info-value">
                                                    <span><?=$model->tingkat;?></span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Date of event </div>

                                                <div class="profile-info-value">
                                                    <span><?=date('l F j, Y g:i a',strtotime($model->tanggal_mulai));?></span> hingga <span><?=date('l F j, Y g:i a',strtotime($model->tanggal_selesai));?></span> 
                                                </div>
                                            </div>

                                             <div class="profile-info-row">
                                                <div class="profile-info-name"> Website </div>

                                                <div class="profile-info-value">
                                                    <a href="#" target="_blank"><?=$model->url;?></a>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Group Event </div>

                                                <div class="profile-info-value">
                                                    <span ><?=$model->kegiatan->jenisKegiatan->nama_jenis_kegiatan;?></span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Status </div>

                                                <div class="profile-info-value">
                                                    <span class="label label-<?=$list_color[$model->status];?> arrowed-in-right">
                                                        <i class="ace-icon fa fa-circle smaller-80 align-middle"></i>
                                                        <?=$list_status[$model->status];?>
                                                    </span>
                                                </div>
                                            </div>

                                          
                                        </div>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->

                              
                               
                            </div><!-- /#home -->

                            <div id="friends" class="tab-pane">
                                <div class="profile-feed row">
                                    
                                </div><!-- /.row -->

                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- dialog body -->
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                Hello world!
            </div>
            <!-- dialog buttons -->
            <div class="modal-footer"><button type="button" class="btn btn-primary">OK</button></div>
        </div>
    </div>
</div>


<?php
$this->registerJs('

function register(nim, event_id){
    var obj = new Object
    obj.nim = nim
    obj.event_id = event_id
    $.ajax({
        type: \'POST\',
        url: "'.\yii\helpers\Url::to(['events/ajax-register']).'",
        data: {
            dataPost : obj
        },
        async: true,
        error : function(e){
            Swal.fire({
                  title: \'Oops!\',
                  icon: \'error\',
                  text: e.responseText
                })
        },
        success: function (data) {
            var data = $.parseJSON(data)
            if(data.code == 200){
                Swal.fire({
                    title: \'Yeay!\',
                    icon: \'success\',
                    timer: 1000,
                    timerProgressBar: true,
                    text: data.message,
                    
                })  
            }

            else{
                Swal.fire({
                  title: \'Oops!\',
                  icon: \'error\',
                  text: data.message
                })
            }
            
        }
    })
}

function getListPeserta(event_id){
    var obj = new Object
    obj.event_id = event_id
    $.ajax({
        type: \'POST\',
        url: "'.\yii\helpers\Url::to(['events/ajax-list-peserta']).'",
        data: {
            dataPost : obj
        },
        async: true,
        error : function(e){
            Swal.fire({
              title: \'Oops!\',
              icon: \'error\',
              text: e.responseText
            })
        },
        success: function (data) {
            var data = $.parseJSON(data)
            $("#friends div.profile-feed").empty()
            var row = ""
            $.each(data, function(i,obj){
                row += "<div class=\'col-xs-12 col-lg-2\'>"
                row += "    <div class=\'profile-activity clearfix\'>"
                row += "        <div>"
                row += "            <i class=\'pull-left thumbicon fa fa-picture-o btn-info no-hover\'></i>"
                row += "            <a class=\'user\' href=\'#\'> "+obj.nama+" - "+obj.nim+" </a>"
                row += "            from "+obj.prodi+" semester "+obj.semester+" has joined."
                row += "            <div class=\'time\'>"
                row += "                <i class=\'ace-icon fa fa-clock-o bigger-110\'></i>"
                row += "               checked in at "+obj.checked_in
                row += "            </div>"
                row += "        </div>"
                row += "        <div class=\'tools action-buttons\'>"
                row += "            <a href=\'#\' data-method=\'POST\' data-item=\'"+obj.id+"\' title=\'Remove this participant\' class=\'red link-remove\'>"
                row += "                <i class=\'ace-icon fa fa-times bigger-125\'></i>"
                row += "            </a>"
                row += "        </div>"
                row += "    </div>   "
                row += "</div>"
            })

            $("#friends div.profile-feed").append(row)
        }
    })
}

getListPeserta("'.$model->id.'")

$(document).on("click","#btn-register",function(e){

    bootbox.prompt({
        title: "Write NIM here, then press Enter or click OK", 
        centerVertical: true,
        callback: function(result){ 
            register(result, "'.$model->id.'") 
        }
    }).find(".modal-content").css({
        "margin-top": function (){
            var w = $( window ).height();
            var b = $(".modal-dialog").height();
            // should not be (w-h)/2
            var h = (w-b)/2;
            return h+"px";
        }
    });
})

', \yii\web\View::POS_READY);