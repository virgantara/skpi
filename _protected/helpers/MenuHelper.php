<?php

namespace app\helpers;

use Yii;

/**
 * Css helper class.
 */
class MenuHelper
{
	public static function getMenuItems()
	{

		// $userRole = Yii::$app->user->identity->access_role;
		$menuItems = [];
		// if(!Yii::$app->user->isGuest){

		$menuItems[] = [
			'label' => '<i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> Dashboard </span>',
			'url' => ['site/index']
		];
		// }

		$menuItems[] = [
			'label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> SIMKATMAWA </span><i class="caret"></i>',
			'url' => '#',
			'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
			'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
			'items' => [

				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i>MBKM <b class="arrow fa fa-angle-down"></b>',
					'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
					'url' => ['#'],
					'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
					'items' => [

						['label' => ('<i class="menu-icon fa fa-caret-right"></i>Pertukaran Pelajar'), 'url' => ['simkatmawa-mbkm/pertukaran-pelajar']],
						['label' => ('<i class="menu-icon fa fa-caret-right"></i>Magang / Praktik Kerja'), 'url' => ['simak-magang/index']],
						['label' => ('<i class="menu-icon fa fa-caret-right"></i>Mengajar di Sekolah'), 'url' => ['simkatmawa-mbkm/mengajar-di-sekolah']],
						['label' => ('<i class="menu-icon fa fa-caret-right"></i>Penelitian / Riset'), 'url' => ['simkatmawa-mbkm/penelitian']],
						['label' => ('<i class="menu-icon fa fa-caret-right"></i>Proyek Kemanusiaan'), 'url' => ['simkatmawa-mbkm/proyek-kemanusiaan']],
						['label' => ('<i class="menu-icon fa fa-caret-right"></i>Proyek Desa'), 'url' => ['simkatmawa-mbkm/proyek-desa']],
						['label' => ('<i class="menu-icon fa fa-caret-right"></i>Wirausaha'), 'url' => ['simkatmawa-mbkm/wirausaha']],
						['label' => ('<i class="menu-icon fa fa-caret-right"></i>Studi / Proyek Independen'), 'url' => ['simkatmawa-mbkm/studi']],
						['label' => ('<i class="menu-icon fa fa-caret-right"></i>Pengabdian Mahasiswa Kepada Masyarakat'), 'url' => ['simkatmawa-mbkm/pengabdian-masyarakat']],

					],
				],
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i>Non Lomba <b class="arrow fa fa-angle-down"></b>',
					'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
					'url' => ['#'],
					'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
					'items' => [

						['label' => ('<i class="menu-icon fa fa-caret-right"></i>Pembinaan Mental Kebangsaan'), 'url' => ['simkatmawa-non-lomba/pembinaan-mental-kebangsaan']],

					],
				],
				[
					'label' => '<i class="menu-icon fa fa-caret-right {url}"></i>Mandiri  <b class="arrow fa fa-angle-down"></b>',
					'url' => ['simkatmawa-mandiri/index'],
					'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
					'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
					'items' => [

						['label' => ('<i class="menu-icon fa fa-caret-right"></i>Rekognisi'), 'url' => ['simkatmawa-mandiri/rekognisi']],
						['label' => ('<i class="menu-icon fa fa-caret-right"></i>Kegiatan Mandiri'), 'url' => ['simkatmawa-mandiri/kegiatan-mandiri']],

					],
				],
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Kegiatan Belmawa',
					'url' =>  ['simkatmawa-belmawa/index'],
				],
				[
					'label' => '<i class="menu-icon fa fa-cog"></i>Master <b class="arrow fa fa-angle-down"></b>',
					'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
					'visible' => Yii::$app->user->can('admin'),
					'url' => ['#'],
					'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
					'items' => [

						['label' => ('<i class="menu-icon fa fa-caret-right"></i> Kategori Kegiatan Pembinaan Mental Kebangsaan'), 'url' => ['simkatmawa-kegiatan/index']],
						['label' => ('<i class="menu-icon fa fa-caret-right"></i> Kategori Rekognisi'), 'url' => ['simkatmawa-rekognisi/index']],
						['label' => ('<i class="menu-icon fa fa-caret-right"></i> Kategori Kegiatan Belmawa'), 'url' => ['simkatmawa-belmawa-kategori/index']],
						['label' => ('<i class="menu-icon fa fa-caret-right"></i> Level'), 'url' => ['simkatmawa-level/index']],
						['label' => ('<i class="menu-icon fa fa-caret-right"></i> Apresiasi'), 'url' => ['simkatmawa-apresiasi/index']],

					],
				],
			]
		];

		$menuItems[] = [
			'label' => '<i class="menu-icon fa fa-book"></i><span class="menu-text"> Layanan Surat </span><i class="caret"></i>', 'url' => '#',
			'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
			'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
			'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('operatorUnit'),
			'items' => [
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Surat Bebas Sanksi',
					'url' => ['/simak-layanan-surat/index','jenis_surat' => 2],
					'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('operatorUnit'),

				],
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Surat Lulus AKPAM',
					'url' => ['/simak-layanan-surat/index','jenis_surat' => 3],
					'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('operatorUnit'),

				],
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Surat Bebas Asrama',
					'url' => ['/simak-layanan-surat/index','jenis_surat' => 4],
					'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('operatorUnit'),

				],
			]
		];

		$menuItems[] = [
			'label' => '<i class="menu-icon fa fa-users"></i><span class="menu-text"> Kompetensi </span>',
			'url' => ['simak-kegiatan-kompetensi/kartu-kompetensi']
		];

		// echo '<pre>';print_r(Yii::$app->user->identity);die;

		if (Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('event') || Yii::$app->user->can('akpam') || Yii::$app->user->can('operatorUnit')) {

			$menuItems[] = [
				'label' => '<i class="menu-icon fa fa-book"></i><span class="menu-text"> Pelanggaran </span><i class="caret"></i>', 'url' => '#',
				'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
				'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
				'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('operatorUnit'),
				'items' => [
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Daftar Pelanggaran',
						'url' => ['/riwayat-pelanggaran/index'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('operatorUnit'),

					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Input Pelanggaran',
						'url' => ['/riwayat-pelanggaran/cari-mahasiswa'],
						'visible' => Yii::$app->user->can('operatorCabang'),
					],
				]
			];

			$menuItems[] = [
				'label' => '<i class="menu-icon fa fa-book"></i><span class="menu-text"> Perizinan </span><i class="caret"></i>', 'url' => '#',
				'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
				'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
				'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('kaprodi') || Yii::$app->user->can('kepalaBAAK') || Yii::$app->user->can('stafBAPAK') || Yii::$app->user->can('asesor') || Yii::$app->user->can('operatorUnit'),
				'items' => [
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Hari ini',
						'url' => ['/izin-harian/today'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('kaprodi') || Yii::$app->user->can('kepalaBAAK') || Yii::$app->user->can('stafBAPAK') || Yii::$app->user->can('asesor'),

					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Riwayat Izin Harian',
						'url' => ['/izin-harian/index'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('kaprodi') || Yii::$app->user->can('kepalaBAAK') || Yii::$app->user->can('stafBAPAK') || Yii::$app->user->can('asesor'),

					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Daftar Perizinan',
						'url' => ['/izin-mahasiswa/index'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('kaprodi') || Yii::$app->user->can('kepalaBAAK') || Yii::$app->user->can('stafBAPAK') || Yii::$app->user->can('asesor') || Yii::$app->user->can('operatorUnit'),

					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Input Perizinan',
						'url' => ['/izin-mahasiswa/create'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('stafBAPAK') || Yii::$app->user->can('operatorUnit'),
					],
				]
			];

			$menuItems[] = [
				'label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Events </span><i class="caret"></i>',
				'url' => '#',
				'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
				'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
				'items' => [

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Today\'s Event',
						'url' => ['events/daily', 'daily' => 'today'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('event') || Yii::$app->user->can('akpam') || Yii::$app->user->can('operatorUnit'),
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Upcoming Events',
						'url' => ['events/daily', 'daily' => 'upcoming'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('event') || Yii::$app->user->can('akpam') || Yii::$app->user->can('operatorUnit'),
					],
					[
						'label' => '<hr style="padding:0px;margin:0px">'
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Previous Events',
						'url' => ['events/daily', 'daily' => 'previous'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('event') || Yii::$app->user->can('akpam') || Yii::$app->user->can('operatorUnit'),
					],
				]
			];

			$menuItems[] = [
				'label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Harian </span><i class="caret"></i>',
				'url' => '#',
				'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
				'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
				'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('event') || Yii::$app->user->can('akpam'),
				'items' => [

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Rutin',
						'url' => ['simak-kegiatan-harian-mahasiswa/index'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('event') || Yii::$app->user->can('akpam'),
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Rekap Harian',
						'url' => ['simak-kegiatan-harian/rekap'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('event') || Yii::$app->user->can('akpam'),
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Rekap Bulanan',
						'url' => ['simak-kegiatan-harian/rekap-bulanan'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('event') || Yii::$app->user->can('akpam'),
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Rekap Bulanan Per Kegiatan',
						'url' => ['simak-kegiatan-harian/rekap-bulanan-persholat'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('event') || Yii::$app->user->can('akpam'),
					],
					[
						'label' => '<hr style="padding:0px;margin:0px">'
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Riwayat',
						'url' => ['simak-kegiatan-harian-mahasiswa/riwayat'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('event') || Yii::$app->user->can('akpam'),
					],

				]
			];
		}




		if (Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('asesor') || Yii::$app->user->can('akpam') || Yii::$app->user->can('operatorUnit')) {
			$menuItems[] = [
				'label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Asrama </span><i class="caret"></i>',
				'url' => '#',
				'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
				'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
				'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('asesor') || Yii::$app->user->can('operatorUnit'),
				'items' => [

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Data Penghuni Asrama',
						'url' => ['asrama/mahasiswa'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('asesor') || Yii::$app->user->can('operatorUnit'),
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Pindah Kamar',
						'url' => ['/asrama/pindah'],
						'visible' => Yii::$app->user->can('operatorCabang'),

					],
				]
			];
			$menuItems[] = [
						'label' => '<i class="menu-icon fa fa-users"></i>Koordinator ',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('admin'),
						'url' => ['mahasiswa/koordinator'],
					];
			$menuItems[] = [
				'label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Kegiatan </span><i class="caret"></i>',
				'url' => '#',
				'visible' => Yii::$app->user->can('admin'),
				'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
				'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
				'items' => [

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Manage',
						'url' => ['simak-kegiatan/index'],
						'visible' => Yii::$app->user->can('admin'),
					],

				]
			];

			$menuItems[] = [
				'label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Organisasi/Kepanitiaan </span><i class="caret"></i>',
				'url' => '#',
				'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
				'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
				'items' => [

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Manage',
						'url' => ['organisasi-mahasiswa/index'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('asesor') || Yii::$app->user->can('akpam') || Yii::$app->user->can('operatorUnit'),
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Tambah',
						'url' => ['organisasi-mahasiswa/create'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('akpam') || Yii::$app->user->can('operatorUnit'),

					],

				]
			];



			$menuItems[] = [
				'label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Konsulat </span><i class="caret"></i>',
				'url' => '#',
				'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
				'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
				'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('asesor'),
				'items' => [
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Pemetaan WNI',
						'url' => ['mahasiswa/konsulat-wni'],
						'visible' => Yii::$app->user->can('operatorCabang'),
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Pemetaan WNA',
						'url' => ['mahasiswa/konsulat'],
						'visible' => Yii::$app->user->can('operatorCabang'),
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Geografis',
						'url' => ['/mahasiswa/konsulat-rekap'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('asesor'),

					],
				]
			];


			$menuItems[] = [
				'label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Dapur </span><i class="caret"></i>',
				'url' => '#',
				'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
				'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
				'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('asesor'),
				'items' => [

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Data Dapur',
						'url' => ['dapur/index'],
						'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('asesor'),
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Pemetaan Dapur',
						'url' => ['/asrama/dapur'],
						'visible' => Yii::$app->user->can('operatorCabang'),

					],
				]
			];
		}




		$menuItems[] = [
			'label' => '<i class="menu-icon fa fa-book"></i><span class="menu-text"> Laporan </span><i class="caret"></i>', 'url' => '#',
			'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
			'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
			'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('operatorCabang'),
			'items' => [
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Rincian Pelanggaran',
					'url' => ['/laporan/rincian-pelanggaran'],


				],
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Rekap Pelanggaran Per Semester',
					'url' => ['/laporan/rekap-semester'],


				],
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Rekap Pelanggaran Per Fakultas',
					'url' => ['/laporan/rekap-fakultas'],


				],
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Rekap Pelanggaran Per Prodi',
					'url' => ['/laporan/rekap-prodi'],


				],
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Rekap Pelanggaran Per Asrama',
					'url' => ['/laporan/rekap-asrama'],


				],
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Rekap Pelanggaran Per Kategori',
					'url' => ['/laporan/rekap-kategori'],


				],
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Rekap Penghuni Per Asrama',
					'url' => ['/laporan/rekap-penghuni-asrama'],


				],
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Rekap Perizinan',
					'url' => ['/laporan/rekap-perizinan'],


				],

			]
		];


		// display Users to admin+ roles
		if (Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('event') || Yii::$app->user->can('akpam') || Yii::$app->user->can('operatorUnit')) {

			$menuItems[] = [
				'label' => '<i class="menu-icon fa fa-book"></i><span class="menu-text"> Master </span><i class="caret"></i>', 'url' => '#',
				'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
				'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
				'items' => [

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Event <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('event') || Yii::$app->user->can('akpam') || Yii::$app->user->can('operatorUnit'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [

							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Manage'), 'url' => ['events/index']],
							[
								'label' => ('<i class="menu-icon fa fa-caret-right"></i>Tambah'),
								'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('event') || Yii::$app->user->can('akpam') || Yii::$app->user->can('operatorUnit'),
								'url' => ['events/create']
							]
						],
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Venue <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('akpam'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [

							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Manage'), 'url' => ['venue/index']],
							[
								'label' => ('<i class="menu-icon fa fa-caret-right"></i>Tambah'),
								'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('event') || Yii::$app->user->can('operatorUnit'),
								'url' => ['venue/create']
							]
						],
					],
					[
						'label' => '<hr style="padding:0px;margin:0px">'
					],

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Kategori Harian<b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('event'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [

							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Manage'), 'url' => ['simak-kegiatan-harian-kategori/index']],
							[
								'label' => ('<i class="menu-icon fa fa-caret-right"></i>Tambah'),
								'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('event'),
								'url' => ['simak-kegiatan-harian-kategori/create']
							]
						],
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Harian <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('event') || Yii::$app->user->can('akpam'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [

							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Manage'), 'url' => ['simak-kegiatan-harian/index']],
							[
								'label' => ('<i class="menu-icon fa fa-caret-right"></i>Tambah'),
								'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('event') || Yii::$app->user->can('akpam'),
								'url' => ['simak-kegiatan-harian/create']
							]
						],
					],
					[
						'label' => '<hr style="padding:0px;margin:0px">'
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Koordinator Kampus </b>',
						'visible' => Yii::$app->user->can('admin'),
						'url' => ['simak-kampus-koordinator/index'],
						
					],
					[
						'label' => '<hr style="padding:0px;margin:0px">'
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Layanan Surat </b>',
						'visible' => Yii::$app->user->can('admin'),
						'url' => ['simak-layanan-surat-setting/update'],
						
					],
					[
						'label' => '<hr style="padding:0px;margin:0px">'
					],

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Kategori Pelanggaran <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('admin'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [

							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Manage'), 'url' => ['kategori-pelanggaran/index']],
							[
								'label' => ('<i class="menu-icon fa fa-caret-right"></i>Tambah'),
								'visible' => Yii::$app->user->can('admin'),
								'url' => ['kategori-pelanggaran/create']
							]
						],
					],

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Pelanggaran <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('operatorCabang'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [

							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Manage'), 'url' => ['pelanggaran/index']],
							[
								'label' => ('<i class="menu-icon fa fa-caret-right"></i>Tambah'),
								'visible' => Yii::$app->user->can('operatorCabang'),
								'url' => ['pelanggaran/create']
							]
						],
					],

					[
						'label' => '<hr style="padding:0px;margin:0px">'
					],

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Kategori Hukuman <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('admin'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [

							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Manage'), 'url' => ['kategori-hukuman/index']],
							[
								'label' => ('<i class="menu-icon fa fa-caret-right"></i>Tambah'),
								'visible' => Yii::$app->user->can('admin'),
								'url' => ['kategori-hukuman/create']
							]
						],
					],


					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Hukuman <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('operatorCabang'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [

							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Manage'), 'url' => ['hukuman/index']],
							[
								'label' => ('<i class="menu-icon fa fa-caret-right"></i>Tambah'),
								'visible' => Yii::$app->user->can('operatorCabang'),
								'url' => ['hukuman/create']
							]
						],
					],
					[
						'label' => '<hr style="padding:0px;margin:0px">'
					],



					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>UKM <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('akpam') || Yii::$app->user->can('operatorUnit'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [

							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Manage'), 'url' => ['organisasi/index']],
							[
								'label' => ('<i class="menu-icon fa fa-caret-right"></i>Tambah'),
								'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('akpam') || Yii::$app->user->can('operatorUnit'),
								'url' => ['organisasi/create']
							],
							[
								'label' => '<i class="menu-icon fa fa-caret-right"></i> Sync',
								'url' => ['organisasi/sync'],
								'visible' => Yii::$app->user->can('admin'),
							],
						],
					],

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Jabatan Organisasi <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('admin'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [

							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Manage'), 'url' => ['organisasi-jabatan/index']],
							[
								'label' => ('<i class="menu-icon fa fa-caret-right"></i>Tambah'),
								'visible' => Yii::$app->user->can('admin'),
								'url' => ['organisasi-jabatan/create']
							]
						],
					],

					[
						'label' => '<hr style="padding:0px;margin:0px">'
					],

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Asrama <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('operatorCabang'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [

							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Manage'), 'url' => ['asrama/index']],
							[
								'label' => ('<i class="menu-icon fa fa-caret-right"></i>Tambah'),
								'visible' => Yii::$app->user->can('operatorCabang'),
								'url' => ['asrama/create']
							]
						],
					],
					
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Dapur <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('operatorCabang'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [

							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Manage'), 'url' => ['dapur/index']],
							[
								'label' => ('<i class="menu-icon fa fa-caret-right"></i>Tambah'),
								'visible' => Yii::$app->user->can('operatorCabang'),
								'url' => ['dapur/create']
							]
						],
					],

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Kamar <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('operatorCabang'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [

							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Manage'), 'url' => ['kamar/index']],
							[
								'label' => ('<i class="menu-icon fa fa-caret-right"></i>Tambah'),
								'visible' => Yii::$app->user->can('operatorCabang'),
								'url' => ['kamar/create']
							]
						],
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Mahasiswa <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('operatorCabang'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [

							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Manage'), 'url' => ['mahasiswa/index']],
						],
					],

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Wilayah <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('admin'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [
							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Negara'), 'url' => ['apps-countries-detailed/index']],
							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Provinsi'), 'url' => ['simak-propinsi/index']],
							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Kota/Kabupaten'), 'url' => ['simak-kabupaten/index']],
						],
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Global <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('admin'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [
							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Countries'), 'url' => ['countries/index']],
							['label' => ('<i class="menu-icon fa fa-caret-right"></i>States'), 'url' => ['states/index']],
							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Cities'), 'url' => ['cities/index']],
						],
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i>Syarat AKPAM <b class="arrow fa fa-angle-down"></b>',
						'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
						'visible' => Yii::$app->user->can('admin'),
						'url' => ['#'],
						'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
						'items' => [
							
							['label' => ('<i class="menu-icon fa fa-caret-right"></i>Manage'), 'url' => ['simak-syarat-bebas-asrama/index']],
							[
								'label' => ('<i class="menu-icon fa fa-caret-right"></i>Tambah'),
								'visible' => Yii::$app->user->can('operatorCabang'),
								'url' => ['simak-syarat-bebas-asrama/create']
							]
						],
					],
				]
			];
		}

		if (Yii::$app->user->can('theCreator')) {


			$menuItems[] = ['label' => '<i class="menu-icon fa fa-users"></i><span class="menu-text"> Users </span>', 'url' => ['/user/index']];

			$menuItems[] = ['label' => '<i class="menu-icon fa fa-cog"></i><span class="menu-text"> Prodi </span>', 'url' => ['/user-prodi/index']];
		}
		$menuItems[] = [
			'label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Auth </span><i class="caret"></i>',
			'url' => '#',
			'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
			'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
			'visible' => Yii::$app->user->can('theCreator'),
			'items' => [

				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Auth Item',
					'url' => ['/auth-item/index'],
					'visible' => Yii::$app->user->can('theCreator'),
				],
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Auth Item Child',
					'url' => ['/auth-item-child/index'],
					'visible' => Yii::$app->user->can('theCreator'),

				],
			]
		];

		if (Yii::$app->user->isGuest) {
			$menuItems[] = [
				'label' => '<i class="menu-icon fa fa-key"></i><span class="menu-text"> Login </span>',
				'url' => ['site/login']
			];
		}

		return $menuItems;
	}
}
