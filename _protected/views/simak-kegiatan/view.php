<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SimakKegiatan */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simak Kegiatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="block-header">
    <h2><?= Html::encode($this->title) ?></h2>
</div>
<div class="row">
   <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>

            <div class="panel-body ">
        
<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama_kegiatan',
            'sub_kegiatan',
            'nilai',
            'sk_unida_siman',
            'sk_unida_cabang',
            'id_jenis_kegiatan',
            'is_active',
            'created_at',
            'updated_at',
        ],
    ]) ?>

            </div>
        </div>

    </div>
</div>