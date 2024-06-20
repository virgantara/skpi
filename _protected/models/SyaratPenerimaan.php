<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "syarat_penerimaan".
 *
 * @property int $id
 * @property int $jenjang_id
 * @property string $keterangan
 * @property string $keterangan_en
 *
 * @property SimakPilihan $jenjang
 */
class SyaratPenerimaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'syarat_penerimaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenjang_id', 'keterangan', 'keterangan_en'], 'required'],
            [['jenjang_id'], 'integer'],
            [['keterangan', 'keterangan_en'], 'string'],
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
            'jenjang_id' => 'Jenjang ID',
            'keterangan' => 'Keterangan',
            'keterangan_en' => 'Keterangan En',
        ];
    }

    public function getNamaJenjang()
    {
        return (!empty($this->jenjang) ? $this->jenjang->label : null);
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
