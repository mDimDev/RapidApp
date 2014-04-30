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

	// @param - PDO  
	private static $pdo;

	// @param - Request 
	private $request;

	/** 
	 * @desc 	- only way to instantiate this type is to call instance()
	 * @access 	- private
	*/
	private function __construct(){ } 
	// }}}()

	/** 
	 * @desc 	- checks if it exsists, creates itself or returns itself
	 * @access 	- public
	 * @return 	- Registry!
	*/
	static function instance(){
		if(! isset(self::$instance)) { 
			self::$instance = new self(); 
		}

		return self::$instance;

	} 
	// }}}()

	/** 
	 * @desc 	- sets the PDO param
	 * @access 	- public
	*/
	static function getPDO(){
		if(! isset(self::$pdo)) { 
			$host = "localhost";
			$name = "dimension";
			$user = "root";
			$pass = "";

			self::$pdo = new PDO("mysql:host=$host;dbname=$name", $user, $pass); 
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return self::$pdo;
		}
		
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