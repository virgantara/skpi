<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_syarat_bebas_asrama".
 *
 * @property int $id
 * @property string $nama
 * @property string $is_aktif
 *
 * @property SimakSyaratBebasAsramaMahasiswa[] $simakSyaratBebasAsramaMahasiswas
 */
class SimakSyaratBebasAsrama extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_syarat_bebas_asrama';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 200],
            [['is_aktif'], 'string', 'max' => 1],
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
            'is_aktif' => 'Is Aktif',
        ];
    }

    /**
     * Gets query for [[SimakSyaratBebasAsramaMahasiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakSyaratBebasAsramaMahasiswas()
    {
        return $this->hasMany(SimakSyaratBebasAsramaMahasiswa::class, ['syarat_id' => 'id']);
    }
}
