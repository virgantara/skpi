<?php

use app\models\SimkatmawaMahasiswa;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMandiri $model */

\yii\web\YiiAsset::register($this);
$dataMahasiswa = SimkatmawaMahasiswa::findAll(['simkatmawa_mbkm_id' => $model->id]);
?>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="center">#</th>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($dataMahasiswa as $mhs) : ?>
            <tr>
                <td class="center"><?= $no ?></td>
                <td><?= $mhs->nim ?></td>
                <td><?= $mhs->nim0->nama_mahasiswa ?></td>
            </tr>
        <?php
            $no++;
        endforeach; ?>
    </tbody>
</table>