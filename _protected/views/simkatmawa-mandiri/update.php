<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMandiri $model */

$this->title = 'Update Simkatmawa Mandiri: ' . $model->nama_kegiatan;
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Mandiri', 'url' => [$form]];
$this->params['breadcrumbs'][] = ['label' => ucwords(str_replace('-', ' ', $form)), 'url' => [$form]];
$this->params['breadcrumbs'][] = ['label' => $model->nama_kegiatan, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simkatmawa-mandiri-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    switch ($form) {
        case 'rekognisi':
            echo $this->render('rekognisi_form', [
                'model' => $model,
                'function' => 'update'
            ]);
            break;

        case 'kegiatan-mandiri':
            echo $this->render('kegiatan_mandiri_form', [
                'model' => $model,
                'function' => 'update'
            ]);
            break;

        default:
            # code...
            break;
    }

    ?>

</div>