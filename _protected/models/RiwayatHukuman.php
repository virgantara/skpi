<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_riwayat_hukuman".
 *
 * @property int $id
 * @property int $pelanggaran_id
 * @property string $created_at
 * @property string $updated_at
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
            [['pelanggaran_id'], 'required'],
            [['pelanggaran_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
