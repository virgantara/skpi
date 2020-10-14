<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_organisasi_mahasiswa".
 *
 * @property int $id
 * @property string|null $nim
 * @property int|null $organisasi_id
 * @property int|null $jabatan_id
 * @property string|null $peran
 * @property string|null $is_aktif
 * @property string|null $tanggal_mulai
 * @property string|null $tanggal_selesai
 *
 * @property SimakMastermahasiswa $nim0
 * @property OrganisasiJabatan $jabatan
 * @property Organisasi $organisasi
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
            [['organisasi_id', 'jabatan_id'], 'integer'],
            [['peran'], 'string'],
            [['tanggal_mulai', 'tanggal_selesai'], 'safe'],
            [['nim'], 'string', 'max' => 25],
            [['is_aktif'], 'string', 'max' => 1],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::className(), 'targetAttribute' => ['nim' => 'nim_mhs']],
            [['jabatan_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganisasiJabatan::className(), 'targetAttribute' => ['jabatan_id' => 'id']],
            [['organisasi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organisasi::className(), 'targetAttribute' => ['organisasi_id' => 'id']],
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
            'is_aktif' => 'Is Aktif',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
        ];
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
     * Gets query for [[Organisasi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisasi()
    {
        return $this->hasOne(Organisasi::className(), ['id' => 'organisasi_id']);
    }
}
