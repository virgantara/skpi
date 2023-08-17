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
 * @property string|null $tanggal_mulai
 * @property string|null $tanggal_selesai
 * @property string|null $url_kegiatan
 * @property string|null $laporan_path
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $prodi_id
 *
 * @property SimakMasterprogramstudi $prodi
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
            [['user_id', 'simkatmawa_belmawa_kategori_id', 'prodi_id'], 'integer'],
            [['nama_kegiatan'], 'required'],
            [['tanggal_mulai', 'tanggal_selesai', 'created_at', 'updated_at'], 'safe'],
            [['jenis_simkatmawa'], 'string', 'max' => 20],
            [['nama_kegiatan', 'url_kegiatan', 'laporan_path'], 'string', 'max' => 255],
            [['peringkat'], 'string', 'max' => 150],
            [['keterangan'], 'string', 'max' => 500],
            [['simkatmawa_belmawa_kategori_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimkatmawaBelmawaKategori::class, 'targetAttribute' => ['simkatmawa_belmawa_kategori_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['prodi_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMasterprogramstudi::class, 'targetAttribute' => ['prodi_id' => 'id']],
            [['laporan_path'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 1024 * 1024 * 5],
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
            'simkatmawa_belmawa_kategori_id' => Yii::t('app', 'Simkatmawa Belmawa Kategori ID'),
            'jenis_simkatmawa' => Yii::t('app', 'Jenis Simkatmawa'),
            'nama_kegiatan' => Yii::t('app', 'Nama Kegiatan'),
            'peringkat' => Yii::t('app', 'Peringkat'),
            'keterangan' => Yii::t('app', 'Keterangan'),
            'tanggal_mulai' => Yii::t('app', 'Tanggal Mulai'),
            'tanggal_selesai' => Yii::t('app', 'Tanggal Selesai'),
            'url_kegiatan' => Yii::t('app', 'Url Kegiatan'),
            'laporan_path' => Yii::t('app', 'Laporan Path'),
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
