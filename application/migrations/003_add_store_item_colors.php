<?php
class Migration_Add_store_item_colors extends CI_Migration
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
              'item_id' => array(
                 'type' => 'INT',
                 'unsigned' => true
              ),
              'color' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '120',
              )
           )
        );

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('store_item_colors');
    }

    public function down()
    {
        $this->dbforge->drop_table('store_item_colors');
    }
}