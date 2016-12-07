<?php
class Migration_Add_store_accounts_table extends CI_Migration
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
              'first_name' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '120',
              ),
              'last_name' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '65',
              ),
              'company' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '150',
              ),
              'address1' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '255',
              ),
              'address2' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '255',
              ),
              'city' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '50',
              ),
              'state' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '50',
              ),
              'postal_code' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '50',
              ),
              'phone_number' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '30',
              ),
              'email' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '65',
              ),
              'date_made' => array(
                 'type' => 'INT',
                 'constraint' => '11',
              ),
              'password' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '255',
              )
           )
        );

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('store_accounts');
    }

    public function down()
    {
        $this->dbforge->drop_table('store_accounts');
    }
}