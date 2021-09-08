<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrganisasiMahasiswa */

$this->title = 'Sinkronisasi Organisasi Mahasiswa';
$this->params['breadcrumbs'][] = ['label' => 'Sinkronisasi Organisasi Mahasiswa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$tahun_akademik = !empty($_GET['tahun_akademik']) ? $_GET['tahun_akademik'] : '';
$tahun_masuk = !empty($_GET['tahun_masuk']) ? $_GET['tahun_masuk'] : '';
$kampus = !empty($_GET['kampus']) ? $_GET['kampus'] : '';
 $listTahun = \app\models\SimakTahunakademik::find()->where(['>=','tahun_id', '2014'])->orderBy(['tahun_id' => SORT_DESC])->all();
$list_tahun = ArrayHelper::map($listTahun,'tahun_id','nama_tahun');
$listKampus = \app\models\SimakKampus::find()->all();
$listKampus = ArrayHelper::map($listKampus,'kode_kampus','nama_kampus');
?>

<div class="row">
    <div class="col-md-12">
        
    <h1><?= Html::encode($this->title) ?></h1>

    
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'options' => [
                'tag' => false,
            ],
        ],
        'method' => 'GET',
        'action' => Url::to(['organisasi/sync']),
        'options' => [


            'class' => 'form-horizontal'
        ]
    ]); ?>
    <?= $form->errorSummary($model,['header'=>'<div class="alert alert-danger">','footer'=>'</div>']) ?>
    <div class="form-group" >
        <label class="col-sm-3 control-label no-padding-right">Tahun Akademik</label>
        <div class="col-sm-9">
            <?= Html::dropDownList('tahun_akademik',$tahun_akademik,$list_tahun,['id'=>'tahun_akademik','class'=>'form-control','prompt'=>'- Pilih Tahun Akademik -']) ?>
        </div>
    </div>
    <div class="form-group" >
        <label class="col-sm-3 control-label no-padding-right">Kampus</label>
        <div class="col-sm-9">
            <?= Html::dropDownList('kampus',$kampus,$listKampus,['id'=>'kampus','class'=>'form-control','prompt'=>'- Pilih Kampus -']) ?>
        </div>
    </div>
    <div class="form-group" >
        <label class="col-sm-3 control-label no-padding-right">Tahun Masuk</label>
        <div class="col-sm-9">
            <?= Html::textInput('tahun_masuk',$tahun_masuk,['id'=>'tahun_masuk','class'=>'form-control']) ?>
        </div>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">

            <button class="btn btn-success" type="submit" name="btn-submit" value="1">
                <i class="fa fa-search"></i>
                Cari
            </button>
            <button class="btn btn-info" id="btn-sync">
                <i class="fa fa-refresh"></i>
                Sync Now
            </button>
            <span id="loading" style="display: none"><img width="24px" src="<?=$this->theme->baseUrl;?>/images/loading.gif" /></span>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Organisasi</th>
                    <th>Dosen Pembimbing</th>
                    <th>Tahun Akademik</th>
                    <th>Jumlah Anggota</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($list as $q=>$m)
                {
                    $query = \app\models\OrganisasiAnggota::find();
                    $query->alias('t');
                    $query->joinWith(['organisasi as org','nim0 as mhs']);

                    $query->andWhere([
                        't.organisasi_id' => $m->id,
                        // 'org.kampus' => $kampus,
                        'org.tahun_akademik' => $m->tahun_akademik,
                        'mhs.tahun_masuk' => $_GET['tahun_masuk']
                    ]);
                    $jml_anggota = $query->count();

                ?>
                <tr>
                    <td><?=$q+1;?></td>
                    <td><?=!empty($m->organisasi) ? $m->organisasi->nama : '-';?></td>
                    <td><?=!empty($m->pembimbing) ? $m->pembimbing->nama_dosen : '-';?></td>
                    <td><?=$m->tahun_akademik;?></td>
                    <td><a target="_blank" href="<?=Url::to(['organisasi-anggota/index','tahun_akademik'=>$m->tahun_akademik,'kampus'=>$kampus,'tahun_masuk'=>$tahun_masuk,'organisasi_id'=>$m->id]) ?>"><?=$jml_anggota;?></a>
                        
                        <input type="hidden" class="organisasi_id" data-item="<?=$m->id;?>" value="<?=$m->id;?>">
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>



 <?php 
$script = "

var list_organisasi = []

$('.organisasi_id').each(function(i, obj){
    var oid = $(this).data('item')
    list_organisasi.push(oid)
})

$(document).on('click','#btn-sync',function(e){
    e.preventDefault()
    sync(list_organisasi)
})
    

function sync(list_tmp){
    var obj = new Object;
    obj.organisasi_id = list_tmp
    
    $.ajax({
        url         : '".Url::to(['organisasi/ajax-sync'])."',
        type        : 'POST',
        data        : {
            dataPost : obj
        },
        async       : true,
        beforeSend  : function(){
            Swal.showLoading()
        },
        error : function(e){
            Swal.close()
            console.log(e.responseText)
        },
        success     : function(data){
            Swal.hideLoading()
            var res = $.parseJSON(data)

            if(res.code == 200){
                Swal.fire(
                    'Good job!',
                    res.message,
                    'success'
                )
            }

            else{
                Swal.fire(
                    'Oops',
                    res.message,
                    'error'
                )
            }
        }

    })
}
";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);
 ?>