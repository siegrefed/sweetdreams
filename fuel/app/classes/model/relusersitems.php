<?php 

class Model_RelUsersItems extends Orm\Model {

protected static $_table_name = 'rel_users_items';
protected static $_primary_key = array('fk_users', 'fk_items');

protected static $_properties = array(
        'fk_users',
        'fk_items',
        // 'unidades' => array(
        //    'data_type' => 'int'
        // )
    );
}