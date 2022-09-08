<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_organisasi_jabatan".
 *
 * @property int $id
 * @property string $nama
 *
 * @property OrganisasiMahasiswa[] $organisasiMahasiswas
 */
class OrganisasiJabatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_organisasi_jabatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
        ];
    }

    /**
     * Gets query for [[OrganisasiMahasiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisasiMahasiswas()
    {
        return $this->hasMany(OrganisasiMahasiswa::className(), ['jabatan_id' => 'id']);
    }
}
