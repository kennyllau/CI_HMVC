<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Site_security extends MX_Controller
{

	function __construct() 
	{
		parent::__construct();
	}


	function _hash_string ($str)
	{
		$hashed_string = password_hash($str, PASSWORD_BCRYPT, array(
			// php bcrypting.. higher = longer crypyting..
			'cost' => 11

			));

		return $hashed_string;
	}

	function _verify_hash($plain_text_str, $hashed_string)
	{
		$result = password_verify($plain_text_str, $hashed_string);

		// returns true or false
		return $result;
	}

	function _make_sure_is_admin()
	{
		$is_admin = TRUE;

		if($is_admin != TRUE)
		{
			redirect('site_security/not_allowed');
		}
	}

	function not_allowed()
	{
		echo "You are not allowed to be here.";
	}

	// function test ()
	// {
	// 	$name = "David";
	// 	$hashed_name = $this->_hash_string($name);

	// 	echo "you are $name <br>";
	// 	echo $hashed_name;

	// 	echo '<hr>';

	// 	$submitted_name = "David";
	// 	$result = $this->_verify_hash($submitted_name, $hashed_name);

	// 	if ($result == true)
	// 	{
	// 		echo "well done mate";
	// 	}
	// 	else{
	// 		echo "try again";
	// 	}

	// }
	
	// function test ()
	// {
	// 	echo phpinfo();
	// }
}