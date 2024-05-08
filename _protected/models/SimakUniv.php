<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_univ".
 *
 * @property int $id
 * @property string|null $kode
 * @property string $nama
 * @property string $nama_en
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class SimakUniv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_univ';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'nama_en','header','header_en'], 'required'],
            [['nama', 'nama_en'], 'string'],
            [['created_at', 'updated_at','urutan'], 'safe'],
            [['kode'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode' => 'Kode',
            'header' => 'Kerangka',
            'header_en' => 'Framework',
            'nama' => 'Konten',
            'urutan' => 'Urutan',
            'nama_en' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
