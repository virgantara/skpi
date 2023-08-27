<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMbkm $model */

$this->title = 'Create Simkatmawa MBKM';
$this->params['breadcrumbs'][] = ['label' => 'Simkatmawa MBKM', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => ucwords(str_replace('-', ' ', $form)), 'url' => [$form]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simkatmawa-mbkm-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    switch ($form) {
        case 'pertukaran-pelajar':
            echo $this->render('pertukaran_pelajar_form', [
                'model' => $model,
                'function' => 'create'
            ]);
            break;

        case 'mengajar-di-sekolah':
            echo $this->render('mengajar_di_sekolah_form', [
                'model' => $model,
                'function' => 'create'
            ]);
            break;

        case 'penelitian':
            echo $this->render('penelitian_form', [
                'model' => $model,
                'function' => 'create'
            ]);
            break;
        case 'proyek-kemanusiaan':
            echo $this->render('proyek_kemanusiaan_form', [
                'model' => $model,
                'function' => 'create'
            ]);
            break;
        case 'proyek-desa':
            echo $this->render('proyek_desa_form', [
                'model' => $model,
                'function' => 'create'
            ]);
            break;
        case 'wirausaha':
            echo $this->render('wirausaha_form', [
                'model' => $model,
                'function' => 'create'
            ]);
            break;
        case 'studi':
            echo $this->render('studi_form', [
                'model' => $model,
                'function' => 'create'
            ]);
            break;
        case 'pengabdian-masyarakat':
            echo $this->render('pengabdian_masyarakat_form', [
                'model' => $model,
                'function' => 'create'
            ]);
            break;


        default:
            # code...
            break;
    }

    ?>

</div>