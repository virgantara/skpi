<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SimakMagangCatatan $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Simak Magang Catatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="simak-magang-catatan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tanggal',
            'rincian_kegiatan:html',
            'evaluasi:html',
            'tindak_lanjut:html',
            'catatan_pembimbing:html',
            'updated_at',
            'created_at',
        ],
    ]) ?>

</div>
