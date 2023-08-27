<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_simkatmawa_rekognisi".
 *
 * @property int $id
 * @property string|null $nama
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SimkatmawaMandiri[] $simkatmawaMandiris
 */
class SimkatmawaRekognisi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_simkatmawa_rekognisi';
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
     * Gets query for [[SimkatmawaMandiris]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimkatmawaMandiris()
    {
        return $this->hasMany(SimkatmawaMandiri::class, ['simkatmawa_rekognisi_id' => 'id']);
    }
}
