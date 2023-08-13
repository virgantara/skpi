<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_simkatmawa_belmawa".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $simkatmawa_belmawa_kategori_id
 * @property string|null $jenis_simkatmawa
 * @property string $nama_kegiatan
 * @property string|null $peringkat
 * @property string|null $keterangan
 * @property string|null $tahun
 * @property string|null $url_kegiatan
 * @property string|null $laporan_path
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SimkatmawaBelmawaKategori $simkatmawaBelmawaKategori
 * @property SimkatmawaMahasiswa[] $simkatmawaMahasiswas
 * @property User $user
 */
class SimkatmawaBelmawa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_simkatmawa_belmawa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'simkatmawa_belmawa_kategori_id'], 'integer'],
            [['nama_kegiatan'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['jenis_simkatmawa'], 'string', 'max' => 20],
            [['nama_kegiatan', 'url_kegiatan', 'laporan_path'], 'string', 'max' => 255],
            [['peringkat'], 'string', 'max' => 150],
            [['keterangan'], 'string', 'max' => 500],
            [['tahun'], 'string', 'max' => 4],
            [['simkatmawa_belmawa_kategori_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimkatmawaBelmawaKategori::class, 'targetAttribute' => ['simkatmawa_belmawa_kategori_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'simkatmawa_belmawa_kategori_id' => 'Simkatmawa Belmawa Kategori ID',
            'jenis_simkatmawa' => 'Jenis Simkatmawa',
            'nama_kegiatan' => 'Nama Kegiatan',
            'peringkat' => 'Peringkat',
            'keterangan' => 'Keterangan',
            'tahun' => 'Tahun',
            'url_kegiatan' => 'Url Kegiatan',
            'laporan_path' => 'Laporan Path',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[SimkatmawaBelmawaKategori]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimkatmawaBelmawaKategori()
    {
        return $this->hasOne(SimkatmawaBelmawaKategori::class, ['id' => 'simkatmawa_belmawa_kategori_id']);
    }

    /**
     * Gets query for [[SimkatmawaMahasiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimkatmawaMahasiswas()
    {
        return $this->hasMany(SimkatmawaMahasiswa::class, ['simkatmawa_belmawa_id' => 'id']);
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
