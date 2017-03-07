<?php
namespace Fuel\Migrations;

class RelUsersItems
{
	function up()
	{
		\DBUtil::create_table('rel_users_items',array(
			'fk_users' => array('type' => 'int', 'constraint' => 11),
			'fk_items' => array('type' => 'int', 'constraint' => 11),
			// 'unidades' => array('type' => 'int', 'constraint' => 50),

			), array('fk_users','fk_items'));
	}
	function down()
	{
		\DBUtil::drop_table('rel_users_items');
	}

}