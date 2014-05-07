<?php 

namespace RapidApp;

/**
* @desc 	- An Implementation of the update factory pattern
* @category - Update Factory 
* @author 	- Dimension Development
* @author 	- Matt Shanks
* @version 	- v1.0
* @license 	- http://www.php.net/license/3_01.txt
*
*/
class UpdateFactory {

	/** 
	 * @desc 	- builds a dynamic insert or update query accepted by PDO::prepare and ::execute
	 * @access  - public
	 * @param 	- String (table name as a string)
	 * @param 	- Array (columns to be inserted into)
	 * @param 	- Array (id of the record to updates) 
	 * @return  - Array (query, values)
	*/
	function buildQuery($idObj) {
		$request = Registry::instance()->getRequest(); // get the current request

		// initialize
		$conds = null;

		// set the properties of this idObj type and hold results
		// @param - Array
		$idoProps = $idObj->forgeProperties(); 

		// populate the $cond param from $idoProps removing 'table' index
		foreach($idoProps as $key=>$val){
			if($key !== 'table'){
				$conds[$key] = $val;
			}
		}

		// get data without application level query strings
		$fields = $request->getRawData();

		// if no data in $fields do NOT proceed
		if(empty($fields)){
			throw new Exception("No data recieved. Param - fields - is empty.");
		}

		// if set then update, if not then insert
		if(! is_null($conds)){
			$query  = "UPDATE {$idoProps['table']} SET ";
			$query .= implode(" = ?, ", array_keys($fields)) . " = ?";
			$values = array_values($fields);

			$cond = array();

			$query .= " WHERE ";

			foreach($conds as $key=>$val){
				$cond[] = "{$key} = ?";
				$values[] = $val;
			}

			$query .= implode(" AND ", $cond);
			
		} else {
			$query  = "INSERT INTO {$idoProps['table']} (";
			$query .= implode(", ", array_keys($fields));
			$query .= ") VALUES (";

			foreach($fields as $key=>$val){
				$values[]=$val;
				$qs[]='?';
			}

			$query .= implode(",", $qs);
			$query .= ")";
		}

		return array($query, $values);

	}
	// }}}()
	
}
// }}} UpdateFactory
?>
