<?php 

namespace RapidApp;

/**
* @desc 	- abstract parent setting the 'interface' for all PageController! children
			- holds a request, runs processing, and forwards on
* @category	- Request
* @author 	- Dimension Development
* @author 	- Matt Shanks
* @version 	- v1.0
* @license 	- http://www.php.net/license/3_01.txt
*
*/
abstract class PageController{

	abstract function process();

	function forward( $resource ){
		include( $resource );
	}//!()

	function getRequest(){
		return Registry::instance()->getRequest();
	}//!()

}//!

?>
