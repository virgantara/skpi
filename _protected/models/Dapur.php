<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_dapur".
 *
 * @property int $id
 * @property string $nama
 * @property int $kapasitas
 * @property int|null $kampus
 *
 * @property SimakKampus $kampus0
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
            [['kapasitas', 'kampus'], 'integer'],
            [['nama'], 'string', 'max' => 255],
            [['kampus'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKampus::className(), 'targetAttribute' => ['kampus' => 'id']],
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
            'kampus' => 'Kampus',
        ];
    }

    /**
     * Gets query for [[Kampus0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKampus0()
    {
        return $this->hasOne(SimakKampus::className(), ['id' => 'kampus']);
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
