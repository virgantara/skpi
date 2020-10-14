<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_organisasi_anggota".
 *
 * @property int $id
 * @property string|null $nim
 * @property int|null $organisasi_id
 * @property int|null $jabatan_id
 * @property string|null $peran
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property OrganisasiMahasiswa $organisasi
 * @property OrganisasiJabatan $jabatan
 * @property SimakMastermahasiswa $nim0
 */
class OrganisasiAnggota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_organisasi_anggota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organisasi_id', 'jabatan_id'], 'integer'],
            [['peran'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['nim'], 'string', 'max' => 25],
            [['nim', 'organisasi_id'], 'unique', 'targetAttribute' => ['nim', 'organisasi_id']],
            [['organisasi_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganisasiMahasiswa::className(), 'targetAttribute' => ['organisasi_id' => 'id']],
            [['jabatan_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganisasiJabatan::className(), 'targetAttribute' => ['jabatan_id' => 'id']],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::className(), 'targetAttribute' => ['nim' => 'nim_mhs']],
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
            'organisasi_id' => 'Organisasi ID',
            'jabatan_id' => 'Jabatan ID',
            'peran' => 'Peran',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getNamaMahasiswa()
    {
        return $this->nim0->nama_mahasiswa;
    }

    public function getNamaProdi()
    {
        return $this->nim0->kodeProdi->nama_prodi;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNamaFakultas()
    {
        return $this->nim0->kodeFakultas->nama_fakultas;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNamaKampus()
    {
        return $this->nim0->kampus0->nama_kampus;
    }

    /**
     * Gets query for [[Organisasi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisasi()
    {
        return $this->hasOne(OrganisasiMahasiswa::className(), ['id' => 'organisasi_id']);
    }

    /**
     * Gets query for [[Jabatan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJabatan()
    {
        return $this->hasOne(OrganisasiJabatan::className(), ['id' => 'jabatan_id']);
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
