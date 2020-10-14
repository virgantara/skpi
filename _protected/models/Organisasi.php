<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_organisasi".
 *
 * @property int $id
 * @property string $nama
 * @property string|null $tingkat 1=lokal, 2=nasional,3=internasional,4=dalam kampus
 * @property string|null $instansi
 *
 * @property OrganisasiMahasiswa[] $organisasiMahasiswas
 */
class Organisasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_organisasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama', 'instansi'], 'string', 'max' => 255],
            [['tingkat'], 'string', 'max' => 1],
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
            'tingkat' => 'Tingkat',
            'instansi' => 'Instansi',
        ];
    }

    /**
     * Gets query for [[OrganisasiMahasiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisasiMahasiswas()
    {
        return $this->hasMany(OrganisasiMahasiswa::className(), ['organisasi_id' => 'id']);
    }
}
