<?php 

namespace RapidApp;

/**
* @desc 	- An abstract parent interface and Implementation of the selection factory pattern. 
* 			Uses an IdentityObj to build an SQL where clause accepted by the PDO::prepare() 
* 			and PDO::execute() methods.
* @category - Selection Factory 
* @author   - Dimension Development
* @author 	- Matt Shanks
* @see      - Field!, IdentityObj!
* @version 	- v1.0
* @license	- http://www.php.net/license/3_01.txt
*
*/
class SelectionFactory {

	/** 
	 * @desc 	- A concrete implementation. Makes use of the parent buildWhere()
	 * 			method to complete an SQL statement accepted by the PDO::prepare() and ::execute() methods
	 * @param 	- IdentityObj!
	 * @return Array (containing the entire query as parameter and a values parameter)
	 * @access 	- public
	*/	
	function buildQuery(IdentityObj $idObj) {
		$request = DimRegistry::instance()->getRequest(); // get the current request
		
		// set the properties of particular ido type and hold results
		// @param - Array
		$idoProps = $idObj->forgeProperties();

		$fields = implode(', ', $idObj->getObjFields());

		$query = "SELECT {$fields} FROM {$idoProps['table']}";

		list($where, $values) = $this->buildWhere($idObj);

		return array($query." ".$where, $values);
	}
	// }}}()

	/** 
	 * @desc 	- A concrete implementation. Makes use of the parent buildWhere()
	 * 			method to complete an SQL statement accepted by the PDO::prepare() and ::execute() methods
	 * @param 	- IdentityObj!
	 * @return Array (containing the entire query as parameter and a values parameter)
	 * @access 	- public
	*/	
	function buildRemove(IdentityObj $idObj) {
		$request = DimRegistry::instance()->getRequest(); // get the current request
		
		// set the properties of particular ido type and hold results
		// @param - Array
		$idoProps = $idObj->forgeProperties();

		$fields = implode(', ', $idObj->getObjFields());

		$query = "DELETE FROM {$idoProps['table']}";

		list($where, $values) = $this->buildWhere($idObj);

		return array($query." ".$where, $values);
	}
	// }}}()

	/** 
	 * @desc 	- Builds an SQL where clause from the provided IdentityObj (IdentityObjs use Fields) in
	 * 			a fashion that is accepted by the PDO::prepare() and PDO::execute() methods
	 * @param 	- IdentityObj! (fully populated)
	 * @return 	- Array (containing a where clause parameter and a values parameter)
	 * @access 	- public
	*/	
	function buildWhere(IdentityObj $idObj) {

		if($idObj->isVoid()){
			return array("", array());
		}

		$compstrings = array();

		$values = array();

		foreach($idObj->getComps() as $comp) {
			$compstrings[] = "{$comp['name']} {$comp['operator']} ?";
			$values[] = $comp['value'];
		}

		$where = "WHERE " . implode(" AND ", $compstrings);

		return array($where, $values);

	}
	// }}}()

}
// }}} SelectionFactory
?>