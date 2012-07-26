<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Mongomodel extends Mongolib  {

	protected $_dbName = "test"; //set the db
	protected $_collName = "mongotest"; //set the collection

	function __construct(){

		parent::__construct();
	
	}

}


?>