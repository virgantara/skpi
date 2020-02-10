<?php

use yii\db\Schema;
use yii\db\Migration;

class m200210_074526_riwayat_kamar extends Migration
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
                'nim'=> $this->string(25)->append(' CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL'),
                'kamar_id'=> $this->integer(11)->notNull(),
                'dari_kamar_id'=> $this->integer(11)->null()->defaultValue(null),
                'tanggal'=> $this->datetime()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
                'keterangan'=> $this->string(255)->null()->defaultValue(null),
                'created_at'=> $this->datetime()->null()->defaultExpression("CURRENT_TIMESTAMP"),
                'updated_at'=> $this->timestamp()->null()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );
        $this->createIndex('erp_riwayat_kamar_ibfk_1','{{%riwayat_kamar}}',['nim'],false);
        $this->createIndex('kamar_id','{{%riwayat_kamar}}',['kamar_id'],false);
        $this->createIndex('dari_kamar_id','{{%riwayat_kamar}}',['dari_kamar_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('erp_riwayat_kamar_ibfk_1', '{{%riwayat_kamar}}');
        $this->dropIndex('kamar_id', '{{%riwayat_kamar}}');
        $this->dropIndex('dari_kamar_id', '{{%riwayat_kamar}}');
        $this->dropTable('{{%riwayat_kamar}}');
    }
}
