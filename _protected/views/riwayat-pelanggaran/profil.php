<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\helpers\MyHelper;

/* @var $this yii\web\View */
/* @var $model app\models\RiwayatPelanggaran */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', Yii::$app->name);
?>
<div class="row">
	<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
							
	
		<div class="hr dotted"></div>

		<div>
			<div id="user-profile-1" class="user-profile row">
				<div class="col-xs-12 col-sm-3 center">
					<div>
						<span class="profile-picture">
							<img id="avatar" class="editable img-responsive" alt="Alex's Avatar" src="<?=$this->theme->baseUrl;?>/images/avatars/profile-pic.jpg" />
						</span>

						<div class="space-4"></div>

						<div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
							<div class="inline position-relative">
								<a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
									<i class="ace-icon fa fa-circle light-green"></i>
									&nbsp;
									<span class="white"><?=$mahasiswa['nama_mahasiswa'];?></span>
								</a>

								<ul class="align-left dropdown-menu dropdown-caret dropdown-lighter">
									<li class="dropdown-header"> Change Status </li>

									<li>
										<a href="#">
											<i class="ace-icon fa fa-circle green"></i>
&nbsp;
											<span class="green">Available</span>
										</a>
									</li>

									<li>
										<a href="#">
											<i class="ace-icon fa fa-circle red"></i>
&nbsp;
											<span class="red">Busy</span>
										</a>
									</li>

									<li>
										<a href="#">
											<i class="ace-icon fa fa-circle grey"></i>
&nbsp;
											<span class="grey">Invisible</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="space-6"></div>

					<div class="profile-contact-info">
						<div class="profile-contact-links align-left">
							<a href="<?=Url::to(['riwayat-pelanggaran/create','nim'=>$mahasiswa['nim_mhs']]);?>" class="btn btn-link" id="btn-tambah-pelanggaran">
								<i class="ace-icon fa fa-plus-circle bigger-120 green"></i>
								Tambah Pelanggaran
							</a>
							
							   <a href="<?=Url::to(['izin-mahasiswa/create','nim'=>$mahasiswa['nim_mhs']]);?>" class="btn btn-link" id="btn-tambah-perizinan">
                                <i class="ace-icon fa fa-plus-circle bigger-120 green"></i>
                                Tambah Perizinan
                            </a>

						<!-- 	<a href="#" class="btn btn-link">
								<i class="ace-icon fa fa-globe bigger-125 blue"></i>
								www.alexdoe.com
							</a> -->
						</div>

						<div class="space-6"></div>

						<div class="profile-social-links align-center">
							<a href="#" class="tooltip-info" title="" data-original-title="Visit my Facebook">
								<i class="middle ace-icon fa fa-facebook-square fa-2x blue"></i>
							</a>

							<a href="#" class="tooltip-info" title="" data-original-title="Visit my Twitter">
								<i class="middle ace-icon fa fa-twitter-square fa-2x light-blue"></i>
							</a>

							<a href="#" class="tooltip-error" title="" data-original-title="Visit my Pinterest">
								<i class="middle ace-icon fa fa-pinterest-square fa-2x red"></i>
							</a>
						</div>
					</div>

					<div class="hr hr12 dotted"></div>

					<div class="clearfix">
						<div class="grid2">
							<span class="bigger-175 blue">25</span>

							<br />
							Followers
						</div>

						<div class="grid2">
							<span class="bigger-175 blue">12</span>

							<br />
							Following
						</div>
					</div>

					<div class="hr hr16 dotted"></div>
				</div>

				<div class="col-xs-12 col-sm-9">
					<!-- <div class="center">
						<span class="btn btn-app btn-sm btn-light no-hover">
							<span class="line-height-1 bigger-170 blue"> 1,411 </span>

							<br />
							<span class="line-height-1 smaller-90"> Views </span>
						</span>

						<span class="btn btn-app btn-sm btn-yellow no-hover">
							<span class="line-height-1 bigger-170"> 32 </span>

							<br />
							<span class="line-height-1 smaller-90"> Followers </span>
						</span>

						<span class="btn btn-app btn-sm btn-pink no-hover">
							<span class="line-height-1 bigger-170"> 4 </span>

							<br />
							<span class="line-height-1 smaller-90"> Projects </span>
						</span>

						<span class="btn btn-app btn-sm btn-grey no-hover">
							<span class="line-height-1 bigger-170"> 23 </span>

							<br />
							<span class="line-height-1 smaller-90"> Reviews </span>
						</span>

						<span class="btn btn-app btn-sm btn-success no-hover">
							<span class="line-height-1 bigger-170"> 7 </span>

							<br />
							<span class="line-height-1 smaller-90"> Albums </span>
						</span>

						<span class="btn btn-app btn-sm btn-primary no-hover">
							<span class="line-height-1 bigger-170"> 55 </span>

							<br />
							<span class="line-height-1 smaller-90"> Contacts </span>
						</span>
					</div>
 -->
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
								echo $mahasiswa['kecamatan'];
								echo ' '.$mahasiswa['kab'];
								echo ' '.$mahasiswa['prov'];
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
							<div class="profile-info-name"> Kampus </div>

							<div class="profile-info-value">
								<span class="editable" ><?=$mahasiswa['nama_kampus'];?></span>
							</div>
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name"> Fakultas </div>

							<div class="profile-info-value">
								<span class="editable" ><?=$mahasiswa['nama_fakultas'];?></span>
							</div>
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name"> Prodi </div>

							<div class="profile-info-value">
								<span class="editable" ><?=$mahasiswa['nama_prodi'];?></span>
							</div>
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name"> Status Aktif </div>

							<div class="profile-info-value">
								<span class="editable" ><?=$mahasiswa['status_aktivitas'];?></span>
							</div>
						</div>
					</div>

					<div class="space-20"></div>

					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
							<h4 class="widget-title blue smaller">
								<i class="ace-icon fa fa-rss orange"></i>
								Recent Activities
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
											<img class="pull-left" alt="<?=$mahasiswa['nama_mahasiswa'];?>'s avatar" src="<?=$this->theme->baseUrl;?>/images/avatars/avatar5.png" />
											<a class="user" href="#"><?=$mahasiswa['nama_mahasiswa'];?></a>
											melakukan pelanggaran <?=$value->pelanggaran->kategori->nama;?>
											yaitu <?=$value->pelanggaran->nama;?> pada tanggal <?=MyHelper::YmdtodmY($value->tanggal);?>

											<div class="time">
												<i class="ace-icon fa fa-clock-o bigger-110"></i>
												<?=\app\helpers\MyHelper::hitungDurasi(date('Y-m-d H:i:s'),$value->created_at);?> yang lalu
											</div>
										</div>

										<div class="tools action-buttons">
											<a href="<?=Url::to(['riwayat-pelanggaran/update','id'=>$value->id]);?>" class="blue">
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
						<?php 
						foreach ($riwayatIzin as $key => $value) {
							# code...
						
						?>
						<div class="widget-body">
							<div class="widget-main padding-8">
								<div id="profile-feed-1" class="profile-feed">
									<div class="profile-activity clearfix">
										<div>
											<img class="pull-left" alt="<?=$mahasiswa['nama_mahasiswa'];?>'s avatar" src="<?=$this->theme->baseUrl;?>/images/avatars/avatar5.png" />
											<a class="user" href="#"><?=$mahasiswa['nama_mahasiswa'];?></a>
											izin <?=$value->keperluan_id == '1' ? 'Pribadi' : 'Kampus';?>
											yaitu <?=$value->alasan;?>. Berangkat tanggal <?=MyHelper::YmdtodmY($value->tanggal_berangkat,true);?> dan pulang tanggal <?=MyHelper::YmdtodmY($value->tanggal_pulang,true);?> 

											<div class="time">
												<i class="ace-icon fa fa-clock-o bigger-110"></i>
												<?=\app\helpers\MyHelper::hitungDurasi(date('Y-m-d H:i:s'),$value->created_at);?> yang lalu
											</div>
										</div>

										<div class="tools action-buttons">
											<a href="<?=Url::to(['izin-mahasiswa/update','id'=>$value->id]);?>" class="blue">
												<i class="ace-icon fa fa-pencil bigger-125"></i>
											</a>

											<a onclick="return confirm('Hapus data ini?')" href="<?=Url::to(['izin-mahasiswa/delete','id'=>$value->id]);?>" class="red">
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

$this->registerJs(' 

	$("#btn-tambah-pelanggaran").on(ace.click_event, function() {
		
	});

    ', \yii\web\View::POS_READY);

?>