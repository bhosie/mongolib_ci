<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Mongocontroller extends MY_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('Mongomodel');

	}

	

	function insert(){

		$this->Mongomodel->collection->insert(array('Title' => 'Hello world'));
	}



/*EOF*/