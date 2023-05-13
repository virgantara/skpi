<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\helpers\MyHelper;

/* @var $this yii\web\View */
/* @var $model app\models\RiwayatPelanggaran */

$this->title = $model->nim0->nama_mahasiswa;
$this->params['breadcrumbs'][] = ['label' => 'Riwayat Pelanggarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="riwayat-pelanggaran-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
    <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                            
    
        <div class="hr dotted"></div>

        <div>
            <div id="user-profile-1" class="user-profile row">
                <div class="col-xs-12 col-sm-3 center">
                    <div>
                        <span class="profile-picture">
                            <?php 
                            $foto_path = '';
                            if(!empty($model->nim0->foto_path)){
                                $foto_path = Url::to(['mahasiswa/foto','id'=>$model->nim0->id]);
                                echo  Html::a(Html::img($foto_path,['width'=>'240px']),'',['class'=>'popupModal','data-pjax'=>0,'data-item'=>Url::to(['mahasiswa/foto','id'=>$model->nim0->id])]);
                            }
                                
                            else{
                                if($model->nim0->jenis_kelamin == 'L')
                                    $foto_path = $this->theme->baseUrl."/images/avatars/avatar4.png";
                                else
                                    $foto_path = $this->theme->baseUrl."/images/avatars/avatar3.png";
                                echo '<img id="avatar" width="240px" class="editable img-responsive" alt="Alex\'s Avatar" src="'.$foto_path.'" />';
                            }

                             ?>
                        </span>

                        <div class="space-4"></div>

                        <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                            <div class="inline position-relative">
                                <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                    <i class="ace-icon fa fa-circle light-green"></i>
                                    &nbsp;
                                    <span class="white"><?=$mahasiswa->nama_mahasiswa;?></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="space-6"></div>

                    <div class="profile-contact-info">
                        <div class="profile-contact-links align-left">
                            <a href="<?=Url::to(['riwayat-pelanggaran/create','nim'=>$mahasiswa->nim_mhs]);?>" class="btn btn-link" id="btn-tambah-pelanggaran">
                                <i class="ace-icon fa fa-plus-circle bigger-120 green"></i>
                                Tambah Pelanggaran
                            </a>

                           <a href="<?=Url::to(['izin-mahasiswa/create','nim'=>$mahasiswa->nim_mhs]);?>" class="btn btn-link" id="btn-tambah-perizinan">
                                <i class="ace-icon fa fa-plus-circle bigger-120 green"></i>
                                Tambah Perizinan
                            </a>

                        <!--    <a href="#" class="btn btn-link">
                                <i class="ace-icon fa fa-globe bigger-125 blue"></i>
                                www.alexdoe.com
                            </a> -->
                        </div>

                        <div class="space-6"></div>

                       
                    </div>

                    <div class="hr hr12 dotted"></div>

                    <a href="<?=Url::to(['riwayat-hukuman/index','pelanggaran_id'=>$model->id]);?>" class="btn btn-link" >
                                <i class="ace-icon fa fa-list bigger-120 red"></i>
                                Riwayat Hukuman
                            </a>

                    <div class="hr hr16 dotted"></div>
                </div>

                <div class="col-xs-12 col-sm-9">

                    <div class="space-12"></div>

                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name"> NIM </div>

                            <div class="profile-info-value">
                                <span class="editable" ><?=$mahasiswa['nim_mhs'];?></span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> Nama </div>

                            <div class="profile-info-value">
                                <span class="editable" ><?=$mahasiswa['nama_mahasiswa'];?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> JK </div>

                            <div class="profile-info-value">
                                <span class="editable" ><?=$mahasiswa['jenis_kelamin'];?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> TTL </div>

                            <div class="profile-info-value">
                                <span class="editable" ><?=ucwords(strtolower($mahasiswa['tempat_lahir'])).', '.date('d-m-Y',strtotime($mahasiswa['tgl_lahir']));?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Alamat </div>

                            <div class="profile-info-value">
                                <span class="editable" >
                                <?php
                                echo ucwords(strtolower($mahasiswa->alamat));
                                $kabupaten = $mahasiswa['kabupaten'];
                                if(!empty($kabupaten)){
                                    echo ', '.$kabupaten->kab;
                                    echo ', '.(!empty($kabupaten->provinsi) ? $kabupaten->provinsi->prov : '');
                                }
                                ?>
                                    
                                </span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> HP </div>

                            <div class="profile-info-value">
                                <span class="editable" ><?=$mahasiswa['hp'];?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Kelas </div>

                            <div class="profile-info-value">
                                <span class="editable" ><?=$mahasiswa->kampus0->nama_kampus;?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Fakultas </div>

                            <div class="profile-info-value">
                                <span class="editable" ><?=$mahasiswa->kodeProdi->kodeFakultas->nama_fakultas;?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Prodi </div>

                            <div class="profile-info-value">
                                <span class="editable" ><?=$mahasiswa->kodeProdi->nama_prodi;?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Status Aktif </div>

                            <div class="profile-info-value">
                                <span class="editable" ><?=$mahasiswa->status_aktivitas;?></span>
                            </div>
                        </div>
                    </div>

                    <div class="space-20"></div>

                    <div class="widget-box transparent">
                        <div class="widget-header widget-header-small">
                            <h4 class="widget-title blue smaller">
                                <i class="ace-icon fa fa-rss orange"></i>
                                Recent Violations
                            </h4>

                            <div class="widget-toolbar action-buttons">
                                <a href="#" data-action="reload">
                                    <i class="ace-icon fa fa-refresh blue"></i>
                                </a>
&nbsp;
                                <a href="#" class="pink">
                                    <i class="ace-icon fa fa-trash-o"></i>
                                </a>
                            </div>
                        </div>
                        <?php 
                        foreach ($riwayat as $key => $value) {
                            # code...
                        
                        ?>
                        <div class="widget-body">
                            <div class="widget-main padding-8">
                                <div id="profile-feed-1" class="profile-feed">
                                    <div class="profile-activity clearfix">
                                        <div>
                                            <img class="pull-left" alt="<?=$mahasiswa['nama_mahasiswa'];?>'s avatar" src="<?=$foto_path?>" />
                                           <a class="user" href="#"><?=$mahasiswa['nama_mahasiswa'];?></a>
                                            melakukan pelanggaran <?=$value->pelanggaran->kategori->nama;?>
                                            yaitu <?=$value->pelanggaran->nama;?> pada tanggal <?=MyHelper::YmdtodmY($value->tanggal);?>

                                            <div class="time">
                                                <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                                <?=\app\helpers\MyHelper::hitungDurasi(date('Y-m-d H:i:s'),$value->created_at);?> yang lalu 
                                                <?php 
                                                if(!empty($value->surat_pernyataan)){
                                                    echo Html::a('<i class="fa fa-download"></i>',['riwayat-pelanggaran/download-surat-pernyataan','id'=>$value->id],['title'=>'Download Surat Pernyataan','style'=>'margin-right:3px']);

                                                }

                                                if(!empty($value->bukti)){
                                                    echo Html::a('<i class="fa fa-download"></i>',['riwayat-pelanggaran/download-bukti','id'=>$value->id],['title'=>'Download Bukti','target'=>'_blank']);

                                                }

                                                 ?>
                                                
                                            </div>
                                        </div>

                                        <div class="tools action-buttons">
                                            <a href="#" class="blue">
                                                <i class="ace-icon fa fa-pencil bigger-125"></i>
                                            </a>

                                            <a href="#" class="red">
                                                <i class="ace-icon fa fa-times bigger-125"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                         ?>

                    </div>

                         <div class="widget-box transparent">
                        <div class="widget-header widget-header-small">
                            <h4 class="widget-title blue smaller">
                                <i class="ace-icon fa fa-rss orange"></i>
                                Recent Dormitory Migrations
                            </h4>

                            <div class="widget-toolbar action-buttons">
                                <a href="#" data-action="reload">
                                    <i class="ace-icon fa fa-refresh blue"></i>
                                </a>
&nbsp;
                                <a href="#" class="pink">
                                    <i class="ace-icon fa fa-trash-o"></i>
                                </a>
                            </div>
                        </div>
                        <?php 
                        foreach ($riwayatKamar as $key => $value) {
                            # code...
                        
                        ?>
                        <div class="widget-body">
                            <div class="widget-main padding-8">
                                <div id="profile-feed-1" class="profile-feed">
                                    <div class="profile-activity clearfix">
                                        <div>
                                            <img class="pull-left" alt="<?=$mahasiswa['nama_mahasiswa'];?>'s avatar" src="<?=$foto_path;?>" />
                                           <a class="user" href="#"><?=$mahasiswa['nama_mahasiswa'];?></a>
                                            pindah dari <?=(!empty($value->dariKamar) ? $value->dariKamar->namaAsrama : '');?>
                                            kamar <?=(!empty($value->dariKamar) ? $value->dariKamar->nama : null);?> ke <?=$value->kamar->namaAsrama;?>
                                            kamar <?=(!empty($value->kamar) ? $value->kamar->nama : null);?> pada tanggal <?=MyHelper::YmdtodmY($value->created_at);?>

                                            <div class="time">
                                                <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                                <?=\app\helpers\MyHelper::hitungDurasi(date('Y-m-d H:i:s'),$value->created_at);?> yang lalu
                                            </div>
                                        </div>

                                       
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                         ?>

                    </div>

                    <div class="hr hr2 hr-double"></div>

                    <div class="space-6"></div>

                    <div class="center">
                        <button type="button" class="btn btn-sm btn-primary btn-white btn-round">
                            <i class="ace-icon fa fa-rss bigger-150 middle orange2"></i>
                            <span class="bigger-110">View more activities</span>

                            <i class="icon-on-right ace-icon fa fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <?php
        yii\bootstrap\Modal::begin(['id' =>'modal','size'=>'modal-lg',]);
        echo '<div class="text-center">';
        echo '<img width="100%" id="img">';
        echo '</div>';
        yii\bootstrap\Modal::end();
    ?>
<?php

$this->registerJs('

    $(document).on("click",".popupModal",function(e){
        e.preventDefault();
        var m = $("#modal").modal("show").find("#img");

        m.attr("src",$(this).data("item"))
    })

    $("#btn-tambah-pelanggaran").on(ace.click_event, function() {
        
    });

    
', \yii\web\View::POS_READY);

?>

</div>
