<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
	<div class="col-xs-12 col-sm-12 col-lg-6 col-md-6">
 <?php $form = ActiveForm::begin(); ?>  
    Tahun : 
        	<?php 
        	$tahuns = [];
        	for($i=2014;$i<date('Y',strtotime('+50 years'));$i++){
        		$tahuns[$i] = $i;
        	}
        	?>
         	<?= Html::dropDownList('tahun',$_POST['tahun'] ?: date('Y'),$tahuns, ['prompt'=>'..Pilih Tahun..','id'=>'tahun']);?>
         	Semester :  <?= Html::dropDownList('semester',$_POST['semester'] ?: 1,['1'=>'Gasal','2'=>'Genap'], ['prompt'=>'..Pilih Semester..','id'=>'semester']);?>
         	 <?= Html::submitButton(' <i class="ace-icon fa fa-check bigger-110"></i>Cari', ['class' => 'btn btn-info btn-sm','name'=>'search','value'=>1,'id'=>'btn-search']) ?>    
    <?php ActiveForm::end(); ?>
</div>
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
