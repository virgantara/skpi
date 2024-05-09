<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\assets\HighchartAsset;
use app\helpers\MyHelper;
use app\models\SimakMasterprogramstudi;
use app\models\SimakTahunakademik;
use kartik\select2\Select2;

$this->title = Yii::t('app', Yii::$app->name);

HighchartAsset::register($this);

?>
<style type="text/css">
  .containerAsrama {
    height: 130px;
  }
</style>
