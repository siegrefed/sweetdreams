<?php

use \Firebase\JWT\JWT;

class Controller_Users extends Controller_Base
{

//CLAVE SECRETA
	private $key = 'teamrocket';

//FUNCION GENERAR TOKEN CON DATOS DE LA BBDD (PARAMETROS NECESARIOS: USERNAME AND PASSWORD)--------------------------------------
	
	public function post_login()
	{
		$email = Input::post('email');
		$pass = Input::post('password');

		$user = Model_Users::find('all', array('where' => array(array('email', $email),)));

		if(isset($email))
        {
        	if(isset($pass))
        	{
        		if (!empty($user))
				{
					foreach ($user as $key => $value)
					{
						$id = $user[$key]->id;
						$email = $user[$key]->email;
						$password = $user[$key]->password;
					}
				}
				else return $this->notice($code = 'ERROR', $message = 'EMAIL ENTERED WRONG OR NOT REGISTERED.');

				if ($email == $email and $password == $pass)
				{
					$token = array(
						"id" => $id, 
						"email" => $email, 
						"password" => $password
					);

					$jwt = JWT::encode($token, $this->key);

					return $this->notice($code = 'SUCCESSFUL ACTION', $message = $jwt);
				}
				else return $this->notice($code = 'ERROR', $message = 'PASSWORD ENTERED WRONG.');
			}
			else return $this->notice($code = 'ERROR', $message = 'REQUIRE PASSWORD.');
		}
		else return $this->notice($code = 'ERROR', $message = 'REQUIRE EMAIL.');
	}

//FUNCION MOSTRAR TODOS LOS USUARIOS REGISTRADOS (PARAMETROS REQUERIDOS: TOKEN)--------------------------------------------------

	public function get_users()
	{
		try
		{
			if($this->check())
			{
				$user = Model_Users::find('all');
				return $user;
			}
			else return $this->notice($code = 'ERROR', $message = 'REQUIRE AUTHENTICATION.');
		}
		catch(exception $e)
		{
			return  $this->notice($code = 'ERROR', $message = 'INCORRECT AUTHENTICATION.');
		}
	}

//FUNCION BUSCAR USUARIO POR ID (PARAMETROS NECESARIOS: ID)----------------------------------------------------------------------

	public function get_user($id = null)
	{
		try
		{
			if ($id != null)
			{
				if ($this->check()) 
				{
					$user = Model_Users::find ('all', array('where' => array(array('id', $id),)));

					if (!empty($user))
					{
						return $user;
					}
					else return $this->notice($code = 'ERROR', $message = 'USER NOT FOUND OR DOES NOT EXIST.');
				}
				else return $this->notice($code = 'ERROR', $message = 'REQUIRE AUTHENTICATION.');
			}
			else return $this->notice($code = 'ERROR', $message = 'EXPECTED ID_USER IN URL.');
		}
		catch(exception $e)
		{
			return  $this->notice($code = 'ERROR', $message = 'INCORRECT AUTHENTICATION.');
		}
	}

	//FUNCION BUSCAR USUARIO POR NOMBRE (PARAMETROS NECESARIOS: USERNAME)----------------------------------------------------------------------

	public function get_username ($username = null)
	{
		//ssdsaddas
		try
		{
			if ($username != null)
			{
				if ($this->check()) 
				{
					
					$user = DB::query("SELECT * FROM users WHERE username like '%$username%'")->execute();
					
					if (!empty($user))
					{
						
						foreach ($user as $key => $value) {
							$arrayUser[] = $value;
						}

						return Arr::reindex($arrayUser);
					}
					else return $this->notice($code = 'ERROR', $message = 'USER NOT FOUND OR DOES NOT EXIST.');
				}
				else return $this->notice($code = 'ERROR', $message = 'REQUIRE AUTHENTICATION.');
			}
			else return $this->notice($code = 'ERROR', $message = 'EXPECTED ID_USER IN URL.');
		}
		catch(exception $e)
		{
			return  $this->notice($code = 'ERROR', $message = 'INCORRECT AUTHENTICATION.');
		}
	}

//FUNCION EDITAR USUARIO POR ID (PARAMETROS REQUERIDOS: ID, USERNAME, PASSWORD, EMAIL AND IMAGE)---------------------------------

	public function post_update($id = null)
	{
		try
		{
			if($id != null)
			{
				if($this->check())
				{
					$user = new Model_Users();
					$user = Model_Users::find('all', array('where' => array(array('id', $id),)));

					$username = Input::post('username');
					$password = Input::post('password');
					$email = Input::post('email');
					$image = Input::post('image');

					$checkEmail = Model_Users::find('all', array('where' => array(array('email',$email),)));

					if (!empty($user))
					{
						if (isset($email) or isset($password) or isset($username) or isset($image))
						{
							if (empty($checkEmail))
							{
								foreach ($user as $key) 
								{
									if ($key['id'] == $id )
									{
										if (isset($username))
										{
											if(!empty($username))
											{
												$key->username = $username;
											}
											else return $this->notice($code = 'ERROR', $message = 'USERNAME NEEDS A VALUE.');
										}
										if (isset($password))
										{
											if(!empty($password))
											{
												$key->password = $password;
											}
											else return $this->notice($code = 'ERROR', $message = 'PASSWORD NEEDS A VALUE.');
										}
										if (isset($email))
										{
											if(!empty($email))
											{
												$key->email = $email;
											}
											else return $this->notice($code = 'ERROR', $message = 'EMAIL NEEDS A VALUE.');
										}
										if (isset($image))
										{
											if(!empty($image))
											{
												$key->image = $image;
											}
											else return $this->notice($code = 'ERROR', $message = 'IMAGE NEEDS A VALUE.');
										}
										$key->save();
									}
								}
								return $this->notice($code = 'SUCCESSFUL ACTION', $message = 'USER UPDATED.');
							}
							else return $this->notice($code = 'ERROR', $message = 'THE EMAIL ENTERED IS CURRENTY IN USE.');
						}
						else return $this->notice($code = 'ERROR', $message = 'YOU NEED AT LEAST ENTER ONE PARAMETER TO UPDATE THE DATA.');
					}
					else return $this->notice($code = 'ERROR', $message = 'USER NOT FOUND OR DOES NOT EXIST.');
				}
				else return $this->notice($code = 'ERROR', $message = 'REQUIRE AUTHENTICATION.');
			}
			else return $this->notice($code = 'ERROR', $message = 'EXPECTED ID_USER IN URL.');
		}
		catch(exception $e)
		{
			return  $this->notice($code = 'ERROR', $message = 'INCORRECT AUTHENTICATION.');
		}
	}

//FUNCION BORRAR USUARIO POR ID (PARAMETROS REQUERIDOS: ID)----------------------------------------------------------------------

	public function post_delete($id = null)
	{
		try
		{
			if($id != null)
			{
				if($this->check())
				{
					$user = new Model_Users();
					$user = Model_Users::find('all', array('where' => array(array('id', $id),)));
			
						foreach ($user as $key)
						{
							$key -> delete();
							return $this->notice($code = 'SUCCESSFUL ACTION', $message = 'USER DELETED.');
						}

					if (!empty($user))
					{
						return $user;
					}
					else return $this->notice($code = 'ERROR', $message = 'USER NOT FOUND OR DOES NOT EXIST.');
				}
				else return $this->notice($code = 'ERROR', $message = 'REQUIRE AUTHENTICATION.');
			}
			else return $this->notice($code = 'ERROR', $message = 'EXPECTED ID_USER IN URL.');
		}
		catch(exception $e)
		{
			return $this->notice($code = 'ERROR', $message = 'INCORRECT AUTHENTICATION.');
		}
	}



//FUNCION CREAR USUARIO. (PARAMETROS REQUERIDOS: EMAIL AND PASSWORD)-------------------------------------------------------------

	public function post_create()
	{
		$user = new Model_Users();

		$username = Input::post('username');
		$password = Input::post('password');
		$email = Input::post('email');
		$image = Input::post('image');

        $user->username = $username;
        $user->password = $password;
        $user->email = $email;
        $user->image = $image;


		if(isset($email) and isset($password))
        {
        	if (empty($email) or empty($password))
        	{
        		return $this->notice($code = 'ERROR', $message = 'EMAIL OR PASSWORD NOT INTRODUCED.');
        	}
        	else 
        	{
        		try
        		{
        		    $player = new Model_Player();

        			$player->gems = 0;

        			$player->save();

        			$user->fk_player = $player->id;
	        		$user->save();


	        		return $this->notice($code = 'SUCCESSFUL ACTION', $message = 'USER CREATED.');
	        	}
        		catch(exception $e)
        		{
        			return $this->notice($code = 'ERROR', $message = 'EMAIL ALREDY REGISTERED, PLEASE ENTER A DIFFERENT ONE.');
        		}
        	}
        }
        else return $this->notice($code = 'ERROR', $message = 'REQUIRE EMAIL AND PASSWORD.');
    }


//FUNCION MOSTRAR ITEMS DE USUARIOS (PARAMETROS REQUERIDOS: TOKEN)---------------------------------------------------------------

//public function get_usersitems()
//	 {
	 	
//	 		if($this->check())
//	 		{
//	 			$user = Model_Users::find('all');
//	 			$user = Model_Users::find('all', array('where' => array(array('id', $id_users))));

//	 			$item = Model_Items::find('all');
//	 			$item = Model_Items::find('all', array('where' => array(array('id', $id_items))));

//	 			$relui = Model_RelUsersItems::find('all');

//				return $relui,;
	 			
//	 		}
//	 		else return $this->notice($code = 'ERROR', $message = 'REQUIRE AUTHENTICATION.');
	 	
//	 }


//FUNCION MOSTRAR ITEMS DE UN UNICO USUARIO (PARAMETROS REQUERIDOS: ID)----------------------------------------------------------

	public function get_userItems($id_user = null)
	{
		if(isset($id_user))
		{

			if($id_user != null)
			{
				if($this->check())
				{
					// $user = new Model_Users();
					// $user = Model_Users::find('all', array('where' => array(array('id', $id_user))));

					$item = new Model_Items();
					$item = Model_Items::find('all');

					$relui = new Model_RelUsersItems();
					$relui = Model_RelUsersItems::find('all', array('where' => array(array('fk_users', $id_user))));


					if (!empty($id_user))
					{
						//print ("hola");

						if($item != null)
						{
								//print ("hola1");

							foreach ($relui as $key)
							{

								if ($key['fk_users'] == $id_user)
								{
									

									return $relui;	
								}

							}
							return $this->notice($code = 'ERROR', $message = 'THIS USER DO NOT HAVE ASOCIATED ITEMS.');
						}
						else return $this->notice($code = 'ERROR', $message = 'ITEMS NOT FOUND OR DOES NOT EXIST.');
					}
					else return $this->notice($code = 'ERROR', $message = 'USER NOT FOUND OR DOES NOT EXIST.');
				}
				else return $this->notice($code = 'ERROR', $message = 'REQUIRE AUTHENTICATION.');
			}
			else return $this->notice($code = 'ERROR', $message = 'EXPECTED ID_USER IN URL.');
		}
		else return $this->notice($code = 'ERROR', $message = 'EXPECTED ID_USER IN URL.');

	}



	public function get_usersitems(){
		if($this->check()){
			
		}



	}


}

?>