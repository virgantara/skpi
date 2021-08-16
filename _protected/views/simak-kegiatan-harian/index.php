<?php
use app\helpers\MyHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SimakKegiatanHarianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Simak Kegiatan Harians';
$this->params['breadcrumbs'][] = $this->title;

$list_hari = MyHelper::getHari();

$list_venue = ArrayHelper::map(\app\models\Venue::find()->all(),'kode','nama');

?>
<div class="simak-kegiatan-harian-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Simak Kegiatan Harian', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'kode',
            [
                'attribute' => 'kegiatan_id',
                'value' => function($data){

                    return !empty($data->kegiatan) ? $data->kegiatan->nama_kegiatan : 'Not found';
                }
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'kode_venue',
                'refreshGrid' => true,
                'filter' => $list_venue,
                'format' => 'raw',
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'asPopover' => false,
                    'data' => $list_venue
                ],
                'value' => function($data) use ($list_venue){
                    return $list_venue[$data->kode_venue];
                }
            ],
            
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'jam_mulai',
                'refreshGrid' => true,
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_TIME,
                    'asPopover' => false,
                ],
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'jam_selesai',
                'refreshGrid' => true,
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_TIME,
                    'asPopover' => false,
                ],
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'tahun_akademik',
                'refreshGrid' => true,
                'filter' => ArrayHelper::map($listTahun, 'tahun_id','nama_tahun'),
                'format' => 'raw',
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'asPopover' => false,
                    'data' => ArrayHelper::map($listTahun, 'tahun_id','nama_tahun')
                ],
              
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
