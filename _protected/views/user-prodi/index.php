<?php

use app\helpers\CssHelper;
use app\models\UserProdi;
use richardfan\widget\JSRegister;
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
            foreach ($listProdi as $prodi) :
            ?>
                <tr>
                    <td><?= $prodi->nama_prodi ?></td>
                    <?php
                    foreach ($listUser as $user) :
                        $m = UserProdi::find()->where(['prodi_id' => $prodi->id, 'user_id' => $user->id])->one();

                        $checked = !empty($m) ? 'checked' : '';
                    ?>
                        <td style="text-align: center;"><input name="<?= $user->id ?>" type="radio" <?= $checked; ?> class="mycheck" data-prodi="<?= $prodi->id; ?>" data-user="<?= $user->id; ?>" m value="1">
                        </td>
                    <?php
                    endforeach;
                    ?>
                </tr>

            <?php
            endforeach;
            ?>
        </tbody>

    </table>
</div>

<?php JSRegister::begin() ?>
<script>
    $(".mycheck").change(function() {
        var prodi = $(this).data("prodi");
        var user = $(this).data("user");
        var obj = new Object;
        obj.prodi_id = prodi;
        obj.user_id = user;
        obj.checked = $(this).prop("checked") ? "1" : "0";

        $.ajax({
            type: "POST",
            url: "/user-prodi/ajax-user-prodi",
            data: {
                dataPost: obj
            },
            success: function(data) {
                console.log(data)
            }
        });
    });
</script>
<?php JSRegister::end() ?>