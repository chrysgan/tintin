<?php

function load_class($class){
	require_once DIR_CLASSES.ucfirst($class).'.php';
}

function debug($var){
	echo '<pre>'.print_r($var,true).'</pre>';
}

function debugf($arg=false){
	if($arg==false){
		$T = &$GLOBALS;
		unset($T[array_search($GLOBALS['_SERVER'], $T)]);
		unset($T[array_search($GLOBALS['GLOBALS'], $T)]);
		var_dump($T);
	}
	else{
		var_dump($GLOBALS);
	}

}

function displayPaths(){
	echo 'REQUEST URI : '.$_SERVER['REQUEST_URI'].'<br>';
	echo 'WEBROOT : ' .WEBROOT.'<br>';
	echo 'ROOT : ' .ROOT.'<br>';
}

function rand_string($len){
	$str='';
	$chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	$size=mb_strlen($chars);
	for($i=0;$i<$len;$i++){
		$str.=$chars[rand(0,$size-1)];
	}
	return $str;
}

function cleanArray($var){
    return !is_null($var);
}

function cleanStr($var){
	return trim(strip_tags($var));
}

function post(){
	debug($_POST);
}

function controlMail($mail){
	$patternMail='/^[a-zA-Z0-9_.-]+@[a-zA-Z]+\.[a-zA-Z]{1,3}(\.[a-zA-Z]{1,3})?$/';
	$boolean=preg_match($patternMail, $mail);
	return $boolean;
}
function controlYopMail($mail){
	$patternMail='/^[a-zA-Z0-9_.-]+@yopmail.com$/i';
	$boolean=preg_match($patternMail, $mail);
	return $boolean;
}

function controlPass($pass){
	$patternPass='/^[?!%a-zA-Z0-9_.-]+$/';
	$boolean=preg_match($patternPass, $pass);
	return $boolean;
}

function controlUsername($username){
	$patternUsername='/^[a-zA-Z0-9_-]+$/';
	$boolean=preg_match($patternUsername, $username);
	return $boolean;
}

function controlString($str){
	$patternStr='/^[a-zA-Z0-9 ]+$/';
	$boolean=preg_match($patternStr, $str);
	return $boolean;
}

function controlPath($str){
	$patternStr='/^[a-zA-Z0-9 -_\/]+$/';
	$boolean=preg_match($patternStr, $str);
	return $boolean;
}

function pureString($str){
	if(mb_strlen($str)!=mb_strlen(strip_tags($str))){
		return false;
	}
	else {return true;}
}

function controlTxtArea($str){
	$patternStr='/^[a-zA-Z0-9 éàèçù.,\n\r\R]+$/';
	$boolean=preg_match($patternStr, $str);
	return $boolean;
}
