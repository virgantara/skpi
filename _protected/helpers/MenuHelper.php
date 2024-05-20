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

		if (
			Yii::$app->user->can('akpamPusat') ||
			Yii::$app->user->can('sekretearis') ||
			Yii::$app->user->can('fakultas')
		) {
			$menuItems[] = [
				'label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Universitas </span><i class="caret"></i>',
				'url' => '#',
				'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
				'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
				'items' => [

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Data Universitas',
						'url' =>  ['simak-universitas/view'],
					],
					
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> KKNI',
						'url' =>  ['simak-univ/index'],
					],

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Sistem Pendidikan',
						'url' =>  ['sistem-pendidikan/index'],
					],

				]
			];
		}

		if (
			Yii::$app->user->can('akpamPusat') ||
			Yii::$app->user->can('sekretearis') ||
			Yii::$app->user->can('fakultas')
		) {
			$menuItems[] = [
				'label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Program Studi </span><i class="caret"></i>',
				'url' => '#',
				'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
				'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
				'items' => [

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Data Program Studi',
						'url' =>  ['program-studi/index'],
					],
					
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Capaian Pembelajaran',
						'url' =>  ['capaian-pembelajaran-lulusan/index'],
					],

					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Pemohon SKPI',
						'url' =>  ['skpi-permohonan/index'],
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Program Tambahan',
						'url' =>  ['tambahan/index'],
						'visible' => Yii::$app->user->can('akpamPusat') || Yii::$app->user->can('fakultas')||Yii::$app->user->can('sekretearis')
					],

				]
			];
		}
		$menuItems[] = [
			'label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Mahasiswa </span><i class="caret"></i>',
			'url' => '#',
			'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
			'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
			'items' => [

				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Data Mahasiswa',
					'url' =>  ['mahasiswa/skpi'],
				],
				
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Data Prestasi',
					'url' =>  ['prestasi/index'],
				],

				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Data Sertifikasi',
					'url' =>  ['sertifikasi/index'],
				],
				[
					'label' => '<i class="menu-icon fa fa-caret-right"></i> Program Tambahan',
					'url' =>  ['mahasiswa/tambahan'],
					'visible' => Yii::$app->user->can('Mahasiswa')
				],

			]
		];
		// display Users to admin+ roles
		if (Yii::$app->user->can('theCreator')) {

			$menuItems[] = [
				'label' => '<i class="menu-icon fa fa-book"></i><span class="menu-text"> Master </span><i class="caret"></i>', 'url' => '#',
				'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
				'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
				'items' => [

					
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Jenjang Pendidikan',
						'url' =>  ['simkatmawa-belmawa/index'],
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Lembaga Akreditasi',
						'url' =>  ['simkatmawa-belmawa/index'],
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Level KKNI',
						'url' =>  ['simkatmawa-belmawa/index'],
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Persyaratan Penerimaan',
						'url' =>  ['simkatmawa-belmawa/index'],
					],
					[
						'label' => '<i class="menu-icon fa fa-caret-right"></i> Status Akreditasi',
						'url' =>  ['simkatmawa-belmawa/index'],
					],

					
				]
			];
		}

		// if (Yii::$app->user->can('theCreator')) {


		// 	$menuItems[] = ['label' => '<i class="menu-icon fa fa-users"></i><span class="menu-text"> Users </span>', 'url' => ['/user/index']];

			
		// }
		

		if (Yii::$app->user->isGuest) {
			$menuItems[] = [
				'label' => '<i class="menu-icon fa fa-key"></i><span class="menu-text"> Login </span>',
				'url' => ['site/login']
			];
		}

		return $menuItems;
	}
}
