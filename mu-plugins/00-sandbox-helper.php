<?php

// no more notices
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// pretty errors
ini_set( 'xdebug.cli_color', 1 );

// logs. `tail -f /chroot/tmp/php-errors`
ini_set( 'error_log', '/tmp/php-errors' );

// fancy var_dump
if ( ! function_exists( 'vip_dump' ) ) {
    function vip_dump( $var = null ) {
        $old_setting = ini_get( 'html_errors' );
        ini_set( 'html_errors', false );
        ini_set( 'xdebug.cli_color', 2 );
        ob_start();
        var_dump( $var );
        $out1 = ob_get_contents();
        ob_end_clean();
        error_log( $out1 );
        ini_set( 'xdebug.cli_color', 1 );
        ini_set( 'html_errors', $old_setting );
    }
}

// show last error on error handler
add_filter( 'wp_php_error_message', function( $m, $e ) { 
    $m .= '<dl>';
    foreach ( $e as $k => $v ) { 
        $m .= "<dt>$k</dt><dd>$v</dd>";
    }
    $m .= '</dl>';
    return $m; 
}, 10, 2 );

