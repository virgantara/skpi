<?php

use yii\db\Schema;
use yii\db\Migration;

class m200205_164102_riwayat_kamar extends Migration
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
            '{{%riwayat_kamar}}',
            [
                'id'=> $this->primaryKey(11),
                'nim'=> $this->integer(30)->notNull(),
                'kamar_id'=> $this->integer(10)->notNull(),
                'tanggal'=> $this->datetime()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
                'status'=> $this->string(5)->notNull(),
                'created_at'=> $this->datetime()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

        $this->batchInsert('{{%riwayat_kamar}}', 
            ['nim','kamar_id', 'tanggal', 'status'],
            [
                ['372016611508', '1', '2020-02-06 10:00:00', 'P'],
                ['372016611508', '2', '2020-02-06 10:00:00', 'S'],
                ['372016611508', '3', '2020-02-06 10:00:00', 'K'],
                ['372016611508', '4', '2020-02-06 10:00:00', 'P'],
            ]
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%riwayat_kamar}}');
    }
}
