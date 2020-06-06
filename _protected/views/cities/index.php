<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cities-index">

    <h1><?= Html::encode($this->title) ?></h1>


<?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'options' => [
                    'tag' => false,
                ],
            ],
            'method' => 'GET',
            'action' => Url::to(['cities/index']),
            'options' => [

                'id' =>'form-konsulat',
                'class' => 'form-horizontal'
            ]
        ]); ?>

<div class="row">
    <div class="col-xs-12">
        
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Countries</label>
        <div class="col-sm-9">
            <?= $form->field($searchModel,'country_id')->dropDownList(ArrayHelper::map(\app\models\Countries::find()->all(),'id','name'),['id'=>'negara','class'=>'','prompt'=>'- Choose a Country -'])->label(false);?>

            
            </div>
        </div> 
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">States</label>
        <div class="col-sm-9">
            
                <?= $form->field($searchModel,'state_id')->dropDownList([],['id'=>'states','prompt'=>'- Choose a state -','class'=>false])->label(false);?>
            
            </div>
        </div> 
        
        <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">

                <button class="btn btn-info" value="1" type="submit" name="btn-search">
                    <i class="ace-icon glyphicon glyphicon-search bigger-110"></i>
                    Tampilkan Kota
                </button>

            </div>
        </div>
       
       
    </div>
</div>
 <?php ActiveForm::end(); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i> Create Cities', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name',
            // [
            //     'attribute'=>'state_id',
                
            //     'value' => function ($data) {
            //         return $data->state->name;
            //     },
               
            // ],
            // // 'state_code',
            // [
            //     'attribute'=>'country_id',
            //     'filter' => \yii\helpers\ArrayHelper::map(\app\models\Countries::find()->all(),'id','name'),
            //     'value' => function ($data) {
            //         return $data->country->name;
            //     },
               
            // ],
            // 'country_id',
            //'country_code',
            'latitude',
            'longitude',
            //'created_at',
            //'updated_on',
            //'flag',
            'wikiDataId',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>


<?php

$this->registerJs(' 



function getStates(cid){
    $.ajax({

        type : "POST",
        url : "'.Url::to(['/states/states-list']).'",
        data : "cid="+cid,
        beforeSend : function(){
            $("#states").empty();
            var row = \'<option value="">Loading...</option>\';
            $("#states").append(row);
        },
        success: function(hasil){
            // var hasil = $.parseJSON(data);
            $("#states").empty();
            var row = \'<option value="">- Choose a state -</option>\';
            $.each(hasil,function(i,obj){
                row += \'<option value="\'+obj.id+\'">\'+obj.name+\'</option>\';
            });

            $("#states").append(row);

            $("#states").val("'.$states.'");
        }
    });
}


    $("#negara").change(function(){
        var cid = $(this).val();
        
        getStates(cid);
    });





', \yii\web\View::POS_READY);

?>