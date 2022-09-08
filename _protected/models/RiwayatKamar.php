<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_riwayat_kamar".
 *
 * @property int $id
 * @property string|null $nim
 * @property int $kamar_id
 * @property int|null $dari_kamar_id
 * @property string $tanggal
 * @property string|null $keterangan
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Kamar $kamar
 * @property Kamar $dariKamar
 * @property SimakMastermahasiswa $nim0
 */
class RiwayatKamar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_riwayat_kamar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kamar_id'], 'required'],
            [['kamar_id', 'dari_kamar_id'], 'integer'],
            [['tanggal', 'created_at', 'updated_at'], 'safe'],
            [['nim'], 'string', 'max' => 25],
            [['keterangan'], 'string', 'max' => 255],
            [['kamar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kamar::className(), 'targetAttribute' => ['kamar_id' => 'id']],
            [['dari_kamar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kamar::className(), 'targetAttribute' => ['dari_kamar_id' => 'id']],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::className(), 'targetAttribute' => ['nim' => 'nim_mhs']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nim' => 'Nim',
            'kamar_id' => 'Kamar ID',
            'dari_kamar_id' => 'Dari Kamar ID',
            'tanggal' => 'Tanggal',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKamar()
    {
        return $this->hasOne(Kamar::className(), ['id' => 'kamar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDariKamar()
    {
        return $this->hasOne(Kamar::className(), ['id' => 'dari_kamar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNim0()
    {
        return $this->hasOne(SimakMastermahasiswa::className(), ['nim_mhs' => 'nim']);
    }
}
