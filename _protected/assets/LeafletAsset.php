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
class LeafletAsset extends AssetBundle
{
	public $basePath = '@webroot';
    public $baseUrl = '@themes';

    public $css = [
        'leaflet/leaflet.css',
    ];

    public $js = [
    	'leaflet/leaflet.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',

    ];

}