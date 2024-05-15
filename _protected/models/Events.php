<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property string $id
 * @property int|null $kegiatan_id
 * @property string|null $nama
 * @property string|null $venue
 * @property string|null $tanggal_mulai
 * @property string|null $tanggal_selesai
 * @property int|null $tahun_id
 * @property int|null $toleransi_masuk
 * @property int|null $toleransi_keluar
 * @property string|null $penyelenggara
 * @property string|null $tingkat
 * @property string|null $kampus
 * @property string|null $fakultas
 * @property string|null $prodi
 * @property string|null $url
 * @property string|null $priority
 * @property string|null $status 0 : not started, 1 : on progres, 2: finished, 3: postponed, 4: canceled
 * @property string|null $file_path
 * @property string|null $dosen_id
 * @property string|null $updated_at
 * @property string|null $created_at
 *
 * @property SimakMasterdosen $dosen
 * @property SimakMasterfakultas $fakultas0
 * @property SimakKampus $kampus0
 * @property SimakKegiatan $kegiatan
 * @property SimakMasterprogramstudi $prodi0
 * @property SimakKegiatanMahasiswa[] $simakKegiatanMahasiswas
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['kegiatan_id', 'tahun_id', 'toleransi_masuk', 'toleransi_keluar'], 'integer'],
            [['tanggal_mulai', 'tanggal_selesai', 'updated_at', 'created_at'], 'safe'],
            [['id'], 'string', 'max' => 20],
            [['nama', 'venue', 'penyelenggara', 'url', 'file_path'], 'string', 'max' => 255],
            [['tingkat', 'prodi', 'priority'], 'string', 'max' => 15],
            [['kampus'], 'string', 'max' => 2],
            [['fakultas'], 'string', 'max' => 5],
            [['status'], 'string', 'max' => 1],
            [['dosen_id'], 'string', 'max' => 30],
            [['id'], 'unique'],
            [['kegiatan_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKegiatan::class, 'targetAttribute' => ['kegiatan_id' => 'id']],
            [['fakultas'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMasterfakultas::class, 'targetAttribute' => ['fakultas' => 'kode_fakultas']],
            [['prodi'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMasterprogramstudi::class, 'targetAttribute' => ['prodi' => 'kode_prodi']],
            [['dosen_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMasterdosen::class, 'targetAttribute' => ['dosen_id' => 'nidn']],
            [['kampus'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKampus::class, 'targetAttribute' => ['kampus' => 'kode_kampus']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kegiatan_id' => 'Kegiatan ID',
            'nama' => 'Nama',
            'venue' => 'Venue',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'tahun_id' => 'Tahun ID',
            'toleransi_masuk' => 'Toleransi Masuk',
            'toleransi_keluar' => 'Toleransi Keluar',
            'penyelenggara' => 'Penyelenggara',
            'tingkat' => 'Tingkat',
            'kampus' => 'Kampus',
            'fakultas' => 'Fakultas',
            'prodi' => 'Prodi',
            'url' => 'Url',
            'priority' => 'Priority',
            'status' => 'Status',
            'file_path' => 'File Path',
            'dosen_id' => 'Dosen ID',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Dosen]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDosen()
    {
        return $this->hasOne(SimakMasterdosen::class, ['nidn' => 'dosen_id']);
    }

    /**
     * Gets query for [[Fakultas0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFakultas0()
    {
        return $this->hasOne(SimakMasterfakultas::class, ['kode_fakultas' => 'fakultas']);
    }

    /**
     * Gets query for [[Kampus0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKampus0()
    {
        return $this->hasOne(SimakKampus::class, ['kode_kampus' => 'kampus']);
    }

    /**
     * Gets query for [[Kegiatan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKegiatan()
    {
        return $this->hasOne(SimakKegiatan::class, ['id' => 'kegiatan_id']);
    }

    /**
     * Gets query for [[Prodi0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdi0()
    {
        return $this->hasOne(SimakMasterprogramstudi::class, ['kode_prodi' => 'prodi']);
    }

    /**
     * Gets query for [[SimakKegiatanMahasiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakKegiatanMahasiswas()
    {
        return $this->hasMany(SimakKegiatanMahasiswa::class, ['event_id' => 'id']);
    }
}
