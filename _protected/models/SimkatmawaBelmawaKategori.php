<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_simkatmawa_belmawa_kategori".
 *
 * @property int $id
 * @property string|null $nama
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SimkatmawaBelmawa[] $simkatmawaBelmawas
 */
class SimkatmawaBelmawaKategori extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_simkatmawa_belmawa_kategori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['nama'], 'string', 'max' => 150],
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
     * Gets query for [[SimkatmawaBelmawas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimkatmawaBelmawas()
    {
        return $this->hasMany(SimkatmawaBelmawa::class, ['simkatmawa_belmawa_kategori_id' => 'id']);
    }
}
