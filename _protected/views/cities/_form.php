<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
\app\assets\LeafletAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Cities */
/* @var $form yii\widgets\ActiveForm */

$model->latitude = $model->latitude ?: -7.8651;
$model->longitude = $model->longitude ?: 111.4696;
$lat = $model->latitude;
$lng = $model->longitude;

?>

<div class="cities-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model,'country_id')->dropDownList(ArrayHelper::map(\app\models\Countries::find()->all(),'id','name'),['id'=>'negara','prompt'=>'- Choose a Country -']);?>

    <?= $form->field($model,'state_id')->dropDownList([],['id'=>'states','prompt'=>'- Choose a state -']);?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


<div id="mapid" style="width: 50%; height: 400px;"></div>
    <?= $form->field($model, 'latitude')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'longitude')->textInput(['readonly' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


    
<?php


$html = "
    var mymap = L.map('mapid').setView([".$lat.", ".$lng."], 10);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href=\"https://www.openstreetmap.org/\">OpenStreetMap</a> contributors, ' +
            '<a href=\"https://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, ' +
            'Imagery © <a href=\"https://www.mapbox.com/\">Mapbox</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
    }).addTo(mymap);

    marker = new L.marker([".$lat.", ".$lng."], {draggable:'true'});
    marker.addTo(mymap);
    marker.on('dragend', function(event){
        var marker = event.target;
        var position = marker.getLatLng();
        marker.setLatLng(new L.LatLng(position.lat, position.lng),{draggable:'true'});
        mymap.panTo(new L.LatLng(position.lat, position.lng));
        $('#cities-latitude').val(position.lat);
        $('#cities-longitude').val(position.lng);
    });

    
";

$html .= "


function getStates(cid){
    $.ajax({

        type : \"POST\",
        url : '".Url::to(['/states/states-list'])."',
        data : \"cid=\"+cid,
        beforeSend : function(){
            $(\"#states\").empty();
            var row = '<option value=\"\">Loading...</option>';
            $(\"#states\").append(row);
        },
        success: function(hasil){
            // var hasil = $.parseJSON(data);
            $(\"#states\").empty();
            var row = '<option value=\"\">- Choose a state -</option>';
            $.each(hasil,function(i,obj){
                row += '<option value='+obj.id+'>'+obj.name+'</option>';
            });

            $(\"#states\").append(row);

            $(\"#states\").val(\"".$model->state_id."\");
        }
    });
}

getStates('".$model->country_id."');

$(\"#negara\").change(function(){
    var cid = $(this).val();
    
    getStates(cid);
});

";

$this->registerJs($html, \yii\web\View::POS_READY);

?>
<!-- Make sure you put this AFTER Leaflet's CSS -->

