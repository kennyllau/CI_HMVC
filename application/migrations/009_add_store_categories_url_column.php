<?php
class Migration_Add_store_categories_url_column extends CI_Migration
{
    public function up()
    {
        
        $fields = array(
        	'category_url' => array(
                'type' => 'VARCHAR',
                'constraint' => '255')
        );
        
        $this->dbforge->add_column('store_categories', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('store_categories', $fields);
    }
}
