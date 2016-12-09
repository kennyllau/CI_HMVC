<?php
class Migration_Add_store_categories_table extends CI_Migration
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
              'category_title' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '255',
              ),
              'parent_category_id' => array(
                 'type' => 'INT',
              )
           )
        );

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('store_categories');
    }

    public function down()
    {
        $this->dbforge->drop_table('store_categories');
    }
}