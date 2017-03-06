<?php


class Controller_relusersitems extends Controller_Base
{


//CREAR UNA COMPRA (PARAMETROS REQUERIDOS: IDUSUARIO, IDITEM)-------------------------------------------
public function post_buy()
	{
		$rel_users_items = new Model_Relusersitems();

		$fk_users = Input::post('fk_users');
		$fk_items = Input::post('fk_items');
		// $unidades = Input::post('unidades');

        $rel_users_items->fk_users = $fk_users;
        $rel_users_items->fk_items = $fk_items;
        // $rel_users_items->unidades = $unidades;


		
        	if (empty($fk_items) or empty($fk_users))
        	{
        		return $this->notice($code = 'ERROR', $message = 'YOU NEED USER, ITEM AND UNITS TO PURCHASE.');
        	}
        	else 
        	{
        		try
        		{
        			$rel_users_items->save();
        			return $this->notice($code = 'SUCCESSFUL ACTION', $message = 'ITEM BOUGHT.');
        		}
        		catch(exception $e)
        		{
        			return $this->notice($code = 'ERROR', $message = 'THIS ITEM IS ALREDY BOUGHT.');
        		}
        	}
        }
  
     // FUNCION BORRAR UNA COMPRA (PARAMETROS REQUERIDOS: FK_USER y FK_ITEM)----------------------------------------------------------------------

	public function post_delete($fk_users = null, $fk_items = null)
	{
		try
		{
			if(isset($fk_items) and isset($fk_users))
			{
				if(!empty($fk_users) and !empty($fk_items))
				{

					if($this->check())
					{
					$rel_users_items = new Model_Relusersitems();
					$fk_users = Model_Relusersitems::find('all', array('where' => array(array('fk_users', $fk_users),)));
					$fk_items = Model_Relusersitems::find('all', array('where' => array(array('fk_items', $fk_items),)));
		
						foreach ($fk_items as $key)
						{
							$key -> delete();
							return $this->notice($code = 'SUCCESSFUL ACTION', $message = 'PURCHASE DELETED.');
						}
					}

					else return $this->notice($code = 'ERROR', $message = 'ITEM NOT FOUND OR NOT BOUGHT.');
				}
				else return $this->notice($code = 'ERROR', $message = 'REQUIRE AUTHENTICATION.');
			}
			else return $this->notice($code = 'ERROR', $message = 'EXPECTED FILLED VALUES IN URL.');
		}
		catch(exception $e)
		{
			return $this->notice($code = 'ERROR', $message = 'INCORRECT AUTHENTICATION.');
		}
	}   


}