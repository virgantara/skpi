<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMandiri $model */

$this->title = 'Create Simkatmawa Mandiri';
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Mandiri', 'url' => [$form]];
$this->params['breadcrumbs'][] = ['label' => ucwords(str_replace('-', ' ', $form)), 'url' => [$form]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-mandiri-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    switch ($form) {
        case 'rekognisi':
            echo $this->render('rekognisi_form', [
                'model' => $model,
            ]);
            break;

        case 'kegiatan-mandiri':
            echo $this->render('kegiatan_mandiri_form', [
                'model' => $model,
            ]);
            break;

        default:
            # code...
            break;
    }

    ?>

</div>