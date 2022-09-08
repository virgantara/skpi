<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_riwayat_hukuman".
 *
 * @property int $id
 * @property int $pelanggaran_id
 * @property int $hukuman_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Hukuman $hukuman
 * @property RiwayatPelanggaran $pelanggaran
 */
class RiwayatHukuman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_riwayat_hukuman';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pelanggaran_id', 'hukuman_id'], 'required'],
            [['pelanggaran_id', 'hukuman_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['hukuman_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hukuman::className(), 'targetAttribute' => ['hukuman_id' => 'id']],
            [['pelanggaran_id'], 'exist', 'skipOnError' => true, 'targetClass' => RiwayatPelanggaran::className(), 'targetAttribute' => ['pelanggaran_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pelanggaran_id' => 'Pelanggaran ID',
            'hukuman_id' => 'Hukuman ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHukuman()
    {
        return $this->hasOne(Hukuman::className(), ['id' => 'hukuman_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelanggaran()
    {
        return $this->hasOne(RiwayatPelanggaran::className(), ['id' => 'pelanggaran_id']);
    }
}
