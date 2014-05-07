<?php

namespace RapidApp;

abstract class Validate{
	// instance of a Valitron object
	private $v;

	function __construct( $tainted ){
		$this->v = new \Valitron\Validator( $tainted );
	}

	// - To be implemented by concrete children
	// - Methods purpose should be adding rules to the Valitron object that are specific to current project and its inputs
	//   as well as running the validate method on the Valitron type and approving or rejecting input
	// - See '/vendor/vlucas/valitron' for documentation on using the Valitron type
	abstract function runCheck();

}//!

?>
