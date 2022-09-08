<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_pelanggaran".
 *
 * @property int $id
 * @property int $kategori_id
 * @property string $nama
 * @property string $created_at
 * @property string $updated_at
 *
 * @property KategoriPelanggaran $kategori
 */
class Pelanggaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_pelanggaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori_id', 'nama','kode'], 'required'],
            [['kode'], 'unique'],
            [['kategori_id'], 'integer'],
            [['created_at', 'updated_at','kode'], 'safe'],
            [['nama'], 'string', 'max' => 255],
            [['kategori_id'], 'exist', 'skipOnError' => true, 'targetClass' => KategoriPelanggaran::className(), 'targetAttribute' => ['kategori_id' => 'id']],
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
            'nama' => 'Nama Pelanggaran',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKategori()
    {
        return $this->hasOne(KategoriPelanggaran::className(), ['id' => 'kategori_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNamaKategori()
    {
        return $this->kategori->nama;
    }

}
