<?php

use app\models\SimkatmawaMandiri;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMandiriSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Simkatmawa Mandiri';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-mandiri-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-xs-12">

            <div class="widget-box">
                <div class="widget-header widget-header-blue widget-header-flat">
                    <h4 class="widget-title lighter">New Item Wizard</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main">
                        <div id="fuelux-wizard-container">

                            <div class="hr hr-18 hr-double dotted"></div>

                            <div class="step-content pos-rel">
                                <div class="step-pane active" data-step="1">
                                    <h3 class="lighter block green">Enter the following information</h3>

                                    <form class="form-horizontal" id="sample-form">
                                        <div class="form-group has-warning">
                                            <label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right">Input with warning</label>

                                            <div class="col-xs-12 col-sm-5">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="text" id="inputWarning" class="width-100" />
                                                    <i class="ace-icon fa fa-leaf"></i>
                                                </span>
                                            </div>
                                            <div class="help-block col-xs-12 col-sm-reset inline"> Warning tip help! </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>