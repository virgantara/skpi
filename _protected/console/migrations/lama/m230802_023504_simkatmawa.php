<?php

use yii\db\Schema;
use yii\db\Migration;

class m230802_023504_simkatmawa extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {

        $this->createTable('{{%simkatmawa_mbkm}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'jenis_simkatmawa' => $this->string(150),
            'nama_program' => $this->string(255)->notNull(),
            'tempat_pelaksanaan' => $this->string(255)->notNull(),
            'tanggal_mulai' => $this->date()->null()->defaultValue(null),
            'tanggal_selesai' => $this->date()->null()->defaultValue(null),
            'penyelenggara' => $this->string(255)->null()->defaultValue(null),
            'level' => $this->integer()->null()->defaultValue(null),
            'judul_penelitian' => $this->string(255)->null()->defaultValue(null),
            'status_sks' => $this->integer()->null()->defaultValue(null),
            'sk_penerimaan_path' => $this->string(255)->null()->defaultValue(null),
            'surat_tugas_path' => $this->string(255)->null()->defaultValue(null),
            'rekomendasi_path' => $this->string(255)->null()->defaultValue(null),
            'khs_pt_path' => $this->string(255)->null()->defaultValue(null),
            'sertifikat_path' => $this->string(255)->null()->defaultValue(null),
            'laporan_path' => $this->string(255)->null()->defaultValue(null),
            'hasil_path' => $this->string(255)->null()->defaultValue(null),
            'hasil_jenis' => $this->integer(),
            'rekognisi_id' => $this->integer(),
            'kategori_pembinaan_id' => $this->integer(),
            'kategori_belmawa_id' => $this->integer(),
            'url_berita' => $this->string(255)->null()->defaultValue(null),
            'foto_penyerahan_path' => $this->string(255)->null()->defaultValue(null),
            'foto_kegiatan_path' => $this->string(255)->null()->defaultValue(null),
            'foto_karya_path' => $this->string(255)->null()->defaultValue(null),
            'created_at' => $this->timestamp()->null()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->null()->defaultExpression("CURRENT_TIMESTAMP"),
        ]);

        $this->createTable('{{%simkatmawa_mandiri}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'simkatmawa_rekognisi_id' => $this->integer(),       // master
            'jenis_simkatmawa' => $this->string(20),
            'nama_kegiatan' => $this->string(255)->notNull(),
            'penyelenggara' => $this->string(255),
            'tempat_pelaksanaan' => $this->string(255),
            'level' => $this->integer(),
            'apresiasi' => $this->integer(),
            'url_kegiatan' => $this->string(255),
            'tanggal_mulai' => $this->date()->null()->defaultValue(null),
            'tanggal_selesai' => $this->date()->null()->defaultValue(null),
            'sertifikat_path' => $this->string(255)->null()->defaultValue(null),
            'foto_penyerahan_path' => $this->string(255)->null()->defaultValue(null),
            'foto_kegiatan_path' => $this->string(255)->null()->defaultValue(null),
            'foto_karya_path' => $this->string(255)->null()->defaultValue(null),
            'surat_tugas_path' => $this->string(255)->null()->defaultValue(null),
            'laporan_path' => $this->string(255)->null()->defaultValue(null),
            'created_at' => $this->timestamp()->null()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->null()->defaultExpression("CURRENT_TIMESTAMP"),
        ]);

        $this->createTable('{{%simkatmawa_belmawa}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'simkatmawa_belmawa_kategori_id' => $this->integer(),       // master
            'jenis_simkatmawa' => $this->string(20),
            'nama_kegiatan' => $this->string(255)->notNull(),
            'peringkat' => $this->string(150),
            'keterangan' => $this->string(500),
            'tanggal_mulai' => $this->date()->null()->defaultValue(null),
            'tanggal_selesai' => $this->date()->null()->defaultValue(null),
            'url_kegiatan' => $this->string(255),
            'laporan_path' => $this->string(255)->null()->defaultValue(null),
            'created_at' => $this->timestamp()->null()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->null()->defaultExpression("CURRENT_TIMESTAMP"),
        ]);

        $this->createTable('{{%simkatmawa_belmawa_kategori}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string(150),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createTable('{{%simkatmawa_mahasiswa}}', [
            'id' => $this->primaryKey(),
            'simkatmawa_mbkm_id' => $this->integer(),
            'simkatmawa_mandiri_id' => $this->integer(),
            'simkatmawa_belmawa_id' => $this->integer(),
            'nim' => $this->string(25),
        ]);

        // Add foreign key for 'simkatmawa_mbkm' table
        $this->addForeignKey('fk-simkatmawa_mbkm-user_id', '{{%simkatmawa_mbkm}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        // Add foreign key for 'simkatmawa_mahasiswa' table
        $this->addForeignKey('fk-simkatmawa_mahasiswa-simkatmawa_mandiri_id', '{{%simkatmawa_mahasiswa}}', 'simkatmawa_mandiri_id', '{{%simkatmawa_mandiri}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-simkatmawa_mahasiswa-simkatmawa_mbkm_id', '{{%simkatmawa_mahasiswa}}', 'simkatmawa_mbkm_id', '{{%simkatmawa_mbkm}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-simkatmawa_mahasiswa-simkatmawa_belmawa_id', '{{%simkatmawa_mahasiswa}}', 'simkatmawa_belmawa_id', '{{%simkatmawa_belmawa}}', 'id', 'CASCADE', 'CASCADE');

        // Add foreign key for 'simkatmawa_mandiri' table
        $this->addForeignKey('fk-simkatmawa_mandiri-user_id', '{{%simkatmawa_mandiri}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-simkatmawa_mandiri-simkatmawa_rekognisi_id', '{{%simkatmawa_mandiri}}', 'simkatmawa_rekognisi_id', '{{%simkatmawa_rekognisi}}', 'id', 'CASCADE', 'CASCADE');

        // Add foreign key for 'simkatmawa_belmawa' table
        $this->addForeignKey('fk-simkatmawa_belmawa-user_id', '{{%simkatmawa_belmawa}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-simkatmawa_belmawa-simkatmawa_belmawa_kategori_id', '{{%simkatmawa_belmawa}}', 'simkatmawa_belmawa_kategori_id', '{{%simkatmawa_belmawa_kategori}}', 'id', 'CASCADE', 'CASCADE');

        $data = [
            1 => "Kompetisi Matematika dan IPA Perguruan Tinggi (KNMIPA PT)",
            2 => "Debat Bahasa Inggris/National University Debate Championship (NUDC)",
            3 => "Kompetisi Debat Mahasiswa Indonesia (KDMI)",
            4 => "Pemilihan Mahasiswa Berprestasi (PILMAPRES)",
            5 => "Program Kreativitas Mahasiswa (PKM) dan Pekan Ilmiah Mahasiswa Nasional (PIMNAS)",
            6 => "Kontes Robot Indonesia (KRI)",
            7 => "Kontes Robot Terbang Indonesia (KRTI)",
            8 => "Pagelaran Mahasiswa Bidang TIK (GEMASTIK)",
            9 => "Kontes Mobil Hemat Energi (KMHE)",
            10 => "Kompetisi Kapal Cepat Tak Berawak (KKCTB)",
            11 => "Kompetisi Jembatan Indonesia (KJI)",
            12 => "Kompetisi Bangunan Gedung Indonesia (KBGI)",
            13 => "Kompetisi Bisnis Manajemen Mahasiswa Indonesia (KBMI)",
            14 => "Ekspo Kewirausahaan Mahasiswa Indonesia (KMI)",
            15 => "Akselerasi Startup Mahasiswa Indonesia (ASMI)",
            16 => "Pekan Olahraga Mahasiswa Nasional (POMNAS)",
            17 => "Musabaqah Tilawatil Qur’an Mahasiswa Nasional (MTQMN)",
            18 => "Pentas Paduan Suara Gerejawi (PESPARAWI)",
            19 => "Pekan Seni Mahasiswa Tingkat Nasional (PEKSIMINAS)",
            20 => "Festival Film Mahasiswa Indonesia (FFMI)",
            21 => "Lomba Inovasi Digital Mahasiswa (LIDM)",
            22 => "Kompetisi Inovasi Bisnis Mahasiswa (KIBM)",
            23 => "Statistika Ria dan Festival Data Sains (Satria Data)",
            24 => "Medical Online Championship (MOC)",
            25 => "Program Holistik Pembinaan dan Pemberdayaan Desa (PHP2D)",
            26 => "Kompetisi Mahasiswa Nasional Bidang Bisnis Manajemen dan Keuangan (KBMK)",
            27 => "Program Kewirausahaan Vokasi (PKV)",
            28 => "Program Pemberdayaan Masyarakat Desa (P2MD)"
        ];

        foreach ($data as $key => $value) {
            $this->insert('{{%simkatmawa_belmawa_kategori}}', [
                'nama' => $value,
            ]);
        }
    }

    public function safeDown()
    {

        // Drop foreign key for 'simkatmawa_mbkm' table
        $this->dropForeignKey('fk-simkatmawa_mbkm-user_id', '{{%simkatmawa_mbkm}}');

        // Drop foreign key for 'simkatmawa_mahasiswa' table
        $this->dropForeignKey('fk-simkatmawa_mahasiswa-simkatmawa_mandiri_id', '{{%simkatmawa_mahasiswa}}');
        $this->dropForeignKey('fk-simkatmawa_mahasiswa-simkatmawa_mbkm_id', '{{%simkatmawa_mahasiswa}}');
        $this->dropForeignKey('fk-simkatmawa_mahasiswa-simkatmawa_belmawa_id', '{{%simkatmawa_mahasiswa}}');

        // Drop foreign key for 'simkatmawa_mandiri' table
        $this->dropForeignKey('fk-simkatmawa_mandiri-simkatmawa_rekognisi_id', '{{%simkatmawa_mandiri}}');
        $this->dropForeignKey('fk-simkatmawa_mandiri-user_id', '{{%simkatmawa_mandiri}}');

        // Drop foreign key for 'simkatmawa_belmawa' table
        $this->dropForeignKey('fk-simkatmawa_belmawa-simkatmawa_belmawa_kategori_id', '{{%simkatmawa_belmawa}}');
        $this->dropForeignKey('fk-simkatmawa_belmawa-user_id', '{{%simkatmawa_belmawa}}');

        $this->dropTable('{{%simkatmawa_belmawa_kategori}}');
        $this->dropTable('{{%simkatmawa_belmawa}}');
        $this->dropTable('{{%simkatmawa_mandiri}}');
        $this->dropTable('{{%simkatmawa_mbkm}}');
        $this->dropTable('{{%simkatmawa_mahasiswa}}');
    }
}
