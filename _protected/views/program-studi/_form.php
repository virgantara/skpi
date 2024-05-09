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
?>

<div class="body">
    <p>
    <div class="row">
        <div class="col-lg-2">Pilih Fakultas: </div>
        <div class="col-lg-4">
            <?= Select2::widget([
                'name' => 'fakultas',
                'data' => ArrayHelper::map(\app\models\SimakMasterfakultas::find()->orderBy(['nama_fakultas'=>SORT_ASC])->all(),'kode_fakultas','nama_fakultas'),

                'options'=>['id'=>'fakultas_id','placeholder'=>Yii::t('app','- Pilih Fakultas -')],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>
        <div class="col-lg-2">Pilih Prodi: </div>
        <div class="col-lg-4">
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
    

    
    
    <?php $form = ActiveForm::begin([
    	'options' => [
            'id' => 'form_validation',
    	]
    ]); ?>

        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th width="30%">Program Studi<br><i>Major</i></th>
                <td><span id="span_nama_prodi"></span></td>
                <td><span id="span_nama_prodi_en"></span></td>
            </tr>
            <tr>
                <th>Fakultas<br><i>Faculty</i></th>
                <td><span id="span_nama_fakultas"></span></td>
                <td><span id="span_nama_fakultas_en"></span></td>
            </tr>
            <tr>
                <th>Jenjang Pendidikan<br><i>Level of education</i></th>
                <td><span id="span_jenjang"></span></td>
                <td><span id="span_jenjang_en"></span></td>
            </tr>
            <tr>
                <th>Gelar yang diberikan<br><i>The conferred title</i></th>
                <td><span id="span_gelar_lulusan"></span></td>
                <td><span id="span_gelar_lulusan_en"></span></td>
            </tr>
            <tr>
                <th>Status Profesi(Bila ada)<br><i>Professional Status (If Applicable)</i></th>
                <td><span id="span_status_profesi"></span></td>
                <td><span id="span_status_profesi_en"></span></td>
            </tr>
            <tr>
                <th>Bahasa Pengantar Kuliah<br><i>Language of Instruction</i></th>
                <td><span id="span_bahasa_pengantar"></span></td>
                <td><span id="span_bahasa_pengantar_en"></span></td>
            </tr>
            <tr>
                <th>Jenjang Kualifikasi sesuai KKNI<br><i>Level of Qualification</i></th>
                <td><span id="span_jenjang_kkni"></span></td>
                <td><span id="span_jenjang_kkni_en"></span></td>
            </tr>
            <tr>
                <th>Persyaratan Penerimaan<br><i>Entry Requirements</i></th>
                <td><span id="span_syarat_penerimaan"></span></td>
                <td><span id="span_syarat_penerimaan_en"></span></td>
            </tr>
        </table>
        <h3>Nomor dan Status Akreditasi Program Studi</h3>
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th width="30%" rowspan="3">Akreditasi Nasional<br><i>National Accreditation</i></th>
                <td width="30%">Peringkat<br><i>Ranking</i></td>
                <td><span id="span_status_akreditasi"></span></td>
            </tr>
            <tr>
                <td>Nomor Dokumen<br><i>Document Number</i></td>
                <td><span id="span_no_sk_akreditasi"></span></td>
            </tr>
            <tr>
                <td>Lembaga<br><i>Institution</i></td>
                <td><span id="span_lembaga_akreditasi"></span></td>
            </tr>
            <tr>
                <th width="30%" rowspan="3">Akreditasi Internasional<br><i>International Accreditation</i></th>
                <td>Peringkat<br><i>Ranking</i></td>
                <td><span id="span_status_akreditasi_internasional"></span></td>
            </tr>
            <tr>
                <td>Nomor Dokumen<br><i>Document Number</i></td>
                <td><span id="span_no_sk_akreditasi_internasional"></span></td>
            </tr>
            <tr>
                <td>Lembaga<br><i>Institution</i></td>
                <td><span id="span_lembaga_akreditasi_internasional"></span></td>
            </tr>
        </table>
        <h3>Informasi Terkait Pengesahan SKPI</h3>
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th width="30%" rowspan="2">Dekan Fakultas<br><i>Dean of Faculty</i></th>
                <td width="30%">Nama<br><i>Name</i></td>
                <td><span id="span_dekan_nama_dosen"></span></td>
            </tr>
            <tr>
                <td>NIY<br><i>Foundation ID Number</i></td>
                <td><span id="span_dekan_niy"></span></td>
            </tr>
            <tr>
                <th width="30%" rowspan="2">Ketua Program Studi<br><i>Head of Department</i></th>
               <td width="30%">Nama<br><i>Name</i></td>
                <td><span id="span_kaprodi_nama_dosen"></span></td>
            </tr>
            <tr>
                <td>NIY<br><i>Foundation ID Number</i></td>
                <td><span id="span_kaprodi_niy"></span></td>
            </tr>
        </table>
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary waves-effect']) ?>
    
    <?php ActiveForm::end(); ?>

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
            url : "/program-studi/ajax-get",
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
                
                if(data.code == 200){
                
                    $("#span_nama_prodi").html(data.prodi.nama_prodi)
                    $("#span_nama_prodi_en").html(data.prodi.nama_prodi_en)

                    $("#span_nama_fakultas").html(data.fakultas.nama_fakultas)
                    $("#span_nama_fakultas_en").html(data.fakultas.nama_fakultas_en)

                    $("#span_dekan_niy").html(data.dekan.niy)
                    $("#span_dekan_nama_dosen").html(data.dekan.nama_dosen)

                    $("#span_kaprodi_niy").html(data.kaprodi.niy)
                    $("#span_kaprodi_nama_dosen").html(data.kaprodi.nama_dosen)
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