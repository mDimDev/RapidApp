<?php

namespace RapidApp;

class Validate{
	// instance of a Valitron object
	private $v;

	function __construct( $tainted ){
		$this->v = new \Valitron\Validator( $tainted );
	}

	function runCheck(){
		// define validation input rules for this project
		$this->v->rule( 'slug', ['c_name', 'c_phone'] );
		$this->v->rule( 'email', 'c_email' );
		$this->v->rule( 'alpha', ['c_bus_typ', 'c_needed', 'c_brand', 'c_updates', 'c_changes', 'c_browseshop', 'c_anime', 'c_compsys'] );

		// run the validation			
		if( $this->v->validate() ){
			
			return;

		} else {
			
			throw new Exception( print_r( $this->v->errors() ) );
		}

	}//()


}//!

?>
