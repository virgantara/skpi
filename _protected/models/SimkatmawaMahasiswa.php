<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_simkatmawa_mahasiswa".
 *
 * @property int $id
 * @property int|null $simkatmawa_mandiri_id
 * @property string|null $nim
 *
 * @property SimakMastermahasiswa $nim0
 * @property SimkatmawaMandiri $simkatmawaMandiri
 */
class SimkatmawaMahasiswa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_simkatmawa_mahasiswa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['simkatmawa_mandiri_id'], 'integer'],
            [['nim'], 'string', 'max' => 25],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::class, 'targetAttribute' => ['nim' => 'nim_mhs']],
            [['simkatmawa_mandiri_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimkatmawaMandiri::class, 'targetAttribute' => ['simkatmawa_mandiri_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'simkatmawa_mandiri_id' => 'Simkatmawa Mandiri ID',
            'nim' => 'Nim',
        ];
    }

    /**
     * Gets query for [[Nim0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNim0()
    {
        return $this->hasOne(SimakMastermahasiswa::class, ['nim_mhs' => 'nim']);
    }

    /**
     * Gets query for [[SimkatmawaMandiri]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimkatmawaMandiri()
    {
        return $this->hasOne(SimkatmawaMandiri::class, ['id' => 'simkatmawa_mandiri_id']);
    }
}
