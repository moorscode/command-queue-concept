<?php

spl_autoload_register( function ( $class ) {
	require_once dirname( __FILE__ ) . '/' . str_replace( '\\', '/', $class ) . '.php';
} );

