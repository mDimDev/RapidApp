<?php 

namespace RapidApp;

/**
* @desc 	- Encapsulates the conditional aspect of a db query allowing different 
* 			combinations to be constructed at run time. To be used with a Field object
* @category	- Identity Object 
* @author   - Dimension Development
* @author 	- Matt Shanks
* @see      - Field
* @version 	- v1.0
* @license	- http://www.php.net/license/3_01.txt
*
*/
abstract class IdentityObj {

	// @param - Field
	protected $currentfield=null;

	// @param - Array (of Fields) 
	protected $fields = array();

	// @param - Array (of specific properties for this IdentityObj)
	protected $properties = array();

	// @param - Array (of enforced columns in a table) 
	protected $enforce = array();

	// @param - String (type of this IdentityObj)
	public $type;

	/** 
	 * @desc 	- constructor
	 * @param 	-Field (type)
	 * @param 	- Array (of columns in a table)
	 * @access 	- public
	*/
	function __construct($field=null, Array $enforce=null){

		if(! is_null($enforce)){
			$this->enforce = $enforce;
		}

		if (! is_null($field)){
			$this->field($field);
		}

	}
	// }}}()

	abstract function forgeProperties();
	
	/** 
	 * @desc 	- sets the $properties
	 * @param 	- DimRequest (type)
	 * @param 	- String (this types db table)
	 * @param 	- Int (specific id for this db element)
	 * @access 	- public
	*/
	function setProperties($table, $id){
		$request = Registry::instance()->getRequest(); // get the current request
		
		if($request->getProperty('id')){
			$this->properties = array('table'=>$table, $id=>$request->getProperty('id'));
		} else{
			$this->properties = array('table'=>$table);
		}
		
	}
	// }}}()

	/** 
	 * @desc 	- getter
	 * @return 	- Array ($enforce)
	 * @access 	- public
	*/
	function getObjFields(){ return $this->enforce; }
	// }}}()

	/** 
	 * @desc 	- getter
	 * @param  	- String (column name in a table)
	 * @return 	- IdentityObj (self)
	 * @access 	- public
	*/
	function field($fieldname){

		if(! $this->isVoid() && $this->currentfield->isIncomplete()) {
			throw new Exception("Is void!");
		}

		$this->enforceField($fieldname);

		if(isset($this->fields[$fieldname])) {
			$this->currentfield = $this->fields[$fieldname];
		
		} else {
			$this->currentfield = new Field($fieldname);

			$this->fields[$fieldname] = $this->currentfield;
		}

		return $this;

	}
	// }}}()

	/** 
	 * @desc 	- checks if $fields is empty
	 * @return 	- results of check
	 * @access 	- public
	*/
	function isVoid(){ return empty($this->fields); }
	// }}}()

	/** 
	 * @desc 	- checks given fieldname versus $enforce
	 * @access 	- public
	*/
	function enforceField($fieldname){

		if(! in_array($fieldname, $this->enforce) && ! empty($this->enforce)) {
			$forcelist = implode(', ', $this->enforce);

			throw new Exception("{$fieldname} not a legal field {$forcelist}");
		}
	}
	// }}}()

	/** 
	 * @desc 	- Checks if the fields array is empty and combines the correct symbol and value pair	
	 * @param 	- String (the operator symbol) 
	 * @param 	- (the value paired with said symbol)
	 * @return 	- IdentityObject (self)
	 * @access 	- public
	*/
	function operator($symbol, $value){

		if($this->isVoid()) {
			throw new Exception("Empty!");
		}

		$this->currentfield->addTest($symbol, $value);

		return $this;
	}
	// }}}()

	/** 
	 * @desc 	- Delegates to the operator() method, inserting the proper comparison operator
	 * @param 	- String (the value) 
	 * @return 	- IdentityObject (result of calling operator())
	 * @access 	- public
	*/
	function eq($value) { return $this->operator("=", $value); }
	// }}}()

	// {{{ lt()

	/** 
	 * @desc 	- Delegates to the operator() method, inserting the proper comparison operator
	 * @param 	- String (the value) 
	 * @return 	- IdentityObject (result of calling operator())
	 * @access 	- public
	*/
	function lt($value) { return $this->operator("<", $value); }
	// }}}()

	/** 
	 * @desc 	- Delegates to the operator() method, inserting the proper comparison operator
	 * @param 	- String (the value) 
	 * @return 	- IdentityObject (result of calling operator())
	 * @access 	- public
	*/
	function gt($value) { return $this->operator(">", $value); }
	// }}}()

	/** 
	 * @desc 	- Calls the Field getComps() method on each encapsulated Field object and compiles the result in an array 
	 * @return 	- Array (created via method)
	 * @access 	- public
	*/
	function getComps() {
		$ret = array();

		foreach($this->fields as $key => $field){
			$ret = array_merge($ret, $field->getComps());
		}

		return $ret;
	}
	// }}}()

}
// }}}!

?>
