<?php

class Controller_Player extends Controller_Base
{
	public function get_score(){

		if($this->check())
		{
			try
			{
				//$player = new Model_Player();
				$player = Model_Player::find('all', array('order_by' => array('score' => 'desc'),));


				// var_dump($player);
				foreach ($player as $key ) {
					$score = $key->score;
				}

				 var_dump($score);
				//return $this->response(array($player,$score));
				return $this->response($player);

			}
			catch (exception $e){
				return $this->notice($code = 'ERROR', $message = 'THERE IS NOT RANKING');
				return $e->getMessage();
			}

		}
		else return $this->notice($code = 'ERROR', $message = 'REQUIRE AUTHENTICATION.');

	}
}