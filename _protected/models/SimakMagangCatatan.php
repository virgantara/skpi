<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_magang_catatan".
 *
 * @property string $id
 * @property string|null $magang_id
 * @property string|null $tanggal
 * @property string|null $rincian_kegiatan
 * @property string|null $evaluasi
 * @property string|null $tindak_lanjut
 * @property string|null $catatan_pembimbing
 * @property string|null $is_approved
 * @property string|null $updated_at
 * @property string|null $created_at
 *
 * @property SimakMagang $magang
 */
class SimakMagangCatatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_magang_catatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['tanggal', 'updated_at', 'created_at'], 'safe'],
            [['rincian_kegiatan', 'evaluasi', 'tindak_lanjut', 'catatan_pembimbing'], 'string'],
            [['id', 'magang_id'], 'string', 'max' => 50],
            [['is_approved'], 'string', 'max' => 1],
            [['id'], 'unique'],
            [['magang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMagang::class, 'targetAttribute' => ['magang_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'magang_id' => 'Magang ID',
            'tanggal' => 'Tanggal',
            'rincian_kegiatan' => 'Rincian Kegiatan',
            'evaluasi' => 'Evaluasi',
            'tindak_lanjut' => 'Tindak Lanjut',
            'catatan_pembimbing' => 'Catatan Pembimbing',
            'is_approved' => 'Is Approved',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Magang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMagang()
    {
        return $this->hasOne(SimakMagang::class, ['id' => 'magang_id']);
    }
}
