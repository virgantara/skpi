<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\PerusahaanSub */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Unit', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perusahaan-sub-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update-profile', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'nama',
            'namaPerusahaan',
            'visi',
            'misi',
            'sasaran',
            'tujuan',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    
</div>
