<?php
namespace App;

class Message{

	static function deleteMsg(){
		global $messages;
		if(isset($messages)){unset($messages);}
	}

	static function addMsg($msg){
		global $messages;
		$messages[]=$msg;
	}

	static function displayMsg(){
		global $messages;
		if(isset($messages[0]) && !empty($messages[0])){
				foreach ($messages as $element){
				echo $element.'<br>';
			}
		}
	}

	static function nbMsg(){
		global $messages;
		return count($messages);
	}

}
?>
