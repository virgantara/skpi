<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_asrama_raw".
 *
 * @property string $nim
 * @property string $nama
 * @property string $asrama_id
 * @property string $kamar
 * @property string $status_aktivitas
 * @property int $id
 */
class AsramaRaw extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_asrama_raw';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nim', 'nama', 'asrama_id', 'kamar', 'status_aktivitas'], 'required'],
            [['nim', 'nama', 'asrama_id', 'kamar', 'status_aktivitas'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nim' => 'Nim',
            'nama' => 'Nama',
            'asrama_id' => 'Asrama ID',
            'kamar' => 'Kamar',
            'status_aktivitas' => 'Status Aktivitas',
            'id' => 'ID',
        ];
    }
}
