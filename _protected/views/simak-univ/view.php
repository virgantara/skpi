<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SimakUniv $model */

$this->title = $model->header;
$this->params['breadcrumbs'][] = ['label' => 'KKNI', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="simak-univ-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php 
    if(!Yii::$app->user->isGuest){


     ?>
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
<?php } ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'header',
            'header_en',
            
            'nama:html',
            'nama_en:html',
            'urutan',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
