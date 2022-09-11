<?php
/* @var $this \yii\web\View */
/* @var $content string */
use app\widgets\Alert;
use app\assets\AppAsset;
use app\assets\SweetalertAsset;
use app\widgets\Alet;
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use kartik\nav\NavX;
use yii\helpers\Url;

AppAsset::register($this);
SweetalertAsset::register($this);

$theme = $this->theme;

$themeUrl = $this->theme->baseUrl."/new_leaflet";
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="icon" type="image/png" sizes="96x96" href="<?=Yii::$app->view->theme->baseUrl;?>/images/favicon.ico">
    <?= Html::csrfMetaTags() ?>
    <link rel="stylesheet" href="<?=$themeUrl;?>/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="<?=$themeUrl;?>/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    <!-- Load Esri Leaflet from CDN -->
    <script src="<?=$themeUrl;?>/esri-leaflet.js"></script>
    
    <!-- <script src="https://unpkg.com/esri-leaflet@3.0.2/dist/esri-leaflet.js" integrity="sha512-myckXhaJsP7Q7MZva03Tfme/MSF5a6HC2xryjAM4FxPLHGqlh5VALCbywHnzs2uPoF/4G/QVXyYDDSkp5nPfig==" crossorigin=""></script> -->

    <!-- Load Esri Leaflet Geocoder from CDN -->
    <link rel="stylesheet" href="<?=$themeUrl;?>/esri-leaflet-geocoder.css">
    <script src="<?=$themeUrl;?>/esri-leaflet-geocoder.js"></script>
    <script src="<?=$themeUrl;?>/indonesia-geojson.js"></script>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head(); ?>

<style type="text/css">
    .swal2-popup {
      font-size: 1.6rem !important;
    }

    .ui-state-focus {
        background: none !important;
        background-color: #5090C1 !important;
        border: none !important;
    } 
</style>
</head>

<body class="no-skin">
     <div id="navbar" style="background-color:#fff" class="navbar navbar-default    navbar-collapse       h-navbar ace-save-state">
            <div class="navbar-container ace-save-state" id="navbar-container">
                <div class="navbar-header pull-left">
                    <a href="<?=Url::to('/site/index');?>" class="navbar-brand" style="color:#777">
                        <small>
                            <img width="25px" src="<?=$theme->getPath('images/logo_small.png');?>" alt="Logo SIKAP" />
                            <?= Yii::$app->name ?>
                        </small>
                    </a>

                    <button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
                        <span class="sr-only">Toggle user menu</span>

                        <img src="<?=$theme->getPath('images/avatars/avatar2.png');?>" alt="Jason's Photo" />
                    </button>

                    <button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
                        <span class="sr-only">Toggle sidebar</span>

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>
                    </button>
                </div>
<?php 
if(!Yii::$app->user->isGuest){
?>
                <div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
                    <ul class="nav ace-nav">

                        <?php 
                        $list_apps = [];
                        try
                        {
                            $key = Yii::$app->params['jwt_key'];
                            $session = Yii::$app->session;
                            $token = $session->get('token');
                            $decoded = \Firebase\JWT\JWT::decode($token, base64_decode(strtr($key, '-_', '+/')), ['HS256']);
                            $list_apps = $decoded->apps;
                        }
                        catch(\Exception $e) 
                        {
                       
                        }
                    

                        
                        ?>

                          <li class="blue dropdown-modal">
                           <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="ace-icon fa fa-cloud icon-animated-vertical"></i>
                                <span class="badge badge-success"><?=count($list_apps);?></span>
                            </a>

                            <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                                <li class="dropdown-header">
                                    <i class="ace-icon fa fa-cloud"></i>
                                    <?=count($list_apps);?> Apps
                                </li>
                                <?php 
                                foreach($list_apps as $app)
                                {
                                ?>
                                <li class="dropdown-content">
                                    <ul class="dropdown-menu dropdown-navbar">
                                        <li>
                                            <a href="<?=$app->app_url.$token;?>" class="clearfix">
                                               <!--  <img src="assets/images/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar" /> -->
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue"><?=$app->app_name;?></span>
                                                    </span>

                                                    <!-- <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>a moment ago</span>
                                                    </span> -->
                                                </span>
                                            </a>
                                        </li>

                                    </ul>
                                </li>   
                                <?php 
                                }
                                ?>

                                
                            </ul>
                            
                        </li>

                        <li class="light-blue dropdown-modal user-min">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                <img class="nav-user-photo" src="<?=$theme->getPath('images/avatars/avatar2.png');?>"/>
                                <span class="user-info">
                                    <small>Welcome,</small>
                                   <?=Yii::$app->user->identity->username;?>
                                </span>

                                <i class="ace-icon fa fa-caret-down"></i>
                            </a>
                            <?php



                            echo Menu::widget([
                                'options'=>['class'=>'user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close'],
                                // 'itemOptions'=>array('class'=>'dropdown-menu'),
                                // 'itemCssClass'=>'item-test',
                                'encodeLabels'=>false,
                                'items' => [
                                    ['label'=>'<i class="ace-icon fa fa-user"></i>Profil', 'url'=>['/pegawai/view','id'=>'']],
                                    ['label'=> '','itemOptions'=>['class'=>'divider']],
                                    ['label'=>'Pengguna', 'url'=>['/user/index']],
                                    ['label'=> '','itemOptions'=>['class'=>'divider']],
                                    ['label'=>'<a data-method="POST" href="'.Url::to(['/site/logout']).'">Logout</a>'],

                                ],
                            ]);

 ?>
                        
                        </li>
                    </ul>
                </div>
<?php 
}
?>
            </div><!-- /.navbar-container -->
        </div>

        <div class="main-container ace-save-state" id="main-container">
            <script type="text/javascript">
                try{ace.settings.loadState('main-container')}catch(e){}
            </script>

          <div id="sidebar" class="sidebar      h-sidebar                navbar-collapse collapse          ace-save-state">
                <script type="text/javascript">
                    try{ace.settings.loadState('sidebar')}catch(e){}
                </script>
               
 
                  <?php 
    
    $menuItems = \app\helpers\MenuHelper::getMenuItems();              

       echo Menu::widget([
        'options'=>array('class'=>'nav nav-list'),
        'itemOptions'=>array('class'=>'hover'),
        
        // 'itemCssClass'=>'hover',
        'encodeLabels'=>false,
        'items' => $menuItems
    ]);

          
            ?>
            
            </div>
            <div class="main-content">
                <div class="main-content-inner">
                    <?php 
                    if(isset($this->params['breadcrumbs'])){
                    ?>
                    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                        <?php

                        echo Breadcrumbs::widget([
                            // 'options' => [
                            //     'class' => 'breadcrumb',
                            // ]
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]);

                         ?>
                       

                        
                    </div>
                    <?php 
                }
                    ?>
                    <div class="page-content">
                        

                     <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <div class="invisible">
                                    <button data-target="#sidebar2" type="button" class="pull-left menu-toggler navbar-toggle">
                                        <span class="sr-only">Toggle sidebar</span>

                                        <i class="ace-icon fa fa-dashboard white bigger-125"></i>
                                    </button>

                                   
                                </div>
                                <?=Alert::widget();?>
                                <?=$content;?>
                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

            <div class="footer">
                <div class="footer-inner">
                    <div class="footer-content">
                        <span class="bigger-120">
                            <span class="blue bolder"><?=Yii::$app->params['shortname'];?></span>
                              2017-<?=date('Y');?>
                        </span>

                        &nbsp; &nbsp;
                        <span class="action-buttons">
                            <a href="#">
                                <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-rss-square orange bigger-150"></i>
                            </a>
                        </span>
                    </div>
                </div>
            </div>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->
      
        <!-- <![endif]-->

        <!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
        
        
        <!-- page specific plugin scripts -->

        <!-- ace scripts -->
        
        <!-- inline scripts related to this page -->
        <?php $this->endBody() ?>
 

</body>

</html>
<?php $this->endPage() ?>
