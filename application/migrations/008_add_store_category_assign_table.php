<?php
class Migration_Add_store_category_assign_table extends CI_Migration
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
              'category_id' => array(
                 'type' => 'INT',
              ),
              'item_id' => array(
                 'type' => 'INT',
              )
           )
        );

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('store_category_assign');
    }

    public function down()
    {
        $this->dbforge->drop_table('store_category_assign');
    }
}