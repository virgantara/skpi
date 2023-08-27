<?php

use yii\db\Schema;
use yii\db\Migration;

class m230802_023505_Relations extends Migration
{

    public function init()
    {
       $this->db = 'db';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk_erp_mbkm_pertukaran_pelajar_nim',
            '{{%mbkm_pertukaran_pelajar}}','nim',
            '{{%simak_mastermahasiswa}}','nim_mhs',
            'CASCADE','CASCADE'
         );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_erp_mbkm_pertukaran_pelajar_nim', '{{%mbkm_pertukaran_pelajar}}');
    }
}
