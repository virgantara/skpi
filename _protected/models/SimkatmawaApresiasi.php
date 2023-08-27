<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_simkatmawa_apresiasi".
 *
 * @property int $id
 * @property string|null $nama
 * @property int|null $urutan
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SimkatmawaMandiri[] $simkatmawaMandiris
 */
class SimkatmawaApresiasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_simkatmawa_apresiasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['urutan'], 'integer'],
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
            'id' => Yii::t('app', 'ID'),
            'nama' => Yii::t('app', 'Nama'),
            'urutan' => Yii::t('app', 'Urutan'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[SimkatmawaMandiris]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimkatmawaMandiris()
    {
        return $this->hasMany(SimkatmawaMandiri::class, ['apresiasi_id' => 'id']);
    }
}
