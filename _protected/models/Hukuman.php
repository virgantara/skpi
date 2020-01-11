<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_hukuman".
 *
 * @property int $id
 * @property int $kategori_id
 * @property string $nama
 * @property string $created_at
 * @property string $updated_at
 *
 * @property KategoriHukuman $kategori
 * @property RiwayatHukuman[] $riwayatHukumen
 */
class Hukuman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_hukuman';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori_id', 'nama'], 'required'],
            [['kategori_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nama'], 'string', 'max' => 255],
            [['kategori_id'], 'exist', 'skipOnError' => true, 'targetClass' => KategoriHukuman::className(), 'targetAttribute' => ['kategori_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kategori_id' => 'Kategori ID',
            'nama' => 'Nama',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKategori()
    {
        return $this->hasOne(KategoriHukuman::className(), ['id' => 'kategori_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRiwayatHukumen()
    {
        return $this->hasMany(RiwayatHukuman::className(), ['hukuman_id' => 'id']);
    }
}
