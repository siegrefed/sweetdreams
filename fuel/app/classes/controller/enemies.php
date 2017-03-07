<?php

class Controller_Enemies extends Controller_Base
{
	public function post_create(){
		$enemies = new Model_Enemies();

		$name = Input::post('name');
		$description = Input::post('description');
		$image = Input::post('image');
		$health = Input::post('health');
		$attack = Input::post('attack');

		$enemies->name = $name;
		$enemies->description = $description;
        $enemies->image = $image;
        $enemies->health = $health;
        $enemies->attack = $attack;

        if (empty($name) or empty($description)or empty($image) or empty($health) or empty($attack))
        {
        	return $this->notice($code = 'ERROR', $message = 'YOU MUST FILL EVERY BLANK SPACE');
        }
        else
        {
        	try
        	{
        		$enemies->save();
        		return $this->notice($code = 'SUCCESSFUL ACTION', $message = 'ENEMY CREATED.');
        	}
        	catch(exception $e)
        	{
        		return $this->notice($code = 'ERROR', $message = 'THIS ENEMY ALREDY EXIST.');
        	}
        }

	}

	public function post_update($id = null){
		try
		{
			if($id != null)
			{
				if($this->check())
				{
					$enemies = new Model_Enemies();
					$enemies = Model_Enemies::find('all', array('where' => array(array('id', $id),)));

					$name = Input::post('name');
					$description = Input::post('description');
					$image = Input::post('image');
					$health = Input::post('health');
					$attack = Input::post('attack');

					if (!empty($enemies))
					{
						if (isset($name) or isset($description) or isset($image) or isset($health) or isset($attack))
						{
								foreach ($enemies as $key) 
								{
									if ($key['id'] == $id )
									{
										if (isset($name))
										{
											if(!empty($name))
											{
												$key->name = $name;
											}
											else return $this->notice($code = 'ERROR', $message = 'NAME NEEDS A VALUE.');
										}
										if (isset($description))
										{
											if(!empty($description))
											{
												$key->description = $description;
											}
											else return $this->notice($code = 'ERROR', $message = 'DESCRIPTION NEEDS A VALUE.');
										}
										if (isset($image))
										{
											if(!empty($image))
											{
												$key->image = $image;
											}
											else return $this->notice($code = 'ERROR', $message = 'IMAGE NEEDS A VALUE.');
										}
										if (isset($health))
										{
											if(!empty($health))
											{
												$key->health = $health;
											}
											else return $this->notice($code = 'ERROR', $message = 'HEALTH NEEDS A VALUE.');
										}
										if (isset($attack))
										{
											if(!empty($attack))
											{
												$key->attack = $attack;
											}
											else return $this->notice($code = 'ERROR', $message = 'ATTACK NEEDS A VALUE.');
										}

										$key->save();
									}
								}
								return $this->notice($code = 'SUCCESSFUL ACTION', $message = 'ENEMY UPDATED.');
						}
						else return $this->notice($code = 'ERROR', $message = 'YOU NEED AT LEAST ENTER ONE PARAMETER TO UPDATE THE DATA.');
					}
					else return $this->notice($code = 'ERROR', $message = 'ENEMY NOT FOUND OR DOES NOT EXIST.');
				}
				else return $this->notice($code = 'ERROR', $message = 'REQUIRE AUTHENTICATION.');
			}
			else return $this->notice($code = 'ERROR', $message = 'EXPECTED ID_ENEMY IN URL.');
		}
		catch(exception $e)
		{
			return  $this->notice($code = 'ERROR', $message = 'INCORRECT AUTHENTICATION.');
		}
	}

}