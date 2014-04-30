<?php

namespace RapidApp;

class Operate{

	/** 
	 * @desc 	- Handles obtaining a PDO, preparing a statement, and executing that statement
	 * @param 	- String (query)
	 * @param 	- Array (values to add to query) 
	 * @access 	- public
	*/
	function forgeQuery($query, Array $values){
		$pdo = Registry::getPDO(); // call static method to set the PDO

		$handle = $pdo->prepare($query); // prepare the query
		$handle->closeCursor(); // free up db connection, but leave statement in a state it can run again
		$result = $handle->execute($values); // execute the query
		$lastId = $pdo->lastInsertid(); // get inserted id

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
	static function spawnData(IdentityObj $idObj, SelectionFactory $sf){
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