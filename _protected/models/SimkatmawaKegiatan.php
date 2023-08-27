<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_simkatmawa_kegiatan".
 *
 * @property int $id
 * @property string|null $nama
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SimkatmawaNonLomba[] $simkatmawaNonLombas
 */
class SimkatmawaKegiatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_simkatmawa_kegiatan';
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
     * Gets query for [[SimkatmawaNonLombas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimkatmawaNonLombas()
    {
        return $this->hasMany(SimkatmawaNonLomba::class, ['simkatmawa_kegiatan_id' => 'id']);
    }
}
