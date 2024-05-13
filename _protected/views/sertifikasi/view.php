<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SimakSertifikasi */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simak Sertifikasis', 'url' => ['index']];
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
            'nim',
            'jenis_sertifikasi',
            'lembaga_sertifikasi',
            'nomor_registrasi_sertifikasi',
            'nomor_sk_sertifikasi',
            'tahun_sertifikasi',
            'tmt_sertifikasi',
            'tst_sertifikasi',
            'file_path',
            'status_validasi',
            'approved_by',
            'catatan:ntext',
            'updated_at',
            'created_at',
        ],
    ]) ?>

            </div>
        </div>

    </div>
</div>