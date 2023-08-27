<?php

use yii\db\Migration;

/**
 * Class m230827_154706_add_column
 */
class m230827_154706_add_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%simkatmawa_mandiri}}', 'keterangan', $this->string(200));
        $this->addColumn('{{%simkatmawa_mandiri}}', 'level_id', $this->integer());
        $this->addColumn('{{%simkatmawa_mandiri}}', 'apresiasi_id', $this->integer());

        $this->createTable('{{%simkatmawa_level}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string(150),
            'urutan' => $this->integer(),
            'created_at' => $this->timestamp()->null()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->null()->defaultExpression("CURRENT_TIMESTAMP"),
        ]);
        $this->createTable('{{%simkatmawa_apresiasi}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string(150),
            'urutan' => $this->integer(),
            'created_at' => $this->timestamp()->null()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->null()->defaultExpression("CURRENT_TIMESTAMP"),
        ]);

        $this->addForeignKey('fk_erp_simkatmawa_level_simkatmawa_mandiri',
            '{{%simkatmawa_mandiri}}','level_id',
            '{{%simkatmawa_level}}','id',
            'CASCADE','CASCADE'
         );

         $this->addForeignKey('fk_erp_simkatmawa_apresiasi_simkatmawa_mandiri',
             '{{%simkatmawa_mandiri}}','apresiasi_id',
             '{{%simkatmawa_apresiasi}}','id',
             'CASCADE','CASCADE'
          );


        $data = [
			1 => 'Juara 1',
			2 => 'Juara 2',
			3 => 'Juara 3',
			4 => 'Harapan',
			5 => 'Partisipasi / Delegasi / Peserta Kejuaraan',
        ];

        foreach ($data as $key => $value) {
            $this->insert('{{%simkatmawa_apresiasi}}', [
                'nama' => $value,
                'urutan' => $key,
            ]);
        }

        $data = [
            1 => 'Provinsi',
            2 => 'Wilayah',
            3 => 'Nasional',
            4 => 'Internasional',
        ];

        foreach ($data as $key => $value) {
            $this->insert('{{%simkatmawa_level}}', [
                'nama' => $value,
                'urutan' => $key,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {        
        $this->dropForeignKey('fk_erp_simkatmawa_level_simkatmawa_mandiri', '{{%simkatmawa_mandiri}}');
        $this->dropForeignKey('fk_erp_simkatmawa_apresiasi_simkatmawa_mandiri', '{{%simkatmawa_mandiri}}');

        $this->dropTable('{{%simkatmawa_apresiasi}}');
        $this->dropTable('{{%simkatmawa_level}}');

        $this->dropColumn('{{%simkatmawa_mandiri}}', 'keterangan');
        $this->dropColumn('{{%simkatmawa_mandiri}}', 'level_id');
        $this->dropColumn('{{%simkatmawa_mandiri}}', 'apresiasi_id');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230827_154706_add_column cannot be reverted.\n";

        return false;
    }
    */
}
