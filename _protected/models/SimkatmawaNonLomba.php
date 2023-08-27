<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_simkatmawa_non_lomba".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $nama_kegiatan
 * @property int|null $simkatmawa_kegiatan_id
 * @property string|null $tanggal_mulai
 * @property string|null $tanggal_selesai
 * @property string|null $laporan_path
 * @property string|null $url_kegiatan
 * @property string|null $foto_kegiatan_path
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $prodi_id
 *
 * @property SimakMasterprogramstudi $prodi
 * @property SimkatmawaKegiatan $simkatmawaKegiatan
 * @property SimkatmawaMahasiswa[] $simkatmawaMahasiswas
 * @property User $user
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
            [['user_id', 'simkatmawa_kegiatan_id', 'prodi_id'], 'integer'],
            [['nama_kegiatan'], 'required'],
            [['tanggal_mulai', 'tanggal_selesai', 'created_at', 'updated_at'], 'safe'],
            [['nama_kegiatan', 'laporan_path', 'url_kegiatan', 'foto_kegiatan_path'], 'string', 'max' => 255],
            [['simkatmawa_kegiatan_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimkatmawaKegiatan::class, 'targetAttribute' => ['simkatmawa_kegiatan_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['prodi_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMasterprogramstudi::class, 'targetAttribute' => ['prodi_id' => 'id']],
            [['foto_kegiatan_path', 'laporan_path'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'nama_kegiatan' => Yii::t('app', 'Nama Kegiatan'),
            'simkatmawa_kegiatan_id' => Yii::t('app', 'Simkatmawa Kegiatan ID'),
            'tanggal_mulai' => Yii::t('app', 'Tanggal Mulai'),
            'tanggal_selesai' => Yii::t('app', 'Tanggal Selesai'),
            'laporan_path' => Yii::t('app', 'Laporan Path'),
            'url_kegiatan' => Yii::t('app', 'Url Kegiatan'),
            'foto_kegiatan_path' => Yii::t('app', 'Foto Kegiatan Path'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'prodi_id' => Yii::t('app', 'Prodi ID'),
        ];
    }

    /**
     * Gets query for [[Prodi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdi()
    {
        return $this->hasOne(SimakMasterprogramstudi::class, ['id' => 'prodi_id']);
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

    /**
     * Gets query for [[SimkatmawaMahasiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimkatmawaMahasiswas()
    {
        return $this->hasMany(SimkatmawaMahasiswa::class, ['simkatmawa_non_lomba_id' => 'id']);
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
