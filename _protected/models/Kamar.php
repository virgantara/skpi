<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_kamar".
 *
 * @property int $id
 * @property string $nama
 * @property int $asrama_id
 * @property int $kapasitas
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Asrama $asrama
 * @property SimakMastermahasiswa[] $simakMastermahasiswas
 */
class Kamar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_kamar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'asrama_id'], 'required'],
            [['asrama_id', 'kapasitas'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nama'], 'string', 'max' => 255],
            [['asrama_id'], 'exist', 'skipOnError' => true, 'targetClass' => Asrama::className(), 'targetAttribute' => ['asrama_id' => 'id']],
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
            'asrama_id' => 'Asrama ID',
            'kapasitas' => 'Kapasitas',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsrama()
    {
        return $this->hasOne(Asrama::className(), ['id' => 'asrama_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimakMastermahasiswas()
    {
        return $this->hasMany(SimakMastermahasiswa::className(), ['kamar_id' => 'id']);
    }

    public function getNamaAsrama()
    {
        return $this->asrama->nama;
    }
}
