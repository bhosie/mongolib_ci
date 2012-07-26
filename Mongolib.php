<?php


/*A simple library to handle connecting to A Mongo Database/Collection*/
/*Subclass me to make a simple model for your Mongo collection*/

abstract class Mongolib {

	private $_connection_string;
	
	
	protected $_CI; //lets us store a reference to the CI instance
	protected $_dbName; //The name of the collection. you should set this in a subclass
	protected $_collName; //The name of the collection. you should set this in a subclass
	
	public $db; // This will be the db resource you can act upon. eg. $this->db->cmd(); 
	public $collection; //This will be the collection resource you act upon. eg. $this->collection->insert();
	
	function __construct(){
	
		$this->_CI =& get_instance();
		
		$this->_connect();
				
		
	}
	
	
	/*connection methods based almost entirely on the work of:
	
		Kyle J. Dye | www.kyledye.com | kyle@kyledye.com (2010)
		
	*/

		
	
	/**
	 *	--------------------------------------------------------------------------------
	 *	CONNECT TO MONGODB
	 *	--------------------------------------------------------------------------------
	 *
	 *	Establish a connection to MongoDB using the connection string generated in
	 *	the connection_string() method.  If 'mongo_persist_key' was set to true in the
	 *	config file, establish a persistent connection.  We allow for only the 'persist'
	 *	option to be set because we want to establish a connection immediately.
	 */
	
	private function _connect() {
	
		$this->_connection_string();
		
		$options = array();
		
		if($this->persist === TRUE) {
			$options['persist'] = isset($this->persist_key) && !empty($this->persist_key) ? $this->persist_key : 'ci_mongo_persist';
		}
		
		try {
			// new mongo resource
			$mongo = new Mongo($this->connection_string, $options);

			//db and collection resources
			$this->db = $mongo->{$this->_dbName};
			$this->collection = $mongo->{$this->_dbName}->{$this->_collName};
			
		} catch(MongoConnectionException $e) {
			show_error("Unable to connect to MongoDB: {$e->getMessage()}", 500);
		}
		
	}
	
	/**
	 *	--------------------------------------------------------------------------------
	 *	BUILD CONNECTION STRING
	 *	--------------------------------------------------------------------------------
	 *
	 *	Build the connection string from the config file.
	 */
	
	private function _connection_string() {
		//load the config file
		$this->_CI->config->load($this->_CI->config->item('mongo_config'));
		
		$this->host = trim($this->_CI->config->item('mongo_host'));
		$this->port = trim($this->_CI->config->item('mongo_port'));
		$this->user = trim($this->_CI->config->item('mongo_user'));
		$this->pass = trim($this->_CI->config->item('mongo_pass'));
		$this->dbname = trim($this->_CI->config->item('mongo_db'));
		$this->persist = trim($this->_CI->config->item('mongo_persist'));
		$this->persist_key = trim($this->_CI->config->item('mongo_persist_key'));
		
		$connection_string = "mongodb://";
		
		if(empty($this->host))
		{
			show_error("The Host must be set to connect to MongoDB", 500);
		}
		
		if(empty($this->dbname))
		{
			show_error("The Database must be set to connect to MongoDB", 500);
		}
		
		if(!empty($this->user) && !empty($this->pass))
		{
			$connection_string .= "{$this->user}:{$this->pass}@";
		}
		
		if(isset($this->port) && !empty($this->port))
		{
			$connection_string .= "{$this->host}:{$this->port}";
		}
		else
		{
			$connection_string .= "{$this->host}";
		}
		
		$this->_connection_string = trim($connection_string);
	}

	

}

?>
