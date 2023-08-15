<?php

use yii\db\Schema;
use yii\db\Migration;

class m230802_023504_update extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {

        $this->addColumn('{{%simkatmawa_mahasiswa}}', 'simkatmawa_non_lomba_id', $this->integer());
        $this->addColumn('{{%simkatmawa_mahasiswa}}', 'nama', $this->string(200));
        $this->addColumn('{{%simkatmawa_mahasiswa}}', 'prodi', $this->string(200));
        $this->addColumn('{{%simkatmawa_mahasiswa}}', 'kampus', $this->string(200));

        $this->addForeignKey('fk_erp_simkatmawa_mahasiswa_simkatmawa_non_lomba_id',
            '{{%simkatmawa_mahasiswa}}','simkatmawa_non_lomba_id',
            '{{%simkatmawa_non_lomba}}','id',
            'CASCADE','CASCADE'
         );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_erp_simkatmawa_mahasiswa_simkatmawa_non_lomba_id', '{{%simkatmawa_mahasiswa}}');
        $this->dropColumn('{{%simkatmawa_mahasiswa}}', 'simkatmawa_non_lomba_id');
        $this->dropColumn('{{%simkatmawa_mahasiswa}}', 'nama');
        $this->dropColumn('{{%simkatmawa_mahasiswa}}', 'prodi');
        $this->dropColumn('{{%simkatmawa_mahasiswa}}', 'kampus');
    }
}
