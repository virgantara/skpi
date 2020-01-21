<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_asrama".
 *
 * @property int $id
 * @property string $nama
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Kamar[] $kamars
 */
class Asrama extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_asrama';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKamars()
    {
        return $this->hasMany(Kamar::className(), ['asrama_id' => 'id']);
    }
}
