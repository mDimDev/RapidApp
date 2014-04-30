<?php 

namespace RapidApp;

/**
* @desc 	- A data structure representing the combination of a db column and an
* 			operator. Allows multiple comparisons. For use with an IdentityObj
* @category - Identity Object component
* @author   - Dimension Development
* @author 	- Matt Shanks
* @see      - IdentityObj
* @version 	- v1.0
* @license	- http://www.php.net/license/3_01.txt
*
*/
class Field {

	// @param - String 
	protected $name=null;

	// @param - Array
	protected $comps=array();

	// @param - boolean
	protected $incomplete=false;

	/** 
	 * @method
	 * @desc 	- constructor
	 * @param 	- String (a db column name)
	 * @access 	- public
	*/
	function __construct($name){

		$this->name = $name;

	}
	// }}}()

	/** 
	 * @method
	 * @desc 	- Adds a test to the comps array 
	 * @param 	-The operator of comparison (<, >, =)
	 * @param 	- The value being compared 
	 * @access public
	*/
	function addTest($operator, $value){

		$this->comps[] = array('name'=>$this->name, 'operator'=>$operator, 'value'=>$value);

	}
	// }}}()

	/**  
	 * @return 	- Array ($comps)
	 * @access public
	*/
	function getComps(){ return $this->comps; }
	// }}}()

	/** 
	 * @method
	 * @desc 	- Adds a test to the comps array 
	 * @return 	- (If the comps array is empty or not)
	 * @access public
	*/
	function isIncomplete(){ return empty($this->comps); }
	// }}}()

}
// Field

?>