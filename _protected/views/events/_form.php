<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\EventAsset;

EventAsset::register($this);



/* @var $this yii\web\View */
/* @var $model app\models\Events */
/* @var $form yii\widgets\ActiveForm */
?>

       
        <div id="calendar"></div>

   
<div id="createEventModal" class="modal fade" role="dialog" style="display: none;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add Event</h4>
      </div>
      <div class="modal-body">
            <div class="control-group">
                <label class="control-label" for="inputPatient">Jenis Kegiatan:</label>
                <div class="field desc">
                    <?=Html::dropDownList('id_jenis_kegiatan','',ArrayHelper::map(\app\models\SimakJenisKegiatan::find()->all(),'id','nama_jenis_kegiatan'),['id'=>'id_jenis_kegiatan','class'=>'form-control','prompt'=>'-Pilih Jenis Kegiatan-']);?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPatient">Kegiatan:</label>
                <div class="field desc">
                    <?=Html::dropDownList('kegiatan_id','',[],['id'=>'kegiatan_id','class'=>'form-control','prompt'=>'-Pilih Kegiatan-']);?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPatient">Event:</label>
                <div class="field desc">

                    <input class="form-control" id="title" name="title" placeholder="Nama Event" type="text" value="">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPatient">Venue/Lokasi Acara:</label>
                <div class="field desc">
                    <?=Html::dropDownList('venue','',ArrayHelper::map(\app\models\Venue::find()->all(),'id','nama'),['id'=>'venue','class'=>'form-control','prompt'=>'-Pilih Venue/Lokasi Acara-']);?>
                   
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPatient">Penyelenggara:</label>
                <div class="field desc">
                    <input class="form-control" id="penyelenggara" name="penyelenggara" placeholder="Penyelenggara" type="text" value="">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPatient">Tingkat:</label>
                <div class="field desc">
                    <?=Html::dropDownList('tingkat','',['Prodi'=>'Prodi','Fakultas'=>'Fakultas','Universitas'=>'Universitas','Lokal'=>'Lokal','Provinsi'=>'Provinsi','Nasional'=>'Nasional','Internasional'=>'Internasional'],['id'=>'tingkat','class'=>'form-control','prompt'=>'-Pilih Tingkat-']);?>

                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPatient">Prioritas:</label>
                <div class="field desc">
                    <?=Html::dropDownList('priority','',['success'=>'Low','yellow'=>'Medium','warning'=>'High','danger'=>'Important'],['id'=>'priority','class'=>'form-control','prompt'=>'-Pilih Prioritas-']);?>
                    
                </div>
            </div>
            <input type="hidden" id="startTime" value="2021-05-02T05:00:00">
            <input type="hidden" id="endTime" value="2021-05-02T05:30:00">
            
            
       
        <div class="control-group">
            <label class="control-label" for="when">When:</label>
            <div class="controls controls-row" id="when" style="margin-top:5px;"></div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button type="submit" class="btn btn-primary" id="submitButton">Save</button>
    </div>
    </div>

  </div>
</div>
<div id="calendarModal" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Edit Event</h4>
      </div>
      <div class="modal-body">
            <div class="control-group">
                <label class="control-label" for="inputPatient">Jenis Kegiatan:</label>
                <div class="field desc">
                    <?=Html::dropDownList('id_jenis_kegiatan_edit','',ArrayHelper::map(\app\models\SimakJenisKegiatan::find()->all(),'id','nama_jenis_kegiatan'),['id'=>'id_jenis_kegiatan_edit','class'=>'form-control','prompt'=>'-Pilih Jenis Kegiatan-']);?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPatient">Kegiatan:</label>
                <div class="field desc">
                    <?=Html::dropDownList('kegiatan_id_edit','',[],['id'=>'kegiatan_id_edit','class'=>'form-control','prompt'=>'-Pilih Kegiatan-']);?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPatient">Event:</label>
                <div class="field desc">
                    <input class="form-control" id="title_edit" name="title" placeholder="Nama Event" type="text" value="">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPatient">Venue/Lokasi Acara:</label>
                <div class="field desc">
                     <?=Html::dropDownList('venue_edit','',ArrayHelper::map(\app\models\Venue::find()->all(),'id','nama'),['id'=>'venue_edit','class'=>'form-control','prompt'=>'-Pilih Venue/Lokasi Acara-']);?>
                   
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPatient">Penyelenggara:</label>
                <div class="field desc">
                    <input class="form-control" id="penyelenggara_edit" name="penyelenggara" placeholder="Penyelenggara" type="text" value="">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPatient">Tingkat:</label>
                <div class="field desc">
                    <?=Html::dropDownList('tingkat_edit','',['Lokal'=>'Lokal','Provinsi'=>'Provinsi','Nasional'=>'Nasional','Internasional'=>'Internasional'],['id'=>'tingkat_edit','class'=>'form-control','prompt'=>'-Pilih Tingkat-']);?>
                    
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPatient">Prioritas:</label>
                <div class="field desc">
                    <?=Html::dropDownList('priority_edit','',['success'=>'Low','yellow'=>'Medium','warning'=>'High','danger'=>'Important'],['id'=>'priority_edit','class'=>'form-control','prompt'=>'-Pilih Prioritas-']);?>
                    
                </div>
            </div>
            <input type="hidden" id="startTime_edit" value="2021-05-02T05:00:00">
            <input type="hidden" id="eventID_edit" value="">
            <input type="hidden" id="endTime_edit" value="2021-05-02T05:30:00">
            
            
       
        <div class="control-group">
            <label class="control-label" for="when">When:</label>
            <div class="controls controls-row" id="when_edit" style="margin-top:5px;">Sunday, May 2nd 2021, 5:00 - 5:30</div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button type="submit" class="btn btn-primary" id="btnSubmitUpdate">Update</button>
    </div>
    </div>
</div>
</div>
<?php

$this->registerJs("
    
$(\"#id_jenis_kegiatan\").change(function(){
    getListKegiatan($(this).val(),$('#kegiatan_id'));
});

$('#id_jenis_kegiatan_edit').change(function(){
    getListKegiatan($(this).val(),$('#kegiatan_id_edit'));
});

getListKegiatan($(\"#id_jenis_kegiatan\").val(),$('#kegiatan_id'));
getListKegiatan($('#id_jenis_kegiatan_edit').val(),$('#kegiatan_id_edit'));



function getListKegiatan(jenis_kegiatan, kegiatan_selector){
    var obj = new Object;
    obj.id = jenis_kegiatan;
  
    $.ajax({
       url: '".Url::to(['simak-kegiatan/ajax-list-kegiatan'])."',
       data: {
        dataPost : obj
       },
       type: \"POST\",
       async: true,
       success: function(json) {
            var res = $.parseJSON(json)
            var row = '';
            kegiatan_selector.empty();
            $.each(res, function(i, obj){
              row += '<option  value=\"'+obj.id+'\">'+obj.name+'</option>';
            });

            kegiatan_selector.append(row);
            kegiatan_selector.val(\"'.$model->kegiatan_id.'\");
       }
    });
  


  
}

var calendar = $('#calendar').fullCalendar({
            header:{
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'agendaWeek',
            editable: true,
            selectable: true,
            allDaySlot: false,
            lazyFetching : true,
            progressiveEventRendering: true,
            events: \"".Url::to(['events/ajax-list'])."\",
   
            
            eventClick:  function(event, jsEvent, view) {
                endtime = $.fullCalendar.moment(event.end).format('YYYY-MM-DD HH:mm:ss');
                starttime = $.fullCalendar.moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                $.ajax({
                   url: '".Url::to(['events/ajax-get'])."',
                   data: 'id='+event.id,
                   type: \"POST\",
                   async: true,
                   success: function(json) {
                        var res = $.parseJSON(json)
                      
                        $('#calendarModal #eventID_edit').val(res.id);
                        $('#calendarModal #title_edit').val(res.nama);
                        $('#calendarModal #penyelenggara_edit').val(res.penyelenggara);
                        $('#calendarModal #tingkat_edit').val(res.tingkat);
                        $('#calendarModal #venue_edit').val(res.venue);
                        $('#calendarModal #startTime_edit').val(res.start);
                        $('#calendarModal #endTime_edit').val(res.end);
                        $('#calendarModal #priority_edit').val(res.priority);
                        endtime = $.fullCalendar.moment(res.end).format('YYYY-MM-DD HH:mm:ss');
                        starttime = $.fullCalendar.moment(res.start).format('YYYY-MM-DD HH:mm:ss');
                        
                        start = moment(starttime).format('LLL');
                        end = moment(endtime).format('LLL');
                      
                        var mywhen = start + ' until ' + end;
                        $('#calendarModal #startTime').val(starttime);
                        $('#calendarModal #endTime').val(endtime);
                        $('#calendarModal #when_edit').text(mywhen);
                        $('#calendarModal').modal('toggle');
                   }
                });
                
            },
            
            //header and other values
            select: function(start, end, jsEvent) {
                endtime = $.fullCalendar.moment(end).format('YYYY-MM-DD HH:mm:ss');
                starttime = $.fullCalendar.moment(start).format('YYYY-MM-DD HH:mm:ss');
                var mywhen = starttime + ' - ' + endtime;
                start = moment(start).format();
                end = moment(end).format();
                $('#createEventModal #startTime').val(starttime);
                $('#createEventModal #endTime').val(endtime);
                $('#createEventModal #when').text(mywhen);
                $('#createEventModal').modal('toggle');
           },
           eventDrop: function(event, delta){
                var endtime = $.fullCalendar.moment(event.end).format('YYYY-MM-DD HH:mm:ss');
                var starttime = $.fullCalendar.moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                $.ajax({
                   url: '".Url::to(['events/ajax-get'])."',
                   data: 'id='+event.id,
                   type: \"POST\",
                   async: true,
                   success: function(json) {
                        var res = $.parseJSON(json)
                        var obj = new Object;
                        obj.id = event.id
                        obj.nama = res.nama
                        obj.penyelenggara = res.penyelenggara
                        obj.tingkat = res.tingkat
                        obj.start = starttime
                        obj.end = endtime
                        obj.venue = res.venue
                        obj.priority = res.priority
                        obj.kegiatan_id = res.kegiatan_id

                        $.ajax({
                           url: '".Url::to(['events/ajax-update'])."',
                           data: {
                            dataPost : obj
                            },
                           type: \"POST\",
                           async: true,
                           success: function(json) {
                                $(\"#calendar\").fullCalendar('refetchEvents');
                           }
                        });
                        
                   }
                });
           },
           eventResize: function(event) {
                
               
                var endtime = $.fullCalendar.moment(event.end).format('YYYY-MM-DD HH:mm:ss');
                var starttime = $.fullCalendar.moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                $.ajax({
                   url: '".Url::to(['events/ajax-get'])."',
                   data: 'id='+event.id,
                   type: \"POST\",
                   async: true,
                   success: function(json) {
                        var res = $.parseJSON(json)
                        var obj = new Object;
                        obj.id = event.id
                        obj.nama = res.nama
                        obj.penyelenggara = res.penyelenggara
                        obj.tingkat = res.tingkat
                        obj.start = starttime
                        obj.end = endtime
                        obj.venue = res.venue
                        obj.priority = res.priority
                        obj.kegiatan_id = res.kegiatan_id

                        $.ajax({
                           url: '".Url::to(['events/ajax-update'])."',
                           data: {
                            dataPost : obj
                            },
                           type: \"POST\",
                           async: true,
                           success: function(json) {
                                $(\"#calendar\").fullCalendar('refetchEvents');
                           }
                        });
                        
                   }
                });
                
                
           }
        });
               
       $('#submitButton').on('click', function(e){
           // We don't want this to act as a link so cancel the link action
           e.preventDefault();
           doSubmit();
       });

       $('#btnSubmitUpdate').on('click', function(e){
           // We don't want this to act as a link so cancel the link action
           e.preventDefault();
           doUpdate();
       });
       
       $('#deleteButton').on('click', function(e){
           // We don't want this to act as a link so cancel the link action
           e.preventDefault();
           doDelete();
       });
       

function doDelete(){
   $(\"#calendarModal\").modal('hide');
   var eventID = $('#eventID').val();
   $.ajax({
       url: '".Url::to(['events/ajax-delete'])."',
       data: 'id='+eventID,
       type: \"POST\",
       success: function(json) {
           if(json == 1){
                Swal.fire({
                      title: 'Yeay!',
                      text: json.message,
                      icon: 'success',
                    });
                $(\"#calendar\").fullCalendar('removeEvents',eventID);
           }
           else
                return false;
            
           
       }
   });
}

function doSubmit(){
   $(\"#createEventModal\").modal('hide');
   var title = $('#title').val();
   var startTime = $('#startTime').val();
   var endTime = $('#endTime').val();

   var obj = new Object;
   obj.nama = title
   obj.start = startTime
   obj.end = endTime
   obj.venue = $('#venue').val()
   obj.tingkat = $('#tingkat').val()
   obj.penyelenggara = $('#penyelenggara').val();
   obj.priority = $('#priority').val()
   obj.kegiatan_id = $('#kegiatan_id').val()


   $.ajax({
        url: '".Url::to(['events/ajax-add'])."',
        data : {
            dataPost : obj
        },
        type: \"POST\",
        success: function(json) {
            var json = $.parseJSON(json)
           Swal.fire({
                      title: 'Yeay!',
                      text: json.message,
                      icon: 'success',
                    });
           $(\"#calendar\").fullCalendar('refetchEvents');
       }
   });
   
}


function doUpdate(){
   $(\"#calendarModal\").modal('hide');
   var title = $('#title_edit').val();
   var startTime = $('#startTime_edit').val();
   var endTime = $('#endTime_edit').val();

   var obj = new Object;
   obj.nama = title
   obj.id = $('#eventID_edit').val()
   obj.start = startTime
   obj.end = endTime
   obj.venue = $('#venue_edit').val()
   obj.tingkat = $('#tingkat_edit').val()
   obj.penyelenggara = $('#penyelenggara_edit').val();
   obj.priority = $('#priority_edit').val()
   obj.kegiatan_id = $('#kegiatan_id_edit').val()

   $.ajax({
        url: '".Url::to(['events/ajax-update'])."',
        data : {
            dataPost : obj
        },
        type: \"POST\",
        success: function(json) {
            var json = $.parseJSON(json)
            Swal.fire({
                      title: 'Yeay!',
                      text: json.message,
                      icon: 'success',
                    });
           $(\"#calendar\").fullCalendar('refetchEvents');

       }
   });
   
}

", \yii\web\View::POS_READY);
