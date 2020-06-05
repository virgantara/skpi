<?php 
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

use yii\jui\AutoComplete;
use yii\web\JsExpression;

$this->title = 'Geografis Konsulat';
$this->params['breadcrumbs'][] = $this->title;


\app\assets\LeafletAsset::register($this);
?>


<h1><?=$this->title;?></h1>

<div id="mapid" style="width: 100%; height: 700px;"></div>
	
<?php

$html = "
	var mymap = L.map('mapid').setView([-7.9023, 111.4923], 6.5);

	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href=\"https://www.openstreetmap.org/\">OpenStreetMap</a> contributors, ' +
			'<a href=\"https://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, ' +
			'Imagery © <a href=\"https://www.mapbox.com/\">Mapbox</a>',
		id: 'mapbox/streets-v11',
		tileSize: 512,
		zoomOffset: -1
	}).addTo(mymap);


	
";

foreach($results as $res)
{
	$html .= "

	var marker = L.marker([".$res['latitude'].", ".$res['longitude']."]).addTo(mymap);
	marker.bindPopup('".$res['name']." (".$res['total']." mahasiswa) ');

	";
}

$this->registerJs($html, \yii\web\View::POS_READY);

?>
<!-- Make sure you put this AFTER Leaflet's CSS -->
