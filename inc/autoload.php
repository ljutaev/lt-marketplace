<?php

if ( ! defined('ABSPATH') ) {
	exit;
}

/*
 * human readable dump
 *
 */
if( ! function_exists('dd') ) {
    function dd( $what = '' ) {
        print '<pre class="lt-dump">';
        print_r( $what );
        print '</pre>';
    }
}

/*
 * autoload
 */
spl_autoload_register( function( $class_name ) {
    if ( strpos( $class_name, 'LtMarketplace' ) === false ) { return; }

    $file_parts = explode( '\\', $class_name );    

    $namespace = '';
    for( $i = count( $file_parts ) - 1; $i > 0; $i-- ) {

        $current = strtolower( $file_parts[ $i ] );
        $current = str_ireplace( '_', '-', $current );

        if( count( $file_parts ) - 1 === $i ) {
            $file_name = "{$current}.php";
        }else{
            $namespace = '/' . $current . $namespace;
        }
    }

    $filepath  = trailingslashit( dirname( dirname( __FILE__ ) ) . $namespace );
    $filepath .= $file_name;

    if( file_exists( $filepath ) ) {
        include_once( $filepath );
    }else{
        wp_die( esc_html("The file attempting to be loaded at {$filepath} does not exist.") );
    }

});

// init
new LtMarketplace\Inc\Init();