<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

\app\assets\LeafletAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Cities */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cities-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state_id')->textInput() ?>

    <?= $form->field($model, 'state_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country_id')->textInput() ?>

    <?= $form->field($model, 'country_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'latitude')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'longitude')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'wikiDataId')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<div id="mapid" style="width: 50%; height: 400px;"></div>
    
<?php

$lat = $model->latitude;
$lng = $model->longitude;

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

$this->registerJs($html, \yii\web\View::POS_READY);

?>
<!-- Make sure you put this AFTER Leaflet's CSS -->

