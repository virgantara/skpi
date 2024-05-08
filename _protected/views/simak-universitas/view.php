<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SimakUniversitas $model */

$this->title = 'Data Universitas';
$this->params['breadcrumbs'][] = ['label' => 'Simak Universitas','url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="simak-universitas-view">

    <h1><?= Html::encode($this->title) ?></h1>

     <p>
        <?= Html::a('Update', ['update'], ['class' => 'btn btn-primary']) ?>
        
    </p>
    
    <table class="table table-striped">
            <tr>
                <td colspan="3"><h3>Informasi Terkait SKPI</h3></td>
            </tr>
            <tr>
                <th width="30%">Deskripsi<br><i>Description</i></th>
                <td><?=$model->deskripsi_skpi?></td>
                <td><?=$model->deskripsi_skpi_en?></td>
            </tr>
            <tr>
                <td colspan="3"><h3>Informasi Terkait Universitas</h3></td>
            </tr>
            <tr>
                <th>Nama Perguruan Tinggi<br><i>Awarding Institution</i></th>
                <td><?= $model->nama_institusi ?></td>
                <td><?= $model->nama_institusi_en ?></td>
            </tr>
            <tr>
                <th>SK Pendirian Perguruan Tinggi<br><i>Awarding Institution's License</i></th>
                <td><?= $model->sk_pendirian ?></td>
                <td></td>
            </tr>
            <tr>
                <th>Peringkat Akreditasi<br><i>Accreditation Ranking</i></th>
                <td><?= $model->peringkat_akreditasi ?></td>
                <td></td>
            </tr>
            <tr>
                <th>Nomor Sertifikat Akreditasi<br><i>Accreditation Decree Number</i></th>
                <td><?= $model->nomor_sertifikat_akreditasi ?></td>
                <td></td>
            </tr>
            <tr>
                <th>Lembaga Akreditasi<br><i>Accreditation Organization</i></th>
                <td><?= $model->lembaga_akreditasi ?></td>
                <td></td>
            </tr>
            <tr>
                <th>Persyaratan Penerimaan<br><i>Entry Requirements</i></th>
                <td><?=$model->persyaratan_penerimaan?></td>
                <td><?=$model->persyaratan_penerimaan_en?></td>
            </tr>
            <tr>
                <th>Sistem Penilaian<br><i>Grading System</i></th>
                <td><?=$model->sistem_penilaian?></td>
                <td><?=$model->sistem_penilaian_en?></td>
            </tr>
            <tr>
                <td colspan="3"><h3>Informasi Terkait Kontak</h3></td>
            </tr>
            <tr>
                <th>Alamat<br><i>Address</i></th>
                <td><?= $model->alamat ?></td>
                <td></td>
            </tr>
            <tr>
                <th>Telepon<br><i>Telephone</i></th>
                <td><?= $model->telepon ?></td>
                <td></td>
            </tr>
            <tr>
                <th>Fax<br><i>Fax</i></th>
                <td><?= $model->fax ?></td>
                <td></td>
            </tr>
            <tr>
                <th>Website<br><i>Website</i></th>
                <td><?= $model->website ?></td>
                <td></td>
            </tr>
            <tr>
                <th>Email<br><i>Email</i></th>
                <td><?= $model->email ?></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"><h3>Informasi Terkait Catatan Resmi</h3></td>
            </tr>
            <tr>
                <th>Deskripsi<br><i>Description</i></th>
                <td><?=$model->catatan_resmi?></td>
                <td><?=$model->catatan_resmi_en?></td>
            </tr>
        </table>

</div>
