<?php
class Migration_Add_priority_post_info_columns_to_categories extends CI_Migration
{
    public function up()
    {
        
        $fields = array(
        	'priority' => array(
                'type' => 'INT'),
        	'posted_info' => array(
        		'type' => 'TEXT')
        );
        
        $this->dbforge->add_column('store_categories', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('store_categories', $fields);
    }
}
