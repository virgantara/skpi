<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\HighchartAsset;

HighchartAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\SimakJadwalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kompetensi';
$this->params['breadcrumbs'][] = $this->title;

?>
<style type="text/css">
  .swal2-popup {
  font-size: 1.6rem !important;
}
</style>

<div class="row">
  <div class="col-md-offset-3 col-md-6">
    <h3 class="page-title"><?=$this->title;?></h3>

    <div class="panel">
      <div class="panel-heading">
        Rubric
      </div>
      <div class="panel-body">
        <table class="table table-striped">
          <thead>
            <tr>
            <th>No</th>
            <th>Criteria</th>
            <th>Predicate - Range</th>
            
          </tr>
          </thead>
          <tbody>
            <?php 
            $kompetensi_range = \app\models\SimakIndukKegiatanKompetensi::find()->orderBy(['induk_id' => SORT_ASC])->all();
            foreach($kompetensi_range as $q=>$v)
            {
              $list_range = \app\models\SimakKompetensiRangeNilai::find()->where([
                'induk_kompetensi_id' => $v->id
              ])->orderBy(['nilai_minimal'=>SORT_ASC])->all();
            ?>
            <tr>
              <td><?=$q+1;?></td>
              <td><?=$v->pilihan->label_en;?></td>
              <td>
                <table width="100%" >
                <?php 
                foreach($list_range as $r)
                {
                  echo '<tr>';
                  echo '<td style="padding:2px" width="50%">';
                  echo $r->nilai_minimal.' - '.$r->nilai_maksimal;
                  echo '</td>';
                  echo '<td>';
                  echo ' <span class="label label-'.$r->color.'">'.$r->label_en.'</span>';
                  echo '</td>';
                  echo '</tr>';
                }
                ?>
                </table>
              </td>
            </tr>
            <?php 



            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<?php 

$this->registerJs(' 


', \yii\web\View::POS_READY);

?>