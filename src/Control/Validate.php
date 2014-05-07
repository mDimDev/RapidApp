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
	// - See '/vendor/vlucas/valitron' for documentation on adding rules
	abstract function runCheck();

}//!

?>
