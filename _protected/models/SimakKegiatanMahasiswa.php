<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_kegiatan_mahasiswa".
 *
 * @property int $id
 * @property string $nim
 * @property int $id_jenis_kegiatan
 * @property int $id_kegiatan
 * @property string|null $event_id
 * @property int|null $nilai
 * @property string|null $waktu
 * @property string|null $keterangan
 * @property string|null $tema
 * @property string|null $instansi
 * @property string|null $bagian
 * @property string|null $bidang
 * @property string|null $nama_kegiatan_mahasiswa
 * @property string $tahun_akademik
 * @property string|null $semester
 * @property string|null $tahun
 * @property string|null $penilai
 * @property string|null $file
 * @property string|null $file_path
 * @property string|null $s3_path
 * @property int|null $is_approved
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Events $event
 * @property SimakJenisKegiatan $jenisKegiatan
 * @property SimakKegiatan $kegiatan
 * @property SimakMastermahasiswa $nim0
 */
class SimakKegiatanMahasiswa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_kegiatan_mahasiswa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nim', 'id_jenis_kegiatan', 'id_kegiatan', 'tahun_akademik'], 'required'],
            [['id_jenis_kegiatan', 'id_kegiatan', 'nilai', 'is_approved'], 'integer'],
            [['waktu', 'created_at', 'updated_at','event_id'], 'safe'],
            [['keterangan', 'file'], 'string'],
            [['nim'], 'string', 'max' => 25],
            [['event_id'], 'string', 'max' => 20],
            [['tema', 'instansi', 'bagian', 'bidang', 'nama_kegiatan_mahasiswa', 'penilai', 'file_path', 's3_path'], 'string', 'max' => 255],
            [['tahun_akademik'], 'string', 'max' => 5],
            [['semester'], 'string', 'max' => 2],
            [['tahun'], 'string', 'max' => 4],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::className(), 'targetAttribute' => ['nim' => 'nim_mhs']],
            [['id_jenis_kegiatan'], 'exist', 'skipOnError' => true, 'targetClass' => SimakJenisKegiatan::className(), 'targetAttribute' => ['id_jenis_kegiatan' => 'id']],
            [['id_kegiatan'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKegiatan::className(), 'targetAttribute' => ['id_kegiatan' => 'id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Events::className(), 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nim' => 'Nim',
            'id_jenis_kegiatan' => 'Jenis Kegiatan',
            'id_kegiatan' => 'Kegiatan',
            'event_id' => 'Event',
            'nilai' => 'Nilai',
            'waktu' => 'Waktu',
            'keterangan' => 'Keterangan',
            'tema' => 'Tema',
            'instansi' => 'Instansi',
            'bagian' => 'Bagian',
            'bidang' => 'Bidang',
            'nama_kegiatan_mahasiswa' => 'Nama Kegiatan Mahasiswa',
            'tahun_akademik' => 'Tahun Akademik',
            'semester' => 'Semester',
            'tahun' => 'Tahun',
            'penilai' => 'Penilai',
            'file' => 'File',
            'file_path' => 'File Path',
            's3_path' => 'S3 Path',
            'is_approved' => 'Is Approved',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Events::className(), ['id' => 'event_id']);
    }

    /**
     * Gets query for [[JenisKegiatan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJenisKegiatan()
    {
        return $this->hasOne(SimakJenisKegiatan::className(), ['id' => 'id_jenis_kegiatan']);
    }

    /**
     * Gets query for [[Kegiatan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKegiatan()
    {
        return $this->hasOne(SimakKegiatan::className(), ['id' => 'id_kegiatan']);
    }

    /**
     * Gets query for [[Nim0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNim0()
    {
        return $this->hasOne(SimakMastermahasiswa::className(), ['nim_mhs' => 'nim']);
    }

    public static function getListHasilKompetensi($tahun_akademik, $nim, $kompetensi_id)
    {
        
        $query = SimakPilihan::find()->select(['id','label_en'])->where([
            'kode'=>'kompetensi',
            // 'id' => 491
        ]);

        if(!empty($kompetensi_id)){
            $query->andWhere(['value' => $kompetensi_id]);
        }
        
        $list_kompetensi = $query->all();
        $results = [];
        $bobot_kompetensi = [];
        $predikat = [];

        $kpt_id = null;
        foreach($list_kompetensi as $kpt)
        {
            $kpt_id = $kpt->id;
            $ikks = \app\models\SimakIndukKegiatanKompetensi::find()->where([
                'pilihan_id' => $kpt->id
            ])->all();
            $bobot = 0;
            foreach($ikks as $ikk)
            {
                foreach($ikk->induk->simakJenisKegiatans as $jk)
                {
                    $query = (new \yii\db\Query())
                    ->select(['km.*', 'keg.nama_kegiatan as kategori'])
                    ->from('simak_kegiatan_mahasiswa km')
                    ->join('JOIN', 'simak_kegiatan_kompetensi kk', 'kk.kegiatan_id = km.id_kegiatan')
                    ->join('JOIN', 'simak_kegiatan keg', 'keg.id = kk.kegiatan_id')
                    ->where([
                        'km.nim' => $nim,
                        'km.tahun_akademik' => $tahun_akademik,
                        'km.is_approved' => 1,
                        'kk.pilihan_id' => $kpt->id,
                        'km.id_jenis_kegiatan' => $jk->id
                    ]);

                    $results[] = $query->all();

                    $query = (new \yii\db\Query())
                    ->select(['SUM(kk.bobot) as bobot'])
                    ->from('simak_kegiatan_mahasiswa km')
                    ->join('JOIN', 'simak_kegiatan_kompetensi kk', 'kk.kegiatan_id = km.id_kegiatan')
                    ->where([
                        'km.nim' => $nim,
                        'km.tahun_akademik' => $tahun_akademik,
                        'km.is_approved' => 1,
                        'kk.pilihan_id' => $kpt->id,
                        'km.id_jenis_kegiatan' => $jk->id
                    ])
                    ->one();

                    $bobot += !empty($query['bobot']) ? $query['bobot'] : 0;
                }
            }

            $bobot_kompetensi[$kpt->id] = $bobot;

            $data = $bobot_kompetensi[$kpt->id];

            $nilai_akhir = 0;

            $induk = \app\models\SimakIndukKegiatanKompetensi::find()->where([
                'pilihan_id' => $kpt->id
            ])->one();

            if(!empty($induk))
            {
                $rekap_kompetensi = \app\models\SimakRekapKompetensi::find()->where([
                    'tahun' => $tahun_akademik,
                    'nim' => $nim,
                    'kompetensi_id' => $induk->id
                ])->one();

                $nilai_kumulatif = $data;
                $nilai_dosen = 0;
                if(!empty($rekap_kompetensi))
                {
                    $nilai_dosen = $rekap_kompetensi->nilai_dosen;
                    $nilai_kumulatif = $rekap_kompetensi->nilai_akhir;
                    
                }

                $max_range = \app\models\SimakKompetensiRangeNilai::getMaxKompetensi($induk->id);
                if(!empty($max_range))
                {

                    $nilai_akhir = $nilai_kumulatif > $max_range->nilai_maksimal ? $max_range->nilai_maksimal : $nilai_kumulatif;
                    $nilai_kumulatif = $nilai_akhir;
                }

                $range = \app\models\SimakKompetensiRangeNilai::getRangeNilai($nilai_kumulatif, $induk->id);


                if(!empty($range))
                {
                    $predikat[$kpt->id] = [
                        
                        'kompetensi' => $kpt->label_en,
                        'kompetensi_id' => $induk->id,
                        'label' => $range->label,
                        'color' => $range->color,
                        'nilai' => round($data,2),
                        'nilai_dosen' => round($nilai_dosen,2),
                        'nilai_akhir' => round($nilai_akhir,2),
                    ];
                }
            }
        }

        $hasil = [
            'results' => $results,
            'predikat' => $predikat,
            'kpt_id' => $kpt_id,
        ];

        return $hasil;
    }

    public static function getHasilKompetensi($tahun_akademik, $nim, $kompetensi_id=null)
    {
        
        $query = SimakPilihan::find()->select(['id','label_en'])->where([
            'kode'=>'kompetensi',
            // 'id' => 491
        ]);

        if(!empty($kompetensi_id)){
            $query->andWhere(['value' => $kompetensi_id]);
        }
        
        $list_kompetensi = $query->all();
        $total_bobot = [];
        foreach($list_kompetensi as $kpt)
        {

            $ikks = \app\models\SimakIndukKegiatanKompetensi::find()->where([
                'pilihan_id' => $kpt->id
            ])->all();
            $bobot = 0;
            foreach($ikks as $ikk)
            {
                foreach($ikk->induk->simakJenisKegiatans as $jk)
                {
                    $query = (new \yii\db\Query())
                    ->select(['SUM(kk.bobot) as bobot'])
                    ->from('simak_kegiatan_mahasiswa km')
                    ->join('JOIN', 'simak_kegiatan_kompetensi kk', 'kk.kegiatan_id = km.id_kegiatan')
                    ->where([
                        'km.nim' => $nim,
                        'km.tahun_akademik' => $tahun_akademik,
                        'km.is_approved' => 1,
                        'kk.pilihan_id' => $kpt->id,
                        'km.id_jenis_kegiatan' => $jk->id
                    ])
                    ->one();

                    $bobot += !empty($query['bobot']) ? $query['bobot'] : 0;
                }
            }

            

            $total_bobot[$kpt->id] = $bobot;//!empty($query['bobot']) ? $query['bobot'] : 0;
        }

        $predikat = [];

        if(!empty($total_bobot))
        {
            foreach($list_kompetensi as $kpt)
            {
                $data = $total_bobot[$kpt->id];

                $nilai_akhir = 0;

                $induk = \app\models\SimakIndukKegiatanKompetensi::find()->where([
                    'pilihan_id' => $kpt->id
                ])->one();

                if(!empty($induk))
                {
                    $rekap_kompetensi = \app\models\SimakRekapKompetensi::find()->where([
                        'tahun' => $tahun_akademik,
                        'nim' => $nim,
                        'kompetensi_id' => $induk->id
                    ])->one();

                    $nilai_kumulatif = $data;
                    $nilai_dosen = 0;
                    if(!empty($rekap_kompetensi))
                    {
                        $nilai_dosen = $rekap_kompetensi->nilai_dosen;
                        $nilai_kumulatif = $rekap_kompetensi->nilai_akhir;
                        
                    }

                    $max_range = \app\models\SimakKompetensiRangeNilai::getMaxKompetensi($induk->id);
                    if(!empty($max_range))
                    {

                        $nilai_akhir = $nilai_kumulatif > $max_range->nilai_maksimal ? $max_range->nilai_maksimal : $nilai_kumulatif;
                        $nilai_kumulatif = $nilai_akhir;
                    }

                    $range = \app\models\SimakKompetensiRangeNilai::getRangeNilai($nilai_kumulatif, $induk->id);


                    if(!empty($range))
                    {
                        $predikat[$kpt->id] = [
                            'kompetensi' => $kpt->label_en,
                            'kompetensi_id' => $induk->id,
                            'label' => $range->label,
                            'color' => $range->color,
                            'nilai' => round($data,2),
                            'nilai_dosen' => round($nilai_dosen,2),
                            'nilai_akhir' => round($nilai_akhir,2),
                        ];
                    }
                }
            }
        }

        return $predikat;
    } 
}
