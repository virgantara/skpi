<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UserProdi $model */

$this->title = 'Create User Prodi';
$this->params['breadcrumbs'][] = ['label' => 'User Prodis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-prodi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
