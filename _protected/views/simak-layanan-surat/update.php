<?php

use yii\helpers\Html;

use yii\widgets\DetailView;
use app\helpers\MyHelper;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\SimakLayananSurat */

$list_header = MyHelper::getListHeaderSurat();
$this->title = 'Approval Layanan Surat: ' . $list_header[$model->jenis_surat];
$this->params['breadcrumbs'][] = ['label' => 'Layanan Surat', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';


/* @var $this yii\web\View */
/* @var $model app\models\SimakLayananSurat */
/* @var $form yii\widgets\ActiveForm */

$list_tahun = \app\models\SimakTahunakademik::find()->orderBy(['tahun_id' => SORT_DESC])->limit(3)->all();

// 

$list_status_ajuan = [
    0 => 'BELUM DISETUJUI',
    1 => 'DISETUJUI',
    2 => 'DITOLAK',
];
?>
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h3><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-xs-12">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                    'label' => 'Nama Mahasiswa',
                                    'value' => function($data){
                                        return $data->nim0->nama_mahasiswa;
                                    }
                                ],
                                'nim',
                                [
                                    'label' => 'Semester',
                                    'value' => function($data){
                                        return $data->nim0->semester;
                                    }
                                ],
                                'tahun.nama_tahun',
                                'keperluan:ntext',
                                'bahasa',
                                'tanggal_diajukan',
                                'tanggal_disetujui',
                                'nomor_surat',
                                // 'nama_pejabat',
                                [
                                    'attribute' => 'status_ajuan',
                                    'value' => function($data) use ($list_status_ajuan){
                                        return $list_status_ajuan[$data->status_ajuan];
                                    }
                                ],
                            ],
                        ]) ?>
                    </div>
                    <div class="col-lg-8 col-md-12  col-xs-12">
                         <?php $form = ActiveForm::begin([
                            'options' => [
                                'id' => 'form_validation',
                            ]
                        ]); ?>

                        <?php echo $form->errorSummary($model,['header'=>'<div class="alert alert-danger">','footer'=>'</div>']);?>
                        <?= $form->field($model, 'nomor_surat')->textInput() ?>
                        <?= $form->field($model, 'status_ajuan')->dropDownList(['1' => 'SETUJUI','2' => 'TOLAK PERSETUJUAN']) ?>
                        <?= Html::submitButton('Update', ['class' => 'btn btn-primary waves-effect']) ?>
                        
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
    
           
   

           </div>
        </div>
    </div>
</div>
