<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property string $id
 * @property int|null $kegiatan_id
 * @property string|null $nama
 * @property string|null $venue
 * @property string|null $tanggal_mulai
 * @property string|null $tanggal_selesai
 * @property string|null $penyelenggara
 * @property string|null $tingkat
 * @property string|null $url
 * @property string|null $priority
 * @property string|null $status 0 : not started, 1 : on progres, 2: finished, 3: postponed, 4: canceled
 *
 * @property SimakKegiatan $kegiatan
 * @property SimakKegiatanMahasiswa[] $simakKegiatanMahasiswas
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['kegiatan_id'], 'integer'],
            [['tanggal_mulai', 'tanggal_selesai'], 'safe'],
            [['id'], 'string', 'max' => 20],
            [['nama', 'venue', 'penyelenggara', 'url'], 'string', 'max' => 255],
            [['tingkat', 'priority'], 'string', 'max' => 15],
            [['status'], 'string', 'max' => 1],
            [['id'], 'unique'],
            [['kegiatan_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKegiatan::className(), 'targetAttribute' => ['kegiatan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kegiatan_id' => 'Activity',
            'nama' => 'Event\'s Name',
            'venue' => 'Venue',
            'tanggal_mulai' => 'Start Date',
            'tanggal_selesai' => 'End Date',
            'penyelenggara' => 'Organizer',
            'tingkat' => 'Level',
            'url' => 'URL',
            'priority' => 'Priority',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Kegiatan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKegiatan()
    {
        return $this->hasOne(SimakKegiatan::className(), ['id' => 'kegiatan_id']);
    }

    /**
     * Gets query for [[SimakKegiatanMahasiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakKegiatanMahasiswas()
    {
        return $this->hasMany(SimakKegiatanMahasiswa::className(), ['event_id' => 'id']);
    }
}