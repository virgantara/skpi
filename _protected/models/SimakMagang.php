<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_magang".
 *
 * @property string $id
 * @property string|null $nim
 * @property int $jenis_magang_id
 * @property string $nama_instansi
 * @property string|null $alamat_instansi
 * @property string|null $telp_instansi
 * @property string|null $email_instansi
 * @property string|null $nama_pembina_instansi
 * @property string|null $jabatan_pembina_instansi
 * @property int|null $kota_instansi
 * @property string|null $is_dalam_negeri 1=DN, 2=LN
 * @property string|null $tanggal_mulai_magang
 * @property string|null $tanggal_selesai_magang
 * @property string|null $status 0=belum diproses,1=disetujui,2=ditolak
 * @property string|null $keterangan
 * @property int|null $pembimbing_id
 * @property int|null $status_magang_id
 * @property string|null $file_laporan
 * @property float|null $nilai_angka
 * @property string|null $nilai_huruf
 * @property int|null $matakuliah_id
 * @property string|null $updated_at
 * @property string|null $created_at
 *
 * @property SimakPilihan $jenisMagang
 * @property Cities $kotaInstansi
 * @property SimakMatakuliah $matakuliah
 * @property SimakMastermahasiswa $nim0
 * @property SimakUsers $pembimbing
 * @property SimakMagangCatatan[] $simakMagangCatatans
 * @property SimakMagangNilai[] $simakMagangNilais
 * @property SimakPilihan $statusMagang
 */
class SimakMagang extends \yii\db\ActiveRecord
{
    public $nama_dosen;
    public $kode_prodi;
    public $nama_prodi;
    public $namaMahasiswa;
    public $kampus;
    public $negara;
    public $provinsi;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_magang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jenis_magang_id', 'nama_instansi'], 'required'],
            [['jenis_magang_id', 'kota_instansi', 'pembimbing_id', 'status_magang_id', 'matakuliah_id'], 'integer'],
            [['tanggal_mulai_magang', 'tanggal_selesai_magang', 'updated_at', 'created_at','negara','provinsi'], 'safe'],
            [['keterangan'], 'string'],
            [['nilai_angka'], 'number'],
            [['id', 'email_instansi'], 'string', 'max' => 50],
            [['nim'], 'string', 'max' => 25],
            [['nama_instansi', 'nama_pembina_instansi', 'jabatan_pembina_instansi'], 'string', 'max' => 255],
            [['alamat_instansi', 'file_laporan'], 'string', 'max' => 500],
            [['telp_instansi'], 'string', 'max' => 30],
            [['is_dalam_negeri', 'status'], 'string', 'max' => 1],
            [['nilai_huruf'], 'string', 'max' => 2],
            [['id'], 'unique'],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::class, 'targetAttribute' => ['nim' => 'nim_mhs']],
            [['kota_instansi'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['kota_instansi' => 'id']],
            [['pembimbing_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['pembimbing_id' => 'id']],
            [['jenis_magang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakPilihan::class, 'targetAttribute' => ['jenis_magang_id' => 'id']],
            [['status_magang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakPilihan::class, 'targetAttribute' => ['status_magang_id' => 'id']],
            [['matakuliah_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMatakuliah::class, 'targetAttribute' => ['matakuliah_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nim' => Yii::t('app', 'NIM'),
            'jenis_magang_id' => Yii::t('app', 'Jenis Magang'),
            'status_magang_id' => Yii::t('app', 'Status Magang'),
            'nama_instansi' => Yii::t('app', 'Nama Instansi'),
            'alamat_instansi' => Yii::t('app', 'Alamat Instansi'),
            'telp_instansi' => Yii::t('app', 'Telp Instansi'),
            'email_instansi' => Yii::t('app', 'Email Instansi'),
            'nama_pembina_instansi' => Yii::t('app', 'Nama Pembina Instansi'),
            'jabatan_pembina_instansi' => Yii::t('app', 'Jabatan Pembina Instansi'),
            'kota_instansi' => Yii::t('app', 'Kota Instansi'),
            'is_dalam_negeri' => Yii::t('app', 'Lokasi Magang'),
            'tanggal_mulai_magang' => Yii::t('app', 'Tanggal Mulai Magang'),
            'tanggal_selesai_magang' => Yii::t('app', 'Tanggal Selesai Magang'),
            'keterangan' => Yii::t('app', 'Keterangan'),
        ];
    }

    /**
     * Gets query for [[JenisMagang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJenisMagang()
    {
        return $this->hasOne(SimakPilihan::class, ['id' => 'jenis_magang_id']);
    }

    /**
     * Gets query for [[KotaInstansi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKotaInstansi()
    {
        return $this->hasOne(Cities::class, ['id' => 'kota_instansi']);
    }

    /**
     * Gets query for [[Matakuliah]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMatakuliah()
    {
        return $this->hasOne(SimakMatakuliah::class, ['id' => 'matakuliah_id']);
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

    /**
     * Gets query for [[Pembimbing]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembimbing()
    {
        return $this->hasOne(User::class, ['id' => 'pembimbing_id']);
    }

    /**
     * Gets query for [[SimakMagangCatatans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakMagangCatatans()
    {
        return $this->hasMany(SimakMagangCatatan::class, ['magang_id' => 'id']);
    }

    /**
     * Gets query for [[SimakMagangNilais]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakMagangNilais()
    {
        return $this->hasMany(SimakMagangNilai::class, ['magang_id' => 'id']);
    }

    /**
     * Gets query for [[StatusMagang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatusMagang()
    {
        return $this->hasOne(SimakPilihan::class, ['id' => 'status_magang_id']);
    }

    public function getCountCatatan()
    {
        return count($this->simakMagangCatatans);
    }
}
