<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMandiri $model */

$this->title = 'Create Simkatmawa Mandiri';
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Mandiri', 'url' => [$form]];
$this->params['breadcrumbs'][] = ['label' => ucwords($form), 'url' => [$form]];
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

        case 1:
            echo $this->render('_form_kegiatan_mandiri', [
                'model' => $model,
            ]);
            break;

        default:
            # code...
            break;
    }

    ?>

</div>