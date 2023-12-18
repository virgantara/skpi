<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_syarat_bebas_asrama_mahasiswa".
 *
 * @property string $id
 * @property int $syarat_id
 * @property int $mhs_id
 * @property string|null $file_path
 * @property string|null $updated_at
 * @property string|null $created_at
 *
 * @property SimakMastermahasiswa $mhs
 * @property SimakSyaratBebasAsrama $syarat
 */
class SimakSyaratBebasAsramaMahasiswa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_syarat_bebas_asrama_mahasiswa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'syarat_id', 'mhs_id'], 'required'],
            [['syarat_id', 'mhs_id'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['id'], 'string', 'max' => 100],
            [['file_path'], 'string', 'max' => 500],
            [['id'], 'unique'],
            [['syarat_id', 'mhs_id'], 'unique', 'targetAttribute' => ['syarat_id', 'mhs_id'],'message' => 'You have uploaded this document before'],
            [['syarat_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakSyaratBebasAsrama::className(), 'targetAttribute' => ['syarat_id' => 'id']],
            [['mhs_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::className(), 'targetAttribute' => ['mhs_id' => 'id']],
            [['file_path'], 'file', 'skipOnEmpty' => true, 'extensions' => ['pdf'], 'maxSize' => 1024 * 1024 * 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'syarat_id' => Yii::t('app', 'Berkas'),
            'mhs_id' => Yii::t('app', 'Mhs ID'),
            'file_path' => Yii::t('app', 'Dokumen'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[Mhs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMhs()
    {
        return $this->hasOne(SimakMastermahasiswa::className(), ['id' => 'mhs_id']);
    }

    /**
     * Gets query for [[Syarat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSyarat()
    {
        return $this->hasOne(SimakSyaratBebasAsrama::className(), ['id' => 'syarat_id']);
    }
}
