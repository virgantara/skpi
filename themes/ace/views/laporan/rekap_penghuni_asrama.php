<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\models\Asrama;

/* @$$this yii\web\View */
/* @$$model app\models\BarangOpname */
/* @$$form yii\widgets\ActiveForm */

$this->title = 'Laporan Rekap Penghuni Asrama';
$this->params['breadcrumbs'][] = ['label' => 'EKD', 'url' => ['laporan/rekap-penghuni-asrama']];
$this->params['breadcrumbs'][] = $this->title;
// $listDepartment = \app\models\Departemen::getListDepartemens();
?>


<div class="row">
    <div class="col-sm-12">
        <h3>Rekap Penghuni Per Asrama</h3>
        <table class="table table-striped table-bordered table-hover" id="tabel_ekd">
            
            <thead>
                <tr>
                    <th>No</th>
                    <th>Asrama</th>
                    <th>Total</th>    
                </tr>
            </thead>
            <tbody>
                
                <?php 

                $i = 0;
                foreach($results as $q=> $item)
                {
                    $i++;
                ?>
                <tr>
                <td><?=$i;?></td>
                <td><?=$item['nama'];?></td>
                <td><?=$item['total'];?></td>
                </tr>
                <?php
                    
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'options' => [
                'tag' => false,
            ],
        ],
        'options' => [
            'class' => 'form-horizontal'
        ]
    ]); ?> 

<?php
    echo Html::submitButton(' <i class="ace-icon fa fa-download bigger-110"></i>Export', ['class' => 'btn btn-success','name'=>'btn-export','value'=>1,'id'=>'btn-export'])
?>
<?php ActiveForm::end(); ?>
  
</div>
<?php

$this->registerJs(' 
    $(document.body).on(\'click\', \'.ui-datepicker-close\', function (e) {
        $value = $(\'.ui-datepicker-year :selected\').text();
        $(\'#tahun\').val(value);
    });



    ', \yii\web\View::POS_READY);

?>