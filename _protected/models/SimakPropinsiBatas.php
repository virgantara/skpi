<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_propinsi_batas".
 *
 * @property int $id
 * @property int|null $kode_prop
 * @property float|null $latitude
 * @property float|null $longitude
 *
 * @property SimakPropinsi $kodeProp
 */
class SimakPropinsiBatas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_propinsi_batas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_prop'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['kode_prop'], 'exist', 'skipOnError' => true, 'targetClass' => SimakPropinsi::className(), 'targetAttribute' => ['kode_prop' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_prop' => 'Kode Prop',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    /**
     * Gets query for [[KodeProp]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeProp()
    {
        return $this->hasOne(SimakPropinsi::className(), ['id' => 'kode_prop']);
    }
}
