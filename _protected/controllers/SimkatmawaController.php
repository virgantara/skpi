<?php

namespace app\controllers;

use app\models\SimkatmawaBelmawa;
use app\models\SimkatmawaBelmawaSearch;
use app\models\SimkatmawaMahasiswa;
use app\models\SimkatmawaMandiri;
use app\models\SimkatmawaMbkm;
use app\models\SimkatmawaNonLomba;
use DateTime;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SimkatmawaController implements the CRUD actions for SimkatmawaBelmawa model.
 */
class SimkatmawaController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionCountSimkatmawaByJenis()
    {
        $dataPost = $_POST;
        $tahun = $dataPost['tahun'];

        $simkatmawaNonLomba = SimkatmawaNonLomba::find();
        $simkatmawaBelmawa = SimkatmawaBelmawa::find();

        if (!empty($tahun)) {
            $tanggalMulai = $tahun . '-01-01';
            $tanggalSelesai = $tahun . '-12-31';

            $simkatmawaNonLomba->andWhere(['between', 'tanggal_mulai', $tanggalMulai, $tanggalSelesai]);
            $simkatmawaBelmawa->andWhere(['between', 'tanggal_mulai', $tanggalMulai, $tanggalSelesai]);
        }

        $countPertukaranPelajar = $this->simkatmawaMbkm('pertukaran-pelajar', $tahun)->count();
        $countMengajarDiSekolah = $this->simkatmawaMbkm('mengajar-di-sekolah', $tahun)->count();
        $countPenelitian = $this->simkatmawaMbkm('penelitian', $tahun)->count();
        $countProyekKemanusiaan = $this->simkatmawaMbkm('proyek-kemanusiaan', $tahun)->count();
        $countProyekDesa = $this->simkatmawaMbkm('proyek-desa', $tahun)->count();
        $countWirausaha = $this->simkatmawaMbkm('wirausaha', $tahun)->count();
        $countStudi = $this->simkatmawaMbkm('studi', $tahun)->count();
        $countPengabdianMasyarakat = $this->simkatmawaMbkm('pengabdian-masyarakat', $tahun)->count();

        $countPembinaanMentalKebangsaan = $simkatmawaNonLomba->count();

        $countRekognisi = $this->simkatmawaMandiri('rekognisi', $tahun)->count();
        $countKegiatanMandiri = $this->simkatmawaMandiri('kegiatan-mandiri', $tahun)->count();

        $countBelmawa = $simkatmawaBelmawa->count();

        $response = [
            [
                'tingkat' => 'Pertukaran Pelajar',
                'total' => 1
            ],
            [
                'tingkat' => 'Mengajar di Sekolah',
                'total' => 2
            ],
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function actionGetData()
    {
        $dataPost = $_POST;
        $tahun = $dataPost['tahun'];

        $simkatmawaNonLomba = SimkatmawaNonLomba::find();
        $simkatmawaBelmawa = SimkatmawaBelmawa::find();

        if (!empty($tahun)) {
            $tanggalMulai = $tahun . '-01-01';
            $tanggalSelesai = $tahun . '-12-31';

            $simkatmawaNonLomba->andWhere(['between', 'tanggal_mulai', $tanggalMulai, $tanggalSelesai]);
            $simkatmawaBelmawa->andWhere(['between', 'tanggal_mulai', $tanggalMulai, $tanggalSelesai]);
        }

        $countPertukaranPelajar = $this->simkatmawaMbkm('pertukaran-pelajar', $tahun)->count();
        $countMengajarDiSekolah = $this->simkatmawaMbkm('mengajar-di-sekolah', $tahun)->count();
        $countPenelitian = $this->simkatmawaMbkm('penelitian', $tahun)->count();
        $countProyekKemanusiaan = $this->simkatmawaMbkm('proyek-kemanusiaan', $tahun)->count();
        $countProyekDesa = $this->simkatmawaMbkm('proyek-desa', $tahun)->count();
        $countWirausaha = $this->simkatmawaMbkm('wirausaha', $tahun)->count();
        $countStudi = $this->simkatmawaMbkm('studi', $tahun)->count();
        $countPengabdianMasyarakat = $this->simkatmawaMbkm('pengabdian-masyarakat', $tahun)->count();

        $countPembinaanMentalKebangsaan = $simkatmawaNonLomba->count();

        $countRekognisi = $this->simkatmawaMandiri('rekognisi', $tahun)->count();
        $countKegiatanMandiri = $this->simkatmawaMandiri('kegiatan-mandiri', $tahun)->count();

        $countBelmawa = $simkatmawaBelmawa->count();

        $response = array(
            'countPertukaranPelajar' => $countPertukaranPelajar,
            'countMengajarDiSekolah' => $countMengajarDiSekolah,
            'countPenelitian' => $countPenelitian,
            'countProyekKemanusiaan' => $countProyekKemanusiaan,
            'countProyekDesa' => $countProyekDesa,
            'countWirausaha' => $countWirausaha,
            'countPengabdianMasyarakat' => $countPengabdianMasyarakat,
            'countStudi' => $countStudi,
            'countPembinaanMentalKebangsaan' => $countPembinaanMentalKebangsaan,
            'countRekognisi' => $countRekognisi,
            'countKegiatanMandiri' => $countKegiatanMandiri,
            'countBelmawa' => $countBelmawa,
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    protected function simkatmawaMbkm($jenisSimkatmawa, $tahun)
    {

        $model = SimkatmawaMbkm::find()->where(['jenis_simkatmawa' => $jenisSimkatmawa]);
        if (!empty($tahun)) {
            $tanggalMulai = $tahun . '-01-01';
            $tanggalSelesai = $tahun . '-12-31';
            $model->andWhere(['between', 'tanggal_mulai', $tanggalMulai, $tanggalSelesai]);
        }

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function simkatmawaMandiri($jenisSimkatmawa, $tahun)
    {

        $model = SimkatmawaMandiri::find()->where(['jenis_simkatmawa' => $jenisSimkatmawa]);
        if (!empty($tahun)) {
            $tanggalMulai = $tahun . '-01-01';
            $tanggalSelesai = $tahun . '-12-31';
            $model->andWhere(['between', 'tanggal_mulai', $tanggalMulai, $tanggalSelesai]);
        }

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
