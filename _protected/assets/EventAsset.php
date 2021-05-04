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
class EventAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@themes';

    public $css = [
        'css/fullcalendar.min.css',
    ];

    public $js = [
    	'js/jquery.ui.touch-punch.min.js',
        'js/moment.min.js',
        'js/fullcalendar.min.js',
        'js/bootbox.js'

    ];

    public $depends = [
        'yii\web\YiiAsset',

    ];
}
