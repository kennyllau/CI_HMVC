<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Site_settings extends MX_Controller
{
	function __construct() {

		parent::__construct();

	}

	function _get_item_segments ()
	{
		// return the segments for the store_item pages ( produce page )
		$segments = "company/model/";
		return $segments;
	}

	function _get_items_segments ()
	{
		// return the segments for the category pages 
		$segments = "company/models/";
		return $segments;
	}

}