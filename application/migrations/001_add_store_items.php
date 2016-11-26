<?php
class Migration_Add_store_items extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(
           array(
              'id' => array(
                 'type' => 'INT',
                 'unsigned' => true,
                 'auto_increment' => true
              ),
              'item_title' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '255',
              ),
              'item_url' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '255',
              ),
              'item_price' => array(
                 'type' => 'DECIMAL',
                 'constraint' => '7,2',
              ),
              'item_description' => array(
                 'type' => 'TEXT',
              ),
              'big_pic' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '255',
              ),
              'small_pic' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '255',
              ),
              'was_price' => array(
                 'type' => 'DECIMAL',
                 'constraint' => '7,2',
              )
           )
        );

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('store_items');
    }

    public function down()
    {
        $this->dbforge->drop_table('store_items');
    }
}