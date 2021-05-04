<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use Yii;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Nenad Zivkovic <nenad@freetuts.org>
 * 
 * @since 2.0
 */
class DatatableAsset extends AssetBundle
{
	public $basePath = '@webroot';
    public $baseUrl = '@themes';

    public $css = [
      
    ];

    public $js = [
    	'js/jquery.dataTables.min.js',
        'js/jquery.dataTables.bootstrap.min.js',
        'js/dataTables.buttons.min.js',
        'js/buttons.flash.min.js',
        'js/buttons.html5.min.js',
        'js/buttons.print.min.js',
        'js/buttons.colVis.min.js',
        'js/dataTables.select.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',

    ];

}