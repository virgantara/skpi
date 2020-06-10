<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_dapur".
 *
 * @property int $id
 * @property string $nama
 * @property int $kapasitas
 *
 * @property SimakMastermahasiswa[] $simakMastermahasiswas
 */
class Dapur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_dapur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'kapasitas'], 'required'],
            [['kapasitas'], 'integer'],
            [['nama'], 'string', 'max' => 255],
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
            'kapasitas' => 'Kapasitas',
        ];
    }

    /**
     * Gets query for [[SimakMastermahasiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakMastermahasiswas()
    {
        return $this->hasMany(SimakMastermahasiswa::className(), ['dapur_id' => 'id']);
    }
}
