<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMandiri $model */

$this->title = 'Create Simkatmawa Mandiri';
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa Mandiris', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-mandiri-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    switch ($id) {
        case 0:
            echo $this->render('_form_rekognisi', [
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