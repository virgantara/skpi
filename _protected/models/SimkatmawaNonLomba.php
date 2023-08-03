<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_simkatmawa_non_lomba".
 *
 * @property int $id
 * @property string $nama_kegiatan
 * @property int|null $simkatmawa_kegiatan_id
 * @property string|null $tanggal_mulai
 * @property string|null $tanggal_selesai
 * @property string|null $laporan_path
 * @property string|null $url_kegiatan
 * @property string|null $foto_kegiatan_path
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SimkatmawaKegiatan $simkatmawaKegiatan
 */
class SimkatmawaNonLomba extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_simkatmawa_non_lomba';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_kegiatan'], 'required'],
            [['simkatmawa_kegiatan_id'], 'integer'],
            [['tanggal_mulai', 'tanggal_selesai', 'created_at', 'updated_at'], 'safe'],
            [['nama_kegiatan', 'laporan_path', 'url_kegiatan', 'foto_kegiatan_path'], 'string', 'max' => 255],
            [['simkatmawa_kegiatan_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimkatmawaKegiatan::class, 'targetAttribute' => ['simkatmawa_kegiatan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_kegiatan' => 'Nama Kegiatan',
            'simkatmawa_kegiatan_id' => 'Simkatmawa Kegiatan',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'laporan_path' => 'Laporan Kegiatan',
            'url_kegiatan' => 'Url Kegiatan',
            'foto_kegiatan_path' => 'Foto Kegiatan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[SimkatmawaKegiatan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimkatmawaKegiatan()
    {
        return $this->hasOne(SimkatmawaKegiatan::class, ['id' => 'simkatmawa_kegiatan_id']);
    }
}
