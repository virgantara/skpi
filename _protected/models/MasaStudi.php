<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masa_studi".
 *
 * @property string $id
 * @property int $masa_studi
 * @property int $batas_masa_studi
 * @property int $jenjang_id
 *
 * @property SimakPilihan $jenjang
 */
class MasaStudi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masa_studi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jenjang_id'], 'required'],
            [['masa_studi', 'batas_masa_studi', 'jenjang_id'], 'integer'],
            [['id'], 'string', 'max' => 100],
            [['id'], 'unique'],
            [['jenjang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakPilihan::class, 'targetAttribute' => ['jenjang_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'masa_studi' => 'Masa Studi',
            'batas_masa_studi' => 'Batas Masa Studi',
            'jenjang_id' => 'Jenjang ID',
        ];
    }

    /**
     * Gets query for [[Jenjang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJenjang()
    {
        return $this->hasOne(SimakPilihan::class, ['id' => 'jenjang_id']);
    }
}
