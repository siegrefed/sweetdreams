<?php
namespace Fuel\Migrations;

class Enemies
{

    function up()
    {
        \DBUtil::create_table('enemies', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'name' => array('type' => 'varchar', 'constraint' => 255),
            'description' => array('type' => 'varchar', 'constraint' => 255, 'null'=>true),
            'image' => array('type' => 'varchar', 'constraint' => 255, 'null'=>true),
            'health' => array('type' => 'int', 'constraint' => 11, 'null'=>true),
            'attack' => array('type' => 'int', 'constraint' => 11, 'null'=>true),
            
        ), array('id'));

        \DB::query("ALTER TABLE `enemies` ADD UNIQUE(`name`)")->execute();
    }

    function down()
    {
       \DBUtil::drop_table('enemies');
    }
}