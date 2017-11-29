<?php

/**
 * This class generates custom CSS into static CSS file in uploads folder
 * and enqueue it in the frontend
 *
 * CSS is generated only when theme options is saved (changed)
 * Works with LESS (for unlimited color schemes)
 */
require 'lessc.inc.php';
require( THEME_DIR . 'css/custom.php' );

function generate( $folder, $fileout ) {
	$files = scandir( $folder );
	$css=  '';
	foreach ( $files as $file ) {
		if ( strpos( $file, 'less' ) !== false ) {
			$content_file = file_get_contents( THEME_DIR . 'css/less/' . $file );
			$compiler     = new lessc;
			$compiler->setFormatter( 'compressed' );
			$css .= $compiler->compile( $content_file );
		}
	}
        $css .= customcss();
	$regex = array(
		"`^([\t\s]+)`ism"                       => '',
		"`^\/\*(.+?)\*\/`ism"                   => '',
		"`([\n\A;]+)\/\*(.+?)\*\/`ism"          => "$1",
		"`([\n\A;\s]+)//(.+?)[\n\r]`ism"        => "$1\n",
		"`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism" => "\n"
	);
	$css   = preg_replace( array_keys( $regex ), $regex, $css );
	file_put_contents( $fileout, $css );
}
