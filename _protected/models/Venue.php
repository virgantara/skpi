<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_venue".
 *
 * @property int $id
 * @property string $nama
 * @property int|null $kapasitas
 */
class Venue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_venue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama','kode'], 'required'],
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
            'kode' => 'Kode',
            'kapasitas' => 'Kapasitas',
        ];
    }
}
