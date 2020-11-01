<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_riwayat_pelanggaran".
 *
 * @property int $id
 * @property int $pelanggaran_id
 * @property string $tanggal
 * @property string $nim
 * @property int $tahun_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property RiwayatHukuman[] $riwayatHukumen
 * @property Pelanggaran $pelanggaran
 * @property SimakMastermahasiswa $nim0
 */
class RiwayatPelanggaran extends \yii\db\ActiveRecord
{

    
    public $tanggal_awal;
    public $tanggal_akhir;
     public $kategori_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_riwayat_pelanggaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pelanggaran_id', 'tanggal', 'nim', 'tahun_id'], 'required'],
            [['pelanggaran_id', 'tahun_id'], 'integer'],
            [['tanggal', 'created_at', 'updated_at'], 'safe'],
            [['nim'], 'string', 'max' => 25],
            [['pelanggaran_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pelanggaran::className(), 'targetAttribute' => ['pelanggaran_id' => 'id']],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::className(), 'targetAttribute' => ['nim' => 'nim_mhs']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pelanggaran_id' => 'Pelanggaran ID',
            'tanggal' => 'Tgl Pelanggaran',
            'nim' => 'NIM',
            'tahun_id' => 'Tahun ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'namaMahasiswa' => 'Nama',
            'namaPelanggaran' => 'Pelanggaran',
            'namaKategori' => 'Kategori',
            'namaAsrama' => 'Asrama',
            'namaKamar' => 'Kamar'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRiwayatHukumen()
    {
        return $this->hasMany(RiwayatHukuman::className(), ['pelanggaran_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelanggaran()
    {
        return $this->hasOne(Pelanggaran::className(), ['id' => 'pelanggaran_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNim0()
    {
        return $this->hasOne(SimakMastermahasiswa::className(), ['nim_mhs' => 'nim']);
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

    public function getNamaPelanggaran()
    {
        return $this->pelanggaran->nama;
    }

    public function getKodePelanggaran()
    {
        return $this->pelanggaran->kode;
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

    public function getStatusAktif()
    {
        return $this->nim0->status_aktivitas;
    }
}
