<?php
class Migration_Add_status_column_to_store_items extends CI_Migration
{
    public function up()
    {
        
        $fields = array(
        'status' => array(
                'type' => 'VARCHAR',
                'constraint' => '10')
        );
        
        $this->dbforge->add_column('store_items', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('store_items', 'status');
    }
}