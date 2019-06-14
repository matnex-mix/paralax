<?php

	require('definition.php');
	require('loader.php');

	function pp_create_html( $_node_name, $_args ) {

		$_attr = pp_prepare_attributes( $_args );
		$_content = pp_guess_content( $_args );

		if ( in_array( $_node_name, _PD["s_tag"] ) ) {

			$_created_html = "<$_node_name$_attr/>$_content";

		} else {

			$_created_html = "<$_node_name$_attr>$_content</$_node_name>";

		}

		return $_created_html;

	}

	function pp_prepare_attributes ( $_tmp ) {

		$_tmp = $_tmp[0];

		if ( is_array( $_tmp ) ) {

			$__tmp = "";

			foreach ($_tmp as $key => $value) {
				$__tmp .= " $key=\"$value\"";
			}

			$_tmp = $__tmp;

		} else {

			$_tmp = str_replace( '&', '" ', $_tmp );
			if( $_tmp) $_tmp = ' '.$_tmp.'"';
			$_tmp = preg_replace( "/ \w+=/", '$0"', $_tmp );

		}

		return $_tmp;

	}

	function pp_guess_content ( $_tmp ) {

		array_shift($_tmp);
		return implode( "\n", $_tmp );

	}

	## Show Generated HTML
	function _dump() {
		echo _format( implode( '', func_get_args() ) );
	}

	## Format HTML
	function _format( $_html_string ) {

		$_html_string = preg_replace( "/></", ">\n<", $_html_string );

		$count = 0;
		$cc_b = 0;
		$_cb = 0;

		while ( strpos( $_html_string, "<" ) !== false ) {
			
			$pos_b = strpos( $_html_string, "<" );
			$c_b = strcount( $_html_string, '#%#', 0, $pos_b );
			$c_b -= strcount( $_html_string, '#%#\/', 0, $pos_b )+1;

			if ( isset( $_html_string[$pos_b] ) && $_html_string[$pos_b+1] == "/" ) {

				if ( $_html_string[$pos_b-1] == "\n" ) {

					$c_b = $cc_b - strcount( $_html_string, '#%#\/', 0, $pos_b );
					$_cb = $c_b;

				} else {
					$c_b = 0;
				}

			} else {
				$cc_b = $c_b;
			}

			$_r = "";
			for ( $x=0; $x<$c_b; $x++ ) {
				$_r .= "\t";
			}

			$_html_string = substr_replace( $_html_string, $_r."#%#", $pos_b, 1 );

		}
		$_html_string = str_replace( '#%#', '<', $_html_string );

		return $_html_string;

	}

	function pp_parallax_default($_tmp) {

		$GLOBALS["_PD"] = $_tmp;

	}

	function strcount( $_haystack, $_needle, $_start=0, $_end=null ) {

		if ( $_end === null ) $_end = strlen($_haystack);
		$_haystack = substr( $_haystack, $_start, $_end-1 );

		preg_match_all( "/$_needle/", $_haystack, $matches );
		return sizeof($matches[0]);

	}