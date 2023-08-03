<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_mbkm_jenis".
 *
 * @property int $id
 * @property string|null $nama
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Mbkm[] $mbkms
 */
class MbkmJenis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_mbkm_jenis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['nama'], 'string', 'max' => 150],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Mbkms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMbkms()
    {
        return $this->hasMany(Mbkm::class, ['mbkm_jenis_id' => 'id']);
    }
}
