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
                         $session = Yii::$app->session;

                        if($session->has('access_token') && $session->has('refresh_token')){
                          $access_token = $session->get('access_token');
                          $refresh_token = $session->get('refresh_token');
                          try{
                            $res = Yii::$app->aplikasi->getAllowedAplikasi($access_token, $refresh_token);
                            $list_apps = $res['apps'];  
                          }catch(\Exception $e){

                          }

                          


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
                                            <a target="_blank" href="<?=$app['app_url'];?>" class="clearfix">
                                               <?=$app['app_name'];?>
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
                                <?php
                                    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                                      echo '<div class="flash alert alert-' . $key . '">' . $message . '<button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button></div>';
                                    }

                                ?>
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
                              2024-<?=date('Y');?>
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
