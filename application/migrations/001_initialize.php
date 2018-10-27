<?php

class Migration_Initialize extends CI_Migration
{

    public function up()
    {
        $columns =  array(
           'id' => array(
              'type' => 'VARCHAR',
              'constraint' => 40
           ),
           'ip_address' => array(
            'type' => 'VARCHAR',
            'constraint' => 45
         ),
         'timestamp' => array(
          'type' => 'INT',
          'constraint' => 10
        ),
        'data' => array(
         'type' => 'BLOB'
        ),
        );

        $this->dbforge->add_field($columns);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('ci_session');

        $columns =  array(
            'product_id' => array(
               'type' => 'INT',
               'constraint' => 5,
               'unsigned' => true,
               'auto_increment' => true
            ),
            'product_name' => array(
               'type' => 'VARCHAR',
               'constraint' => '300',
            ),
            'product_description' => array(
               'type' => 'TEXT'
            ),
            'product_url' => array(
               'type' => 'VARCHAR',
               'constraint' => '500',
            ),
            'created_at' => array(
               'type' => 'TIMESTAMP'
            )
         );
 
         $this->dbforge->add_field($columns);
         $this->dbforge->add_key('product_id', TRUE);
         $this->dbforge->create_table('products');

         
        $columns =  array(
            'history_id' => array(
               'type' => 'INT',
               'constraint' => 5,
               'unsigned' => true,
               'auto_increment' => true
            ),
            'product_id' => array(
               'type' => 'INT',
               'constraint' => 5,
               'unsigned' => true
            ),
            'price' => array(
               'type' => 'INT'
            ),
            'created_at' => array(
               'type' => 'TIMESTAMP'
            )
         );
 
         $this->dbforge->add_field($columns);
         $this->dbforge->add_key('history_id', TRUE);
         $this->dbforge->create_table('price_history');

         
        $columns =  array(
            'comment_id' => array(
               'type' => 'INT',
               'constraint' => 5,
               'unsigned' => true,
               'auto_increment' => true
            ),
            'product_id' => array(
               'type' => 'INT',
               'constraint' => 5,
               'unsigned' => true
            ),
            'parent_id' => array(
               'type' => 'INT',
               'constraint' => 5,
               'unsigned' => true,
               'null' => true
            ),
            'name' => array(
               'type' => 'varchar',
               'constraint' => '100',
            ),
            'comment' => array(
               'type' => 'text'
            ),
            'ip_address' => array(
               'type' => 'varchar',
               'constraint' => '16',
            ),
            'created_at' => array(
               'type' => 'TIMESTAMP'
            )
         );
 
         $this->dbforge->add_field($columns);
         $this->dbforge->add_key('comment_id', TRUE);
         $this->dbforge->create_table('comments');

         
        $columns =  array(
            'upvote_id' => array(
               'type' => 'INT',
               'constraint' => 5,
               'unsigned' => true,
               'auto_increment' => true
            ),
            'comment_id' => array(
               'type' => 'INT',
               'constraint' => 5,
               'unsigned' => true,
               'null' => true
            ),
            'ip_address' => array(
               'type' => 'varchar',
               'constraint' => '16',
            ),
            'created_at' => array(
               'type' => 'TIMESTAMP'
            )
         );
 
         $this->dbforge->add_field($columns);
         $this->dbforge->add_key('upvote_id', TRUE);
         $this->dbforge->create_table('upvotes');

         
        $columns =  array(
            'downvote_id' => array(
               'type' => 'INT',
               'constraint' => 5,
               'unsigned' => true,
               'auto_increment' => true
            ),
            'comment_id' => array(
               'type' => 'INT',
               'constraint' => 5,
               'unsigned' => true,
               'null' => true
            ),
            'ip_address' => array(
               'type' => 'varchar',
               'constraint' => '16',
            ),
            'created_at' => array(
               'type' => 'TIMESTAMP'
            )
         );
 
         $this->dbforge->add_field($columns);
         $this->dbforge->add_key('downvote_id', TRUE);
         $this->dbforge->create_table('downvotes');
    }

    public function down()
    {
        $this->dbforge->drop_table('ci_session');
        $this->dbforge->drop_table('products');
        $this->dbforge->drop_table('price_history');
        $this->dbforge->drop_table('comments');
        $this->dbforge->drop_table('upvotes');
        $this->dbforge->drop_table('downvotes');
    }
}