<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_layanan_surat_setting".
 *
 * @property int $id
 * @property string|null $file_header_path
 * @property string|null $file_sign_path
 * @property string|null $kode_fakultas
 */
class SimakLayananSuratSetting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_layanan_surat_setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_header_path', 'file_sign_path','file_footer_path'], 'string', 'max' => 500],
            [['kode_fakultas'], 'string', 'max' => 10],
            [['file_header_path','file_sign_path','file_footer_path'], 'file', 'skipOnEmpty' => true, 'maxSize' => 1024 * 1024 * 1, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file_header_path' => Yii::t('app', 'File Header Path'),
            'file_footer_path' => Yii::t('app', 'File Footer Path'),
            'file_sign_path' => Yii::t('app', 'File Sign Path'),
            'kode_fakultas' => Yii::t('app', 'Kode Fakultas'),
        ];
    }
}
