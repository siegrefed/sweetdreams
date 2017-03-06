<?php

use \Firebase\JWT\JWT;

class Controller_Base extends Controller_Rest
{

//FUNCION ENCARGADA DE RECIBIR EL TOKEN Y COMPROBAR SU VALIDEZ.------------------------------------------------------------------

    protected function check()
    {
    	$auth = apache_request_headers();
        if(isset($auth['Authorization']))
        {
	        if (!empty($auth))
	        {
	        	$jwt = $auth["Authorization"];
	        	$key = 'teamrocket';
		        $decoded = JWT::decode($jwt, $key, array('HS256'));
		        $token = (array)$decoded;
		       	$entry = Model_Users::find('all', array('where' => array(array('email', $token["email"]),),));

			    if (empty($entry))
			    {
		            return false;
		        }
		      	return true;
	  		}
	  		else return false;
		}
		else return false;
    }      

//FUNCION PARA DEVOLVER LOS ERRORES EN JSON-------------------------------------------------------------------------------------

	protected function notice($code, $message)
	{
		return
		[
		'code' => $code,
		'message' => $message
		];
	}



	
}