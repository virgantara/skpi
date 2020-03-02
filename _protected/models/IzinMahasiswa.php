<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_izin_mahasiswa".
 *
 * @property int $id
 * @property string $nim
 * @property int $tahun_akademik
 * @property int $semester
 * @property string $kota_id
 * @property int $keperluan_id
 * @property string $alasan
 * @property string $tanggal_berangkat
 * @property string $tanggal_pulang
 * @property int|null $status 1= Belum pulang, 2= pulang
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SimakMastermahasiswa $nim0
 * @property SimakKabupaten $kota
 */
class IzinMahasiswa extends \yii\db\ActiveRecord
{
    public $tanggal_awal;
    public $tanggal_akhir;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_izin_mahasiswa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nim', 'tahun_akademik', 'semester', 'kota_id', 'keperluan_id', 'alasan', 'tanggal_berangkat', 'tanggal_pulang'], 'required'],
            [['tahun_akademik', 'semester', 'keperluan_id', 'status', 'baak_approved', 'prodi_approved', 'approved'], 'integer'],
            [['alasan'], 'string'],
            [['tanggal_berangkat', 'tanggal_pulang', 'created_at', 'updated_at'], 'safe'],
            [['nim'], 'string', 'max' => 25],
            [['kota_id'], 'string', 'max' => 11],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::className(), 'targetAttribute' => ['nim' => 'nim_mhs']],
            [['kota_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKabupaten::className(), 'targetAttribute' => ['kota_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nim' => 'Nim',
            'tahun_akademik' => 'Tahun Akademik',
            'semester' => 'Semester',
            'kota_id' => 'Kota ID',
            'keperluan_id' => 'Keperluan ID',
            'alasan' => 'Alasan',
            'tanggal_berangkat' => 'Tanggal Berangkat',
            'tanggal_pulang' => 'Tanggal Pulang',
            'status' => 'Status',
            'baak_approved' => 'BAAK Approval',
            'prodi_approved' => 'KAPRODI Approval',
            'approved' => 'KEPENGASUHAN Approval',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Nim0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNim0()
    {
        return $this->hasOne(SimakMastermahasiswa::className(), ['nim_mhs' => 'nim']);
    }

    /**
     * Gets query for [[Kota]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKota()
    {
        return $this->hasOne(SimakKabupaten::className(), ['id' => 'kota_id']);
    }

    public function getNamaMahasiswa()
    {
        return $this->nim0->nama_mahasiswa;
    }

    public function getNamaProdi()
    {
        return $this->nim0->kodeProdi->nama_prodi;
    }

    public function getNamaFakultas()
    {
        return $this->nim0->kodeProdi->kodeFakultas->nama_fakultas;
    }

    public function getSemester()
    {
        return $this->nim0->semester;
    }

    public function getNamaKeperluan()
    {
        switch ($this->keperluan_id) {
            case 1:
                return 'Pribadi';
                break;
            case 2:
                return 'Kampus';
                break;
            case 3:
                return 'Harian';
                break;
            default:
                return '';
                break;
        }
        // return $this->keperluan_id == "1" ? 'Pribadi' : 'Kampus';
    }

    public function getNamaKategori()
    {
        return $this->pelanggaran->kategori->nama;
    }

    public function getNamaAsrama()
    {
        return !empty($this->nim0->kamar) ? $this->nim0->kamar->asrama->nama : '';
    }

    public function getNamaKamar()
    {
        return !empty($this->nim0->kamar) ? $this->nim0->kamar->nama : '';
    }

    public function getStatusIzin()
    {
        return $this->status == '1' ? '<label class="label label-danger"><i class="fa fa-ban"></i> Belum Pulang</label>' : '<label class="label label-success"><i class="fa fa-check"></i> Sudah Pulang</label>';
    }

    public function getNamaKota()
    {
        return $this->kota->kab.' - '.$this->kota->provinsi->prov;
    }
}
