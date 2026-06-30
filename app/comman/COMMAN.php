<?php 
/*
|----------------------------------------------------------------------------
|@Class 		: COMMAN
|@Purpuse		: Define function's that are used globaly in project
|------------------------------------------------------------------------------
*/
namespace App\comman;


class COMMAN 
{
    /*
	|----------------------------------------------------------
	|This is for checking permission for access any page,
	|defined from where user created
	|----------------------------------------------------------
	*/
	public static function replace($text,$replace)
	{
	    $str = str_replace('{City}', $replace, $text);
	  return str_replace('{city}', $replace, $str);	
	}
	
	
	
}