<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Organisasi */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Organisasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="organisasi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama',
            'tingkat',
            [
                // 'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'file_sk',
                 'format' => 'raw',
                'value' => function($data){
                    return (!empty($data->file_sk) ? Html::a('<i class="fa fa-download"></i> Unduh',$data->file_sk, ['class'=>'btn btn-primary','data-pjax' => 0,'target' => '_blank']) : null);
                },
                
            ],
            'instansi',
        ],
    ]) ?>

</div>
