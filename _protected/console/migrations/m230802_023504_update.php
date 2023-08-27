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

        $this->addColumn('{{%simkatmawa_mbkm}}', 'prodi_id', $this->integer());
        $this->addColumn('{{%simkatmawa_mandiri}}', 'prodi_id', $this->integer());
        $this->addColumn('{{%simkatmawa_non_lomba}}', 'prodi_id', $this->integer());
        $this->addColumn('{{%simkatmawa_belmawa}}', 'prodi_id', $this->integer());

        $this->addForeignKey('fk_erp_simkatmawa_mahasiswa_simkatmawa_non_lomba_id',
            '{{%simkatmawa_mahasiswa}}','simkatmawa_non_lomba_id',
            '{{%simkatmawa_non_lomba}}','id',
            'CASCADE','CASCADE'
         );

        $this->addForeignKey(
            'fk_erp_simkatmawa_mbkm_prodi_id',
            '{{%simkatmawa_mbkm}}',
            'prodi_id',
            'simak_masterprogramstudi',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_erp_simkatmawa_mandiri_prodi_id',
            '{{%simkatmawa_mandiri}}',
            'prodi_id',
            'simak_masterprogramstudi',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_erp_simkatmawa_non_lomba_prodi_id',
            '{{%simkatmawa_non_lomba}}',
            'prodi_id',
            'simak_masterprogramstudi',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_erp_simkatmawa_belmawa_prodi_id',
            '{{%simkatmawa_belmawa}}',
            'prodi_id',
            'simak_masterprogramstudi',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_erp_simkatmawa_mahasiswa_simkatmawa_non_lomba_id', '{{%simkatmawa_mahasiswa}}');
        
        $this->dropForeignKey('fk_erp_simkatmawa_mbkm_prodi_id', '{{%simkatmawa_mbkm}}');
        $this->dropForeignKey('fk_erp_simkatmawa_mandiri_prodi_id', '{{%simkatmawa_mandiri}}');
        $this->dropForeignKey('fk_erp_simkatmawa_non_lomba_prodi_id', '{{%simkatmawa_non_lomba}}');
        $this->dropForeignKey('fk_erp_simkatmawa_belmawa_prodi_id', '{{%simkatmawa_belmawa}}');
        
        $this->dropColumn('{{%simkatmawa_mahasiswa}}', 'simkatmawa_non_lomba_id');
        $this->dropColumn('{{%simkatmawa_mahasiswa}}', 'nama');
        $this->dropColumn('{{%simkatmawa_mahasiswa}}', 'prodi');
        $this->dropColumn('{{%simkatmawa_mahasiswa}}', 'kampus');

        $this->dropColumn('{{%simkatmawa_mbkm}}', 'prodi_id');
        $this->dropColumn('{{%simkatmawa_mandiri}}', 'prodi_id');
        $this->dropColumn('{{%simkatmawa_non_lomba}}', 'prodi_id');
        $this->dropColumn('{{%simkatmawa_belmawa}}', 'prodi_id');

    }
}
