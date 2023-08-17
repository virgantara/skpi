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
        $tahun = null;
        $prodi = null;

        if ($_POST) {
            $dataPost = $_POST['dataPost'];
            $tahun = $dataPost['tahun'];
            $prodi = $dataPost['prodi'];
        }

        $simkatmawaNonLomba = SimkatmawaNonLomba::find();
        $simkatmawaBelmawa = SimkatmawaBelmawa::find();

        if ($tahun != null) {
            $tanggalMulai = $tahun . '-01-01';
            $tanggalSelesai = $tahun . '-12-31';

            $simkatmawaNonLomba->andWhere(['between', 'tanggal_mulai', $tanggalMulai, $tanggalSelesai]);
            $simkatmawaBelmawa->andWhere(['between', 'tanggal_mulai', $tanggalMulai, $tanggalSelesai]);
        }
        if (!empty($prodi)) {
            $simkatmawaNonLomba->andWhere(['prodi_id' => $prodi]);
            $simkatmawaBelmawa->andWhere(['prodi_id' => $prodi]);
        }

        $countPertukaranPelajar = $this->simkatmawaMbkm('pertukaran-pelajar', $tahun, $prodi)->count();
        $countMengajarDiSekolah = $this->simkatmawaMbkm('mengajar-di-sekolah', $tahun, $prodi)->count();
        $countPenelitian = $this->simkatmawaMbkm('penelitian', $tahun, $prodi)->count();
        $countProyekKemanusiaan = $this->simkatmawaMbkm('proyek-kemanusiaan', $tahun, $prodi)->count();
        $countProyekDesa = $this->simkatmawaMbkm('proyek-desa', $tahun, $prodi)->count();
        $countWirausaha = $this->simkatmawaMbkm('wirausaha', $tahun, $prodi)->count();
        $countStudi = $this->simkatmawaMbkm('studi', $tahun, $prodi)->count();
        $countPengabdianMasyarakat = $this->simkatmawaMbkm('pengabdian-masyarakat', $tahun, $prodi)->count();

        $countPembinaanMentalKebangsaan = $simkatmawaNonLomba->count();

        $countRekognisi = $this->simkatmawaMandiri('rekognisi', $tahun, $prodi)->count();
        $countKegiatanMandiri = $this->simkatmawaMandiri('kegiatan-mandiri', $tahun, $prodi)->count();

        $countBelmawa = $simkatmawaBelmawa->count();

        $response = [
            [
                'mbkm' => 'Pertukaran Pelajar',
                'total' => (int)$countPertukaranPelajar
            ],
            [
                'mbkm' => 'Mengajar di Sekolah',
                'total' => (int)$countMengajarDiSekolah
            ],
            [
                'mbkm' => 'Penelitian / Riset',
                'total' => (int)$countPenelitian
            ],
            [
                'mbkm' => 'Proyek Kemanusiaan',
                'total' => (int)$countProyekKemanusiaan
            ],
            [
                'mbkm' => 'Proyek Desa',
                'total' => (int)$countProyekDesa
            ],
            [
                'mbkm' => 'Wirausaha',
                'total' => (int)$countWirausaha
            ],
            [
                'mbkm' => 'Studi / Proyek Independen',
                'total' => (int)$countStudi
            ],
            [
                'mbkm' => 'Pengabdian Mahasiswa kepada Masyarakat',
                'total' => (int)$countPengabdianMasyarakat
            ],
            [
                'mbkm' => 'Pembinaan Mental Kebangsaan',
                'total' => (int)$countPembinaanMentalKebangsaan
            ],
            [
                'mbkm' => 'Rekognisi',
                'total' => (int)$countRekognisi
            ],
            [
                'mbkm' => 'Kegiatan Mandiri',
                'total' => (int)$countKegiatanMandiri
            ],
            [
                'mbkm' => 'Belmawa',
                'total' => (int)$countBelmawa
            ],
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function actionGetData()
    {
        $tahun = null;
        $prodi = null;
        if ($_POST) {
            $dataPost = $_POST['dataPost'];
            $tahun = $dataPost['tahun'];
            $prodi = $dataPost['prodi'];
        }

        $simkatmawaNonLomba = SimkatmawaNonLomba::find();
        $simkatmawaBelmawa = SimkatmawaBelmawa::find();

        if (!empty($tahun)) {
            $tanggalMulai = $tahun . '-01-01';
            $tanggalSelesai = $tahun . '-12-31';

            $simkatmawaNonLomba->andWhere(['between', 'tanggal_mulai', $tanggalMulai, $tanggalSelesai]);
            $simkatmawaBelmawa->andWhere(['between', 'tanggal_mulai', $tanggalMulai, $tanggalSelesai]);
        }
        if (!empty($prodi)) {
            $simkatmawaNonLomba->andWhere(['prodi_id' => $prodi]);
            $simkatmawaBelmawa->andWhere(['prodi_id' => $prodi]);
        }

        $countPertukaranPelajar = $this->simkatmawaMbkm('pertukaran-pelajar', $tahun, $prodi)->count();
        $countMengajarDiSekolah = $this->simkatmawaMbkm('mengajar-di-sekolah', $tahun, $prodi)->count();
        $countPenelitian = $this->simkatmawaMbkm('penelitian', $tahun, $prodi)->count();
        $countProyekKemanusiaan = $this->simkatmawaMbkm('proyek-kemanusiaan', $tahun, $prodi)->count();
        $countProyekDesa = $this->simkatmawaMbkm('proyek-desa', $tahun, $prodi)->count();
        $countWirausaha = $this->simkatmawaMbkm('wirausaha', $tahun, $prodi)->count();
        $countStudi = $this->simkatmawaMbkm('studi', $tahun, $prodi)->count();
        $countPengabdianMasyarakat = $this->simkatmawaMbkm('pengabdian-masyarakat', $tahun, $prodi)->count();

        $countPembinaanMentalKebangsaan = $simkatmawaNonLomba->count();

        $countRekognisi = $this->simkatmawaMandiri('rekognisi', $tahun, $prodi)->count();
        $countKegiatanMandiri = $this->simkatmawaMandiri('kegiatan-mandiri', $tahun, $prodi)->count();

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

    protected function simkatmawaMbkm($jenisSimkatmawa, $tahun, $prodi)
    {

        $model = SimkatmawaMbkm::find()->where(['jenis_simkatmawa' => $jenisSimkatmawa]);
        if (!empty($tahun)) {
            $tanggalMulai = $tahun . '-01-01';
            $tanggalSelesai = $tahun . '-12-31';
            $model->andWhere(['between', 'tanggal_mulai', $tanggalMulai, $tanggalSelesai]);
        }
        if (!empty($prodi)) {
            $model->andWhere(['prodi_id' => $prodi]);
        }

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function simkatmawaMandiri($jenisSimkatmawa, $tahun, $prodi)
    {

        $model = SimkatmawaMandiri::find()->where(['jenis_simkatmawa' => $jenisSimkatmawa]);
        if (!empty($tahun)) {
            $tanggalMulai = $tahun . '-01-01';
            $tanggalSelesai = $tahun . '-12-31';
            $model->andWhere(['between', 'tanggal_mulai', $tanggalMulai, $tanggalSelesai]);
        }
        if (!empty($prodi)) {
            $model->andWhere(['prodi_id' => $prodi]);
        }

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
