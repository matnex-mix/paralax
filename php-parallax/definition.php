<?php
	
	// Library Variables
	if( !defined( '_PD_PATH' ) ) {
		define( '_PD_PATH', dirname( __FILE__ )."\\" ); ## ABS Path to PARALLAX

		/** Define Defaults **/
		$_tmp = json_decode( file_get_contents( _PD_PATH.'defaults.json' ), true );
		define( '_PD', $_tmp );
		unset($_tmp);
	
	}
	$GLOBALS["_G_HTML"] = ""; ## Generated HTML container

	// A
	function _a() { return pp_create_html( "a", func_get_args() ); } ## <a></a>

	// B
	function _b() { return pp_create_html( "b", func_get_args() ); } ## <b></b>
	function _body() { return pp_create_html( "body", func_get_args() ); } ## <body></body>

	// H
	function _head() { return pp_create_html( "head", func_get_args() ); } ## <head></head>
	function _html() { echo _format( "<!DOCTYPE html>\n".pp_create_html( "html", func_get_args() ) ); } ## <html></html>

	// M
	function _meta() { return pp_create_html( "meta", func_get_args() ); } ## <meta />