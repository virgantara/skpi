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

    	$userRole = Yii::$app->user->identity->access_role;
        $menuItems = [];
		if(!Yii::$app->user->isGuest){

		     $menuItems[] = [
		        'label' => '<i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> Beranda </span>', 
		        'url' => ['site/index']];
		}


	    if (Yii::$app->user->can('operatorCabang'))
	    {
	        
	        $menuItems[] = ['label' => '<i class="menu-icon fa fa-book"></i><span class="menu-text"> Pelanggaran </span><i class="caret"></i>', 'url' => '#',
		         'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
		         'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
		        'items'=>[
		           	[
		            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Daftar Pelanggaran',  
		                'url' => ['/riwayat-pelanggaran/index'],	        
		                'visible' => Yii::$app->user->can('operatorCabang'),
		               
		            ],
		            [
		            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Input Pelanggaran',  
		                'url' => ['/riwayat-pelanggaran/cari-mahasiswa'],	        
		                'visible' => Yii::$app->user->can('operatorCabang'), 
		            ],
		        ]
		    ];

		    $menuItems[] = ['label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Events </span><i class="caret"></i>', 
		         'url' => '#',
		         'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
		         'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
		        'items'=>[
		           	
		            [
		            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Today\'s Event',  
		                'url' => ['events/daily','daily'=>'today'],	        
		                'visible' => Yii::$app->user->can('operatorCabang'), 
		            ],
		            [
		            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Upcoming Events',  
		                'url' => ['events/daily','daily'=>'upcoming'],	             
		                'visible' => Yii::$app->user->can('operatorCabang'),
		            ],
		            [
		            	'label' => '<hr style="padding:0px;margin:0px">'
		            ],
		            [
		            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Previous Events',  
		                'url' => ['events/daily','daily'=>'previous'],	        
		                'visible' => Yii::$app->user->can('operatorCabang'),
		            ],
		        ]
		    ];
	    }


	        

	    if (Yii::$app->user->can('operatorCabang')||Yii::$app->user->can('asesor'))
	    {
         	$menuItems[] = ['label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Asrama </span><i class="caret"></i>', 
		         'url' => '#',
		         'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
		         'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
		        'items'=>[
		           	
		            [
		            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Data Penghuni Asrama',  
		                'url' => ['asrama/mahasiswa'],	        
		                'visible' => Yii::$app->user->can('operatorCabang')||Yii::$app->user->can('asesor'), 
		            ],
		            [
		            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Pindah Kamar',  
		                'url' => ['/asrama/pindah'],	        
		                'visible' => Yii::$app->user->can('operatorCabang'),
		               
		            ],
		        ]
		    ];

		    $menuItems[] = ['label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Organisasi </span><i class="caret"></i>', 
		         'url' => '#',
		         'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
		         'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
		        'items'=>[
		           	
		            [
		            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Manage',  
		                'url' => ['organisasi-mahasiswa/index'],	        
		                'visible' => Yii::$app->user->can('operatorCabang')||Yii::$app->user->can('asesor'), 
		            ],
		            [
		            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Tambah',  
		                'url' => ['organisasi-mahasiswa/create'],	        
		                'visible' => Yii::$app->user->can('operatorCabang'),
		               
		            ],
		        ]
		    ];

		    

		    $menuItems[] = ['label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Konsulat </span><i class="caret"></i>', 
		         'url' => '#',
		         'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
		         'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
		        'items'=>[
		           	
		            [
		            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Pemetaan',  
		                'url' => ['mahasiswa/konsulat'],	        
		                'visible' => Yii::$app->user->can('operatorCabang'), 
		            ],
		            [
		            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Rekap',  
		                'url' => ['/mahasiswa/konsulat-rekap'],	        
		                'visible' => Yii::$app->user->can('operatorCabang')||Yii::$app->user->can('asesor'),
		               
		            ],
		        ]
		    ];

		    
		    $menuItems[] = ['label' => '<i class="menu-icon fa fa-home"></i><span class="menu-text"> Dapur </span><i class="caret"></i>', 
		         'url' => '#',
		         'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
		         'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
		        'items'=>[
		           	
		            [
		            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Data Dapur',  
		                'url' => ['dapur/index'],	        
		                'visible' => Yii::$app->user->can('operatorCabang')||Yii::$app->user->can('asesor'), 
		            ],
		            [
		            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Pemetaan Dapur',  
		                'url' => ['/asrama/dapur'],	        
		                'visible' => Yii::$app->user->can('operatorCabang'),
		               
		            ],
		        ]
		    ];

		}


		$menuItems[] = ['label' => '<i class="menu-icon fa fa-book"></i><span class="menu-text"> Perizinan </span><i class="caret"></i>', 'url' => '#',
	         'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	         'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	        'items'=>[
	        	[
	            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Hari ini',  
	                'url' => ['/izin-harian/today'],	        
	                'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('kaprodi') || Yii::$app->user->can('kepalaBAAK')||Yii::$app->user->can('stafBAPAK')||Yii::$app->user->can('asesor'),
	               
	            ],
	            [
	            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Riwayat Izin Harian',  
	                'url' => ['/izin-harian/index'],	        
	                'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('kaprodi') || Yii::$app->user->can('kepalaBAAK')||Yii::$app->user->can('stafBAPAK')||Yii::$app->user->can('asesor'),
	               
	            ],
	           	[
	            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Daftar Perizinan',  
	                'url' => ['/izin-mahasiswa/index'],	        
	                'visible' => Yii::$app->user->can('operatorCabang') || Yii::$app->user->can('kaprodi') || Yii::$app->user->can('kepalaBAAK')||Yii::$app->user->can('stafBAPAK')||Yii::$app->user->can('asesor'),
	               
	            ],
	            [
	            	'label' => '<i class="menu-icon fa fa-caret-right"></i> Input Perizinan',  
	                'url' => ['/izin-mahasiswa/create'],	        
	                'visible' => Yii::$app->user->can('operatorCabang')||Yii::$app->user->can('stafBAPAK'), 
	            ],
	        ]];

	        $menuItems[] = ['label' => '<i class="menu-icon fa fa-book"></i><span class="menu-text"> Laporan </span><i class="caret"></i>', 'url' => '#',
	         'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	         'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	         'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('operatorCabang'),
	        'items'=>[
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
	            
	        ]];
	    

	    // display Users to admin+ roles
	    if (Yii::$app->user->can('operatorCabang')){

	        $menuItems[] = ['label' =>'<i class="menu-icon fa fa-book"></i><span class="menu-text"> Master </span><i class="caret"></i>', 'url' => '#',
	         'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	         'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	        'items'=>[

	            [
	                'label' => '<i class="menu-icon fa fa-caret-right"></i>Event <b class="arrow fa fa-angle-down"></b>',  
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admin'),
	                'url' => ['#'],
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [

	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['events/index']],
	                     [
	                        'label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),
	                        'visible' => Yii::$app->user->can('admin'),
	                        'url' => ['events/create']]
	                ],
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

	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['kategori-pelanggaran/index']],
	                     [
	                        'label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),
	                        'visible' => Yii::$app->user->can('admin'),
	                        'url' => ['kategori-pelanggaran/create']]
	                ],
	            ],

	            [
	                'label' => '<i class="menu-icon fa fa-caret-right"></i>Pelanggaran <b class="arrow fa fa-angle-down"></b>',  
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('operatorCabang'),
	                'url' => ['#'],
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [

	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['pelanggaran/index']],
	                     [
	                        'label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),
	                        'visible' => Yii::$app->user->can('operatorCabang'),
	                        'url' => ['pelanggaran/create']]
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

	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['kategori-hukuman/index']],
	                     [
	                        'label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),
	                        'visible' => Yii::$app->user->can('admin'),
	                        'url' => ['kategori-hukuman/create']]
	                ],
	            ],

	            
	            [
	                'label' => '<i class="menu-icon fa fa-caret-right"></i>Hukuman <b class="arrow fa fa-angle-down"></b>',  
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('operatorCabang'),
	                'url' => ['#'],
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [

	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['hukuman/index']],
	                     [
	                        'label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),
	                        'visible' => Yii::$app->user->can('operatorCabang'),
	                        'url' => ['hukuman/create']]
	                ],
	            ],
	           	 [
	            	'label' => '<hr style="padding:0px;margin:0px">'
	            ],



	            [
	                'label' => '<i class="menu-icon fa fa-caret-right"></i>Organisasi <b class="arrow fa fa-angle-down"></b>',  
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admin'),
	                'url' => ['#'],
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [

	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['organisasi/index']],
	                     [
	                        'label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),
	                        'visible' => Yii::$app->user->can('admin'),
	                        'url' => ['organisasi/create']]
	                ],
	            ],

	            [
	                'label' => '<i class="menu-icon fa fa-caret-right"></i>Jabatan Organisasi <b class="arrow fa fa-angle-down"></b>',  
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admin'),
	                'url' => ['#'],
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [

	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['organisasi-jabatan/index']],
	                     [
	                        'label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),
	                        'visible' => Yii::$app->user->can('admin'),
	                        'url' => ['organisasi-jabatan/create']]
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

	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['asrama/index']],
	                     [
	                        'label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),
	                        'visible' => Yii::$app->user->can('operatorCabang'),
	                        'url' => ['asrama/create']]
	                ],
	            ],
	           	[
	                'label' => '<i class="menu-icon fa fa-caret-right"></i>Dapur <b class="arrow fa fa-angle-down"></b>',  
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('operatorCabang'),
	                'url' => ['#'],
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [

	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['dapur/index']],
	                     [
	                        'label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),
	                        'visible' => Yii::$app->user->can('operatorCabang'),
	                        'url' => ['dapur/create']]
	                ],
	            ],
	           
	           	[
	                'label' => '<i class="menu-icon fa fa-caret-right"></i>Kamar <b class="arrow fa fa-angle-down"></b>',  
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('operatorCabang'),
	                'url' => ['#'],
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [

	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['kamar/index']],
	                     [
	                        'label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),
	                        'visible' => Yii::$app->user->can('operatorCabang'),
	                        'url' => ['kamar/create']]
	                ],
	            ],
	            [
	                'label' => '<i class="menu-icon fa fa-caret-right"></i>Mahasiswa <b class="arrow fa fa-angle-down"></b>',  
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('operatorCabang'),
	                'url' => ['#'],
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [

	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['mahasiswa/index']],
	                ],
	            ],

	            [
	                'label' => '<i class="menu-icon fa fa-caret-right"></i>Wilayah <b class="arrow fa fa-angle-down"></b>',  
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admin'),
	                'url' => ['#'],
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [
	                	['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Negara'),'url' => ['apps-countries-detailed/index']],
	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Provinsi'),'url' => ['simak-propinsi/index']],
	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Kota/Kabupaten'),'url' => ['simak-kabupaten/index']],
	                ],
	            ],
	           	[
	                'label' => '<i class="menu-icon fa fa-caret-right"></i>Global <b class="arrow fa fa-angle-down"></b>',  
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admin'),
	                'url' => ['#'],
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [
	                	['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Countries'),'url' => ['countries/index']],
	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>States'),'url' => ['states/index']],
	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Cities'),'url' => ['cities/index']],
	                ],
	            ],
	            
	        ]];

	       
	    }

	    if (Yii::$app->user->can('theCreator')){


	        $menuItems[] = ['label' => '<i class="menu-icon fa fa-users"></i><span class="menu-text"> Users </span>', 'url' => ['/user/index']];
	    }


		return $menuItems;
    }
}