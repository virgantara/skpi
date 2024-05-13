<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_sertifikasi".
 *
 * @property string $id
 * @property string $nim
 * @property string $jenis_sertifikasi
 * @property string $bidang_studi
 * @property string $lembaga_sertifikasi
 * @property string $nomor_registrasi_sertifikasi
 * @property int $tahun_sertifikasi
 * @property string $tmt_sertifikasi
 * @property string|null $tst_sertifikasi
 * @property string|null $file_path
 * @property string $status_validasi
 * @property string $updated_at
 * @property string $created_at
 *
 * @property SimakMastermahasiswa $nim0
 */
class SimakSertifikasi extends \yii\db\ActiveRecord
{
    public $kode_fakultas;
    public $kode_prodi;
    public $tahun_masuk;
    public $status_aktivitas;
    
    public $namaMahasiswa;
    public $namaKampus;
    public $namaProdi;
    public $namaJenisKegiatan;
    public $namaKegiatan;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_sertifikasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim', 'jenis_sertifikasi', 'lembaga_sertifikasi', 'nomor_registrasi_sertifikasi', 'tahun_sertifikasi', 'tmt_sertifikasi'], 'required'],
            [['tahun_sertifikasi'], 'integer'],
            [['tmt_sertifikasi', 'tst_sertifikasi', 'updated_at', 'created_at','catatan','predikat'], 'safe'],
            [['id', 'lembaga_sertifikasi', 'nomor_registrasi_sertifikasi', 'nomor_sk_sertifikasi'], 'string', 'max' => 255],
            [['nim'], 'string', 'max' => 25],
            [['predikat'], 'string', 'max' => 50],
            [['jenis_sertifikasi', 'status_validasi'], 'string', 'max' => 1],
            [['file_path'], 'string', 'max' => 500],
            [['id'], 'unique'],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::class, 'targetAttribute' => ['nim' => 'nim_mhs']],
            [['file_path'], 'file', 'skipOnEmpty' => true, 'extensions' => ['pdf'], 'maxSize' => 1024 * 1024 * 2],
            [['approved_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['approved_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nim' => 'NIM',
            'jenis_sertifikasi' => 'Jenis Sertifikasi',
            'lembaga_sertifikasi' => 'Lembaga Sertifikasi',
            'nomor_registrasi_sertifikasi' => 'Nomor Registrasi Sertifikasi',
            'nomor_sk_sertifikasi' => 'Nomor SK Sertifikasi',
            'tahun_sertifikasi' => 'Tahun Sertifikasi',
            'tmt_sertifikasi' => 'Tanggal Mulai Berlaku Sertifikasi',
            'tst_sertifikasi' => 'Tanggal Akhir Berlaku Sertifikasi',
            'file_path' => 'File Sertifikat',
            'status_validasi' => 'Status Validasi',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'predikat' => 'Predikat',
        ];
    }

    public function getApprovedBy()
    {
        return $this->hasOne(User::class, ['id' => 'approved_by']);
    }

    /**
     * Gets query for [[Nim0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNim0()
    {
        return $this->hasOne(SimakMastermahasiswa::class, ['nim_mhs' => 'nim']);
    }
}
