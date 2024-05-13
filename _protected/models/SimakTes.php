<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_tes".
 *
 * @property string $id
 * @property string $nim
 * @property string $jenis_tes
 * @property string $nama_tes
 * @property string $penyelenggara
 * @property string $tanggal_tes
 * @property int $tahun
 * @property string $skor_tes
 * @property string|null $file_path
 * @property string $status_validasi
 * @property string $updated_at
 * @property string $created_at
 *
 * @property SimakMastermahasiswa $nim0
 */
class SimakTes extends \yii\db\ActiveRecord
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
        return 'simak_tes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim', 'jenis_tes', 'nama_tes', 'penyelenggara', 'tanggal_tes', 'tahun', 'skor_tes'], 'required'],
            [['tahun'], 'integer'],
            [['skor_tes'], 'number'],
            [['skor_tes', 'updated_at', 'created_at','catatan','approved_by'], 'safe'],
            [['id', 'nama_tes', 'penyelenggara', 'tanggal_tes'], 'string', 'max' => 255],
            [['nim'], 'string', 'max' => 25],
            [['jenis_tes', 'status_validasi'], 'string', 'max' => 1],
            [['file_path'], 'string', 'max' => 500],
            [['id'], 'unique'],
            [['file_path'], 'file', 'skipOnEmpty' => true, 'extensions' => ['pdf'], 'maxSize' => 1024 * 1024 * 2],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::class, 'targetAttribute' => ['nim' => 'nim_mhs']],
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
            'nim' => 'Nim',
            'jenis_tes' => 'Jenis Tes',
            'nama_tes' => 'Nama Tes',
            'penyelenggara' => 'Penyelenggara',
            'tanggal_tes' => 'Tanggal Tes',
            'tahun' => 'Tahun',
            'skor_tes' => 'Skor Tes',
            'file_path' => 'File Path',
            'status_validasi' => 'Status Validasi',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
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
