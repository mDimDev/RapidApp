<?php 

namespace RapidApp;

/**
* @desc 	- A singleton implementation that allows system wide access to various objects
* @category	- Singleton, Registry
* @author 	- Dimension Development
* @author 	- Matt Shanks
* @see  	- DimController!, DimCommandResolver!, Request!, DimCommand!
* @version 	- v1.0
* @license	- http://www.php.net/license/3_01.txt
*
*/
class Registry {

	// @param - Registry
	private static $instance;

	// @param - Request 
	private $request;

	/** 
	 * @desc 	- only way to instantiate this type is to call instance()
	 * @access 	- private
	*/
	private function __construct(){ } 
	// }}}()

	/** 
	 * @desc 	- checks if it exsists, creates itstatic or returns itstatic
	 * @access 	- public
	 * @return 	- Registry!
	*/
	static function instance(){
		if(! isset(static::$instance)) { 
			static::$instance = new static(); 
		}

		return static::$instance;

	} 
	// }}}()


	/** 
	 * @desc 	- Sets the request property to the provided Request object
	 * @param 	- Request
	 * @access 	- public
	*/
	function setRequest(Request $request){
		$this->request = $request;

	} 
	// }}}()

	/** 
	 * @desc 	- Returns the contained Request object
	 * @return 	- Request
	 * @access 	- public
	*/
	function getRequest(){
		return $this->request;
		
	} 
	// }}}()

} 
// Registry

?>
