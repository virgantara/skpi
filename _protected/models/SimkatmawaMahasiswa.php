<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_simkatmawa_mahasiswa".
 *
 * @property int $id
 * @property int|null $simkatmawa_mandiri_id
 * @property int|null $simkatmawa_mbkm_id 
 * @property string|null $nim
 *
 * @property SimakMastermahasiswa $nim0
 * @property SimkatmawaMandiri $simkatmawaMandiri 		
 * @property SimkatmawaMbkm $simkatmawaMbkm
 * 
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
            [['simkatmawa_mandiri_id', 'simkatmawa_mbkm_id'], 'integer'],
            [['nim'], 'string', 'max' => 25],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::class, 'targetAttribute' => ['nim' => 'nim_mhs']],
            [['simkatmawa_mandiri_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimkatmawaMandiri::class, 'targetAttribute' => ['simkatmawa_mandiri_id' => 'id']],
            [['simkatmawa_mbkm_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimkatmawaMbkm::class, 'targetAttribute' => ['simkatmawa_mbkm_id' => 'id']],
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
            'simkatmawa_mbkm_id' => 'Simkatmawa Mbkm ID',
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

    /** 
     * Gets query for [[SimkatmawaMbkm]]. 
     * 
     * @return \yii\db\ActiveQuery 
     */
    public function getSimkatmawaMbkm()
    {
        return $this->hasOne(SimkatmawaMbkm::class, ['id' => 'simkatmawa_mbkm_id']);
    }
}
