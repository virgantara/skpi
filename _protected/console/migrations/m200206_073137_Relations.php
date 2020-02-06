<?php

use yii\db\Schema;
use yii\db\Migration;

class m200206_073137_Relations extends Migration
{

    public function init()
    {
       $this->db = 'db';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk_erp_riwayat_kamar_nim',
            '{{%riwayat_kamar}}','nim',
            '{{simak_mastermahasiswa}}','nim_mhs',
            'CASCADE','CASCADE'
         );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_erp_riwayat_kamar_nim', '{{%riwayat_kamar}}');
    }
}
