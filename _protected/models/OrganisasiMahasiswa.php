<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_organisasi_mahasiswa".
 *
 * @property int $id
 * @property int|null $organisasi_id
 * @property int|null $pembimbing_id
 * @property string|null $tanggal_mulai
 * @property string|null $tanggal_selesai
 * @property string|null $no_sk
 * @property string|null $tanggal_sk
 * @property int|null $tahun_akademik
 * @property string|null $kampus
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SimakKampus $kampus0
 * @property SimakMastermahasiswa[] $nims
 * @property Organisasi $organisasi
 * @property OrganisasiAnggota[] $organisasiAnggotas
 * @property SimakMasterdosen $pembimbing
 */
class OrganisasiMahasiswa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_organisasi_mahasiswa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organisasi_id', 'pembimbing_id', 'tahun_akademik'], 'required'],
            [['organisasi_id', 'pembimbing_id', 'tahun_akademik'], 'integer'],
            [['tanggal_mulai', 'tanggal_selesai', 'tanggal_sk', 'created_at', 'updated_at'], 'safe'],
            [['no_sk'], 'string', 'max' => 255],
            [['kampus'], 'string', 'max' => 2],
            [['organisasi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organisasi::className(), 'targetAttribute' => ['organisasi_id' => 'id']],
            [['pembimbing_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMasterdosen::className(), 'targetAttribute' => ['pembimbing_id' => 'id']],
            [['kampus'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKampus::className(), 'targetAttribute' => ['kampus' => 'kode_kampus']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organisasi_id' => 'Organisasi ID',
            'pembimbing_id' => 'Pembimbing ID',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'no_sk' => 'No Sk',
            'tanggal_sk' => 'Tanggal Sk',
            'tahun_akademik' => 'Tahun Akademik',
            'kampus' => 'Kampus',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Kampus0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKampus0()
    {
        return $this->hasOne(SimakKampus::className(), ['kode_kampus' => 'kampus']);
    }

    /**
     * Gets query for [[Nims]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNims()
    {
        return $this->hasMany(SimakMastermahasiswa::className(), ['nim_mhs' => 'nim'])->viaTable('erp_organisasi_anggota', ['organisasi_id' => 'id']);
    }

    /**
     * Gets query for [[Organisasi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisasi()
    {
        return $this->hasOne(Organisasi::className(), ['id' => 'organisasi_id']);
    }

    /**
     * Gets query for [[OrganisasiAnggotas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisasiAnggotas()
    {
        return $this->hasMany(OrganisasiAnggota::className(), ['organisasi_id' => 'id']);
    }

    /**
     * Gets query for [[Pembimbing]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembimbing()
    {
        return $this->hasOne(SimakMasterdosen::className(), ['id' => 'pembimbing_id']);
    }
}
