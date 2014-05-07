<?php

namespace RapidApp;

class Operate{

	// @param - PDO  
	private static $pdo;

	/** 
	 * @desc 	- sets the PDO param
	 * @access 	- public
	*/
	static function setPDO(){
		
		if(! isset(static::$pdo)) { 
			$host = "localhost";
			$name = "dimension";
			$user = "root";
			$pass = "cubanlink";

			static::$pdo = new \PDO("mysql:host=$host;dbname=$name", $user, $pass); 
			static::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		}

		return;	
	}
	// }}}()

	/** 
	 * @desc 	- Handles obtaining a PDO, preparing a statement, and executing that statement
	 * @param 	- String (query)
	 * @param 	- Array (values to add to query) 
	 * @access 	- public
	*/
	function forgeQuery($query, Array $values){
		static::setPDO();

		$handle = static::$pdo->prepare($query); // prepare the query
		$handle->closeCursor(); // free up db connection, but leave statement in a state it can run again
		$result = $handle->execute($values); // execute the query
		$lastId = static::$pdo->lastInsertid(); // get inserted id

		return Array('result'=>$result, 'handle'=>$handle, 'lastId'=>$lastId);

	}
	// }}}()


	/** 
	 * @desc 	- Does the dirty work for building a SELECT WHERE statement and fetching data
	 * @param 	- IdentityObj - MUST BE POPULATED WITH AT LEAST ONE FIELD
	 * @param 	- SelectionFactory
	 * @return 	- Array (of data)
	 * @access  - public
	*/
	function spawnData(IdentityObj $idObj, SelectionFactory $sf){
		// @param - Array(query, values)
		$qa = $sf->buildQuery($idObj);
		// @param - Array
		$fetch = array();

		// execute query with values
		$result = $this->forgeQuery($qa[0], $qa[1]);

		// get next row in db while theres a march and add to $ftrFetch
		while($row = $result['handle']->fetch(PDO::FETCH_ASSOC)){

			array_push($fetch, $row);
		}	

		return $fetch;	
	}
	// }}}()

}// }}}

?>
