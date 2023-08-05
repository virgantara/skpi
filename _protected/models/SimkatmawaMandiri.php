<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_simkatmawa_mandiri".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $simkatmawa_rekognisi_id
 * @property string|null $jenis_simkatmawa
 * @property string $nama_kegiatan
 * @property string|null $penyelenggara
 * @property string|null $tempat_pelaksanaan
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
 * @property User $user
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
            [['user_id', 'simkatmawa_rekognisi_id', 'level', 'apresiasi'], 'integer'],
            [['nama_kegiatan'], 'required'],
            [['tanggal_mulai', 'tanggal_selesai', 'created_at', 'updated_at'], 'safe'],
            [['jenis_simkatmawa'], 'string', 'max' => 20],
            [['nama_kegiatan', 'penyelenggara', 'tempat_pelaksanaan', 'url_kegiatan', 'sertifikat_path', 'foto_penyerahan_path', 'foto_kegiatan_path', 'foto_karya_path', 'surat_tugas_path', 'laporan_path'], 'string', 'max' => 255],
            [['simkatmawa_rekognisi_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimkatmawaRekognisi::class, 'targetAttribute' => ['simkatmawa_rekognisi_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['sertifikat_path', 'foto_penyerahan_path', 'foto_kegiatan_path', 'foto_karya_path', 'surat_tugas_path', 'laporan_path'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => Yii::t('app', 'User'),
            'simkatmawa_rekognisi_id' => Yii::t('app', 'Simkatmawa Rekognisi'),
            'jenis_simkatmawa' => Yii::t('app', 'Jenis Simkatmawa'),
            'nama_kegiatan' => Yii::t('app', 'Nama Kegiatan'),
            'penyelenggara' => Yii::t('app', 'Penyelenggara'),
            'tempat_pelaksanaan' => Yii::t('app', 'Tempat Pelaksanaan'),
            'level' => Yii::t('app', 'Level'),
            'apresiasi' => Yii::t('app', 'Apresiasi'),
            'url_kegiatan' => Yii::t('app', 'Url Kegiatan'),
            'tanggal_mulai' => Yii::t('app', 'Tanggal Mulai'),
            'tanggal_selesai' => Yii::t('app', 'Tanggal Selesai'),
            'sertifikat_path' => Yii::t('app', 'Sertifikat Path'),
            'foto_penyerahan_path' => Yii::t('app', 'Foto Penyerahan Path'),
            'foto_kegiatan_path' => Yii::t('app', 'Foto Kegiatan Path'),
            'foto_karya_path' => Yii::t('app', 'Foto Karya Path'),
            'surat_tugas_path' => Yii::t('app', 'Surat Tugas Path'),
            'laporan_path' => Yii::t('app', 'Laporan Path'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
