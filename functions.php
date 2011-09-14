<?

function load_theme_module( $filename )
{
	include "themes/" . get_info("themename") . "/" . $filename;
}

function print_info( $info )
{
	echo get_info( $info );
}

?>
