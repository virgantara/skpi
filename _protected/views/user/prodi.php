<?php

use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <table class="table table-bordered table-hovered table-striped">
        <thead>
            <th>
                <?php
                foreach ($listUser as $user) {
                ?>
            <td><?= $user->username ?></td>
        <?php
                }
        ?>
        </th>
        </thead>
        <tbody>
            <?php
            foreach ($listProdi as $prodi) {
            ?>
                <tr>
                    <td><?= $prodi->nama_prodi ?></td>
                    <?php
                    foreach ($listUser as $user) {
                    ?>
                        <td><input type="checkbox" name="" id=""></td>
                    <?php
                    }
                    ?>
                </tr>

            <?php
            }
            ?>
        </tbody>

    </table>
    <?php
    foreach ($listProdi as $prodi) {
        # code...
    }
    ?>
</div>