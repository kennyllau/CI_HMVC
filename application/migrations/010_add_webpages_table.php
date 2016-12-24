<?php
class Migration_Add_webpages_table extends CI_Migration
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
              'page_url' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '255',
              ),
              'page_title' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '255',
              ),
              'page_keywords' => array(
                 'type' => 'TEXT',
              ),
              'page_description' => array(
                 'type' => 'TEXT',
              ),
              'headline' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '255',
              ),
              'page_content' => array(
                 'type' => 'TEXT',
              )
           )
        );

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('webpages');
    }

    public function down()
    {
        $this->dbforge->drop_table('webpages');
    }
}