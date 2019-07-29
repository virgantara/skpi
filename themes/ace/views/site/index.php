<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = Yii::t('app', Yii::$app->name);
?>
<div class="alert alert-block alert-success">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>

    <i class="ace-icon fa fa-check green"></i>

    Welcome to
    <strong class="green">
        <?=Yii::$app->name;?>
        <small>(v1.4)</small>
    </strong>,

</div>
<div class="row">
	<div class="col-xs-12">
<?php
use dosamigos\chartjs\ChartJs;

echo ChartJs::widget([
    'type' => 'radar',
    
    'data' => [
        'labels' => ["Pedagogi", "Profesional", "Kepribadian", "Sosial"],
        'datasets' => [
            
            [
                'label' => "Nilai EKD Universitas Darussalam Gontor",
                'backgroundColor' => "rgba(255,99,132,0.2)",
                'borderColor' => "rgba(255,99,132,1)",
                'pointBackgroundColor' => "rgba(255,99,132,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(255,99,132,1)",
                'data' => [$data['angka_pedagogik'], $data['angka_profesional'], $data['angka_kepribadian'], $data['angka_sosial']]
            ]
        ]
    ],
    
]);

?>
	</div>
</div>
