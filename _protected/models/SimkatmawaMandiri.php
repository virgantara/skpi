<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_simkatmawa_mandiri".
 *
 * @property int $id
 * @property string $nim
 * @property string $nama_kegiatan
 * @property string|null $penyelenggara
 * @property string|null $tempat_pelaksanaan
 * @property int|null $simkatmawa_rekognisi_id
 * @property int|null $level
 * @property int|null $apresiasi
 * @property string|null $url_kegiatan
 * @property string|null $tanggal_mulai
 * @property string|null $tanggal_selesai
 * @property string|null $sertifikat_path
 * @property string|null $foto_penyerahan_path
 * @property string|null $foto_kegiatan_path
 * @property string|null $foto_karya_path
 * @property string|null $surat_tugas_path
 * @property string|null $laporan_path
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SimkatmawaRekognisi $simkatmawaRekognisi
 */
class SimkatmawaMandiri extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_simkatmawa_mandiri';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nim', 'nama_kegiatan'], 'required'],
            [['simkatmawa_rekognisi_id', 'level', 'apresiasi'], 'integer'],
            [['tanggal_mulai', 'tanggal_selesai', 'created_at', 'updated_at'], 'safe'],
            [['nim'], 'string', 'max' => 25],
            [['nama_kegiatan', 'penyelenggara', 'tempat_pelaksanaan', 'url_kegiatan', 'sertifikat_path', 'foto_penyerahan_path', 'foto_kegiatan_path', 'foto_karya_path', 'surat_tugas_path', 'laporan_path'], 'string', 'max' => 255],
            [['simkatmawa_rekognisi_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimkatmawaRekognisi::class, 'targetAttribute' => ['simkatmawa_rekognisi_id' => 'id']],
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
            'nama_kegiatan' => 'Nama Kegiatan',
            'penyelenggara' => 'Penyelenggara',
            'tempat_pelaksanaan' => 'Tempat Pelaksanaan',
            'simkatmawa_rekognisi_id' => 'Simkatmawa Rekognisi ID',
            'level' => 'Level',
            'apresiasi' => 'Apresiasi',
            'url_kegiatan' => 'Url Kegiatan',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'sertifikat_path' => 'Sertifikat Path',
            'foto_penyerahan_path' => 'Foto Penyerahan Path',
            'foto_kegiatan_path' => 'Foto Kegiatan Path',
            'foto_karya_path' => 'Foto Karya Path',
            'surat_tugas_path' => 'Surat Tugas Path',
            'laporan_path' => 'Laporan Path',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[SimkatmawaRekognisi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimkatmawaRekognisi()
    {
        return $this->hasOne(SimkatmawaRekognisi::class, ['id' => 'simkatmawa_rekognisi_id']);
    }
}
