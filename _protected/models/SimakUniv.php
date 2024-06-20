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
            [['pilihan_id'], 'required','on' => 'kkni'],
            [['nama', 'nama_en'], 'string'],
            [['created_at', 'updated_at','urutan','pilihan_id'], 'safe'],
            [['kode'], 'string', 'max' => 6],
            [['pilihan_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakPilihan::class, 'targetAttribute' => ['pilihan_id' => 'id']],
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
            'pilihan_id' => 'Jenjang',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getNamaJenjang(){

        return (!empty($this->pilihan) ? $this->pilihan->label : null);
        // $pilihan = SimakPilihan::find()->select(['id','label','label_en'])->where(['kode'=>'04','value'=>$this->kode_jenjang_studi])->one();

        // return $pilihan;
        
    }

    public function getPilihan()
    {
        return $this->hasOne(SimakPilihan::class, ['id' => 'pilihan_id']);
    }
}
