<?php

use yii\db\Schema;
use yii\db\Migration;

class m230802_023504_mbkm_pertukaran_pelajar extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->createTable('{{%user_prodi}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'prodi_id' => $this->integer(),
        ]);

        $this->createTable('{{%simkatmawa_mbkm}}', [
            'id' => $this->primaryKey(),
            'nim' => $this->string(25)->notNull(),
            'simkatmawa_mbkm_jenis_id' => $this->integer()->notNull(),
            'nama_program' => $this->string(255)->notNull(),
            'tempat_pelaksanaan' => $this->string(255)->notNull(),
            'tanggal_mulai' => $this->date()->null()->defaultValue(null),
            'tanggal_selesai' => $this->date()->null()->defaultValue(null),
            'penyelenggara' => $this->string(255)->null()->defaultValue(null),
            'level' => $this->integer()->null()->defaultValue(null),
            'apresiasi' => $this->integer()->null()->defaultValue(null),
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

        $this->createTable('{{%simkatmawa_non_lomba}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'nama_kegiatan' => $this->string(255)->notNull(),
            'simkatmawa_kegiatan_id' => $this->integer(), // master
            'tanggal_mulai' => $this->date()->null()->defaultValue(null),
            'tanggal_selesai' => $this->date()->null()->defaultValue(null),
            'laporan_path' => $this->string(255)->null()->defaultValue(null),
            'url_kegiatan' => $this->string(255),
            'foto_kegiatan_path' => $this->string(255)->null()->defaultValue(null),
            'created_at' => $this->timestamp()->null()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->null()->defaultExpression("CURRENT_TIMESTAMP"),
        ]);

        $this->createTable('{{%simkatmawa_mandiri}}', [
            'id' => $this->primaryKey(),
            'nim' => $this->string(25)->notNull(),
            'nama_kegiatan' => $this->string(255)->notNull(),
            'penyelenggara' => $this->string(255),
            'tempat_pelaksanaan' => $this->string(255),
            'simkatmawa_rekognisi_id' => $this->integer(),       // master
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

        $this->createTable('{{%simkatmawa_kegiatan}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string(150),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createTable('{{%simkatmawa_rekognisi}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string(150),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Add foreign key for 'user_prodi' table
        $this->addForeignKey('fk-user_prodi-user_id', '{{%user_prodi}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        
        // Add foreign key for 'simkatmawa_non_lomba' table
        $this->addForeignKey('fk-simkatmawa_non_lomba-simkatmawa_kegiatan_id', '{{%simkatmawa_non_lomba}}', 'simkatmawa_kegiatan_id', '{{%simkatmawa_kegiatan}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-simkatmawa_non_lomba-user_id', '{{%simkatmawa_non_lomba}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        // Add foreign key for 'simkatmawa_mandiri' table
        $this->addForeignKey('fk-simkatmawa_mandiri-simkatmawa_rekognisi_id', '{{%simkatmawa_mandiri}}', 'simkatmawa_rekognisi_id', '{{%simkatmawa_rekognisi}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {

        // Drop foreign key for 'user_prodi' table
        $this->dropForeignKey('fk-user_prodi-user_id', '{{%user_prodi}}');

        // Drop foreign key for 'simkatmawa_non_lomba' table
        $this->dropForeignKey('fk-simkatmawa_non_lomba-simkatmawa_kegiatan_id', '{{%simkatmawa_non_lomba}}');
        $this->dropForeignKey('fk-simkatmawa_non_lomba-user_id', '{{%simkatmawa_non_lomba}}');

        // Drop foreign key for 'simkatmawa_mandiri' table
        $this->dropForeignKey('fk-simkatmawa_mandiri-simkatmawa_rekognisi_id', '{{%simkatmawa_mandiri}}');

        // // Drop foreign key for 'simkatmawa_mbkm' table
        // $this->dropForeignKey('fk-simkatmawa_mbkm-kategori_belmawa_id', '{{%simkatmawa_mbkm}}');
        // $this->dropForeignKey('fk-simkatmawa_mbkm-simkatmawa_mbkm_jenis_id', '{{%simkatmawa_mbkm}}');

        // $this->dropTable('{{%kategori_belmawa}}');
        $this->dropTable('{{%simkatmawa_rekognisi}}');
        $this->dropTable('{{%simkatmawa_mandiri}}');
        $this->dropTable('{{%simkatmawa_kegiatan}}');
        $this->dropTable('{{%simkatmawa_non_lomba}}');
        $this->dropTable('{{%simkatmawa_mbkm}}');
        $this->dropTable('{{%user_prodi}}');
    }
}
