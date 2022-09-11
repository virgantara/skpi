<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_kegiatan_mahasiswa".
 *
 * @property int $id
 * @property string $nim
 * @property int $id_jenis_kegiatan
 * @property int $id_kegiatan
 * @property string|null $event_id
 * @property int|null $nilai
 * @property string|null $waktu
 * @property string|null $keterangan
 * @property string|null $tema
 * @property string|null $instansi
 * @property string|null $bagian
 * @property string|null $bidang
 * @property string|null $nama_kegiatan_mahasiswa
 * @property string $tahun_akademik
 * @property string|null $semester
 * @property string|null $tahun
 * @property string|null $penilai
 * @property string|null $file
 * @property string|null $file_path
 * @property string|null $s3_path
 * @property int|null $is_approved
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Events $event
 * @property SimakJenisKegiatan $jenisKegiatan
 * @property SimakKegiatan $kegiatan
 * @property SimakMastermahasiswa $nim0
 */
class SimakKegiatanMahasiswa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_kegiatan_mahasiswa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nim', 'id_jenis_kegiatan', 'id_kegiatan', 'tahun_akademik'], 'required'],
            [['id_jenis_kegiatan', 'id_kegiatan', 'nilai', 'is_approved'], 'integer'],
            [['waktu', 'created_at', 'updated_at','event_id'], 'safe'],
            [['keterangan', 'file'], 'string'],
            [['nim'], 'string', 'max' => 25],
            [['event_id'], 'string', 'max' => 20],
            [['tema', 'instansi', 'bagian', 'bidang', 'nama_kegiatan_mahasiswa', 'penilai', 'file_path', 's3_path'], 'string', 'max' => 255],
            [['tahun_akademik'], 'string', 'max' => 5],
            [['semester'], 'string', 'max' => 2],
            [['tahun'], 'string', 'max' => 4],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::className(), 'targetAttribute' => ['nim' => 'nim_mhs']],
            [['id_jenis_kegiatan'], 'exist', 'skipOnError' => true, 'targetClass' => SimakJenisKegiatan::className(), 'targetAttribute' => ['id_jenis_kegiatan' => 'id']],
            [['id_kegiatan'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKegiatan::className(), 'targetAttribute' => ['id_kegiatan' => 'id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Events::className(), 'targetAttribute' => ['event_id' => 'id']],
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
            'id_jenis_kegiatan' => 'Jenis Kegiatan',
            'id_kegiatan' => 'Kegiatan',
            'event_id' => 'Event',
            'nilai' => 'Nilai',
            'waktu' => 'Waktu',
            'keterangan' => 'Keterangan',
            'tema' => 'Tema',
            'instansi' => 'Instansi',
            'bagian' => 'Bagian',
            'bidang' => 'Bidang',
            'nama_kegiatan_mahasiswa' => 'Nama Kegiatan Mahasiswa',
            'tahun_akademik' => 'Tahun Akademik',
            'semester' => 'Semester',
            'tahun' => 'Tahun',
            'penilai' => 'Penilai',
            'file' => 'File',
            'file_path' => 'File Path',
            's3_path' => 'S3 Path',
            'is_approved' => 'Is Approved',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Events::className(), ['id' => 'event_id']);
    }

    /**
     * Gets query for [[JenisKegiatan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJenisKegiatan()
    {
        return $this->hasOne(SimakJenisKegiatan::className(), ['id' => 'id_jenis_kegiatan']);
    }

    /**
     * Gets query for [[Kegiatan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKegiatan()
    {
        return $this->hasOne(SimakKegiatan::className(), ['id' => 'id_kegiatan']);
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
}
