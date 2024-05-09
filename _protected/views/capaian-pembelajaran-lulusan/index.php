<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\ProgramStudi */
/* @var $form yii\widgets\ActiveForm */


$this->title = 'Capaian Pembelajaran';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="body">
    <p>
    <div class="row">
        <div class="col-lg-4">
            Pilih Fakultas: 
            <?= Select2::widget([
                'name' => 'fakultas',
                'data' => ArrayHelper::map(\app\models\SimakMasterfakultas::find()->orderBy(['nama_fakultas'=>SORT_ASC])->all(),'kode_fakultas','nama_fakultas'),

                'options'=>['id'=>'fakultas_id','placeholder'=>Yii::t('app','- Pilih Fakultas -')],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>

        <div class="col-lg-4">
            Pilih Prodi: 
            <?= DepDrop::widget([
            'name' => 'prodi',
            'type'=>DepDrop::TYPE_SELECT2,
            'options'=>['id'=>'kode_prodi'],
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions'=>[
                'depends'=>['fakultas_id'],
                'initialize' => true,
                'placeholder'=>'- Pilih Prodi -',
                'url'=>Url::to(['/program-studi/subprodi'])
            ]
        ])?>
        </div>
        
    </div>
    </p>
    

        <table id="tabel-cpl" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th width="50%">Konten</th>
                    <th>Content</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        
           

    <div class="alert alert-info">
        <h3>Data Capaian Pembelajaran diambil dari SIAKAD menu Kurikulum > CPL Prodi</h3>
    </div>

</div>

</div>
<?php

$this->registerJs(' 


$(document).on("change","#kode_prodi",function(e){
    let obj = new Object
    obj.kode_prodi = $(this).val()

    if(obj.kode_prodi){


        $.ajax({

            type : "POST",
            url : "/capaian-pembelajaran-lulusan/ajax-get",
            data : {
                dataPost : obj
            },
           
            beforeSend: function(){
               Swal.fire({
                    title : "Please wait",
                    html: "Processing your request...",
                    
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                    
                })
            },
            error: function(e){
                Swal.close()
            },
            success: function(data){
                Swal.close()
                var data = $.parseJSON(data)
                $("#tabel-cpl > tbody").empty()
                let row = ""
                if(data.code == 200){
                    
                    $.each(data.items, function(i,obj){
                        row += "<tr>"
                        row += "<td>"
                        row += "["+obj.kode+"] "+obj.deskripsi
                        row += "</td>"
                        row += "<td>"
                        row += obj.deskripsi_en
                        row += "</td>"
                        row += "</tr>"
                    })
                    $("#tabel-cpl > tbody").append(row)
                }
                
                else{
                    Swal.fire({
                        title: \'Oops!\',
                        icon: \'error\',
                        text: data.message
                    });

                }
            }
        })
    }
})


', \yii\web\View::POS_READY);

?>