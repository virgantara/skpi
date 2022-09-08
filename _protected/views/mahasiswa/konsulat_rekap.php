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
<style>#map { width: 800px; height: 500px; }
.info { 
	padding: 6px 8px; font: 14px/16px Arial, Helvetica, sans-serif; background: white; background: rgba(255,255,255,0.8); box-shadow: 0 0 15px rgba(0,0,0,0.2); border-radius: 5px; 
} 
.info h4 { 
	margin: 0 0 5px; color: #777; 
}
.legend { 
	text-align: left; line-height: 18px; color: #555; 
} 
.legend i { 
	width: 18px; height: 18px; float: left; margin-right: 8px; opacity: 0.7; 
}
</style>

<h1><?=$this->title;?></h1>

<div id="mapid" style="width: 100%; height: 700px;"></div>
	
<?php

$html = "

function getPropinsi(map, callback){
	$.ajax({
      	url: '".Url::to(['simak-propinsi-batas/ajax-list-batas'])."',
      	type: 'POST',
      	async : true,
      	success: function (data) {
      		var hasil = $.parseJSON(data)

      		callback(null, hasil)
      	}

    })
}

	var layerMarker = L.layerGroup()
	var layerProvinsi = L.layerGroup()

	var mymap = L.map('mapid',{
    layers: [layerProvinsi]
    }).setView([-7.9023, 111.4923], 6.5);

	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href=\"https://www.openstreetmap.org/\">OpenStreetMap</a> contributors, ' +
			'<a href=\"https://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, ' +
			'Imagery © <a href=\"https://www.mapbox.com/\">Mapbox</a>',
		id: 'mapbox/streets-v11',
		tileSize: 512,
		zoomOffset: -1
	}).addTo(mymap);

	// control that shows state info on hover
	var info = L.control();

	info.onAdd = function (mymap) {
		this._div = L.DomUtil.create('div', 'info');
		this.update();
		return this._div;
	};

	info.update = function (props) {
		this._div.innerHTML = '<h4>Kepadatan Konsulat per provinsi</h4>' +  (props ?
			'<b>' + props.Propinsi + '</b><br />' + props.density + ' mhs'
			: 'Hover over a province');
	};

	info.addTo(mymap);


	// get color depending on population density value
	function getColor(d) {
		return d > 4000 ? '#800026' :
				d > 3000  ? '#BD0026' :
				d > 2000  ? '#E31A1C' :
				d > 1000  ? '#FC4E2A' :
				d > 500   ? '#FD8D3C' :
				d > 250   ? '#FEB24C' :
				d > 50   ? '#FED976' :
							'#FFEDA0';
	}

	function style(feature) {
		return {
			weight: 2,
			opacity: 1,
			color: 'white',
			dashArray: '3',
			fillOpacity: 0.7,
			fillColor: getColor(feature.properties.density)
		};
	}

	function highlightFeature(e) {
		var layer = e.target;

		layer.setStyle({
			weight: 5,
			color: '#666',
			dashArray: '',
			fillOpacity: 0.7
		});

		if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
			layer.bringToFront();
		}

		info.update(layer.feature.properties);
	}

	var geojson;

	function resetHighlight(e) {
		geojson.resetStyle(e.target);
		info.update();
	}

	function zoomToFeature(e) {
		mymap.fitBounds(e.target.getBounds());
	}

	function onEachFeature(feature, layer) {
		layer.on({
			mouseover: highlightFeature,
			mouseout: resetHighlight,
			click: zoomToFeature
		});
	}

	
	
	var overlays = {
		'Kota' : layerMarker,
		'Provinsi' : layerProvinsi
	}
	L.control.layers(null, overlays).addTo(mymap);

	getPropinsi(mymap, function(err, res){
		// console.log(geodata)
		geojson = L.geoJson(res, {
			style: style,
			onEachFeature: onEachFeature
		}).addTo(layerProvinsi);

		var legend = L.control({position: 'bottomright'});

		legend.onAdd = function (map) {

			var div = L.DomUtil.create('div', 'info legend'),
				grades = [0, 50, 250, 500, 1000, 2000, 3000, 4000],
				labels = [],
				from, to;

			for (var i = 0; i < grades.length; i++) {
				from = grades[i];
				to = grades[i + 1];

				labels.push(
					'<i style=\"background:' + getColor(from + 1) + '\"></i> ' +
					from + (to ? '&ndash;' + to : '+'));
			}

			div.innerHTML = labels.join('<br>');
			return div;
		};

		legend.addTo(mymap);
	})
";

foreach($results as $res)
{
	$html .= "

	var marker = L.marker([".$res['latitude'].", ".$res['longitude']."]);
	marker.bindPopup('".$res['name']." (".$res['total']." mahasiswa) ');
	marker.addTo(layerMarker)

	";
}

$this->registerJs($html, \yii\web\View::POS_READY);

?>
<!-- Make sure you put this AFTER Leaflet's CSS -->
