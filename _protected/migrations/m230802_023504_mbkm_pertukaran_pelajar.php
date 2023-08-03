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
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%mbkm_pertukaran_pelajar}}',
            [
                'id' => $this->primaryKey(),
                'nim' => $this->string(25)->notNull(),
                'mbkm_jenis_id' => $this->integer()->notNull(),
                'nama_program' => $this->string(255)->notNull(),
                'tempat_pelaksanaan' => $this->string(255)->notNull(),
                'tanggal_mulai' => $this->date()->null()->defaultValue(null),
                'tanggal_selesai' => $this->date()->null()->defaultValue(null),
                'level' => $this->integer()->null()->defaultValue(null),
                'status_sks' => $this->integer()->null()->defaultValue(null),
                'sk_penerimaan_path' => $this->string(255)->null()->defaultValue(null),
                'surat_tugas_path' => $this->string(255)->null()->defaultValue(null),
                'rekomendasi_path' => $this->string(255)->null()->defaultValue(null),
                'khs_pt_path' => $this->string(255)->null()->defaultValue(null),
                'sertifikat_path' => $this->string(255)->null()->defaultValue(null),
                'laporan_path' => $this->string(255)->null()->defaultValue(null),
                'created_at' => $this->timestamp()->null()->defaultExpression("CURRENT_TIMESTAMP"),
                'updated_at' => $this->timestamp()->null()->defaultExpression("CURRENT_TIMESTAMP"),
            ],
            $tableOptions
        );
        $this->createIndex('fk-mbkm_pertukaran_pelajar-nim', '{{%mbkm_pertukaran_pelajar}}', ['nim'], false);
    }

    public function safeDown()
    {
        $this->dropIndex('fk-mbkm_pertukaran_pelajar-nim', '{{%mbkm_pertukaran_pelajar}}');
        $this->dropTable('{{%mbkm_pertukaran_pelajar}}');
    }
}
