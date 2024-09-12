<?php

// no more notices
error_reporting( E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR | E_USER_ERROR );

// pretty errors
ini_set( 'xdebug.cli_color', 1 );

// logs. `tail -f /chroot/tmp/php-errors`
ini_set( 'error_log', '/tmp/php-errors' );

// fancy var_dump
if ( ! function_exists( 'vip_dump' ) ) {
	function vip_dump( ...$var ) {
		if ( 0 === ob_get_level() ) {
			$old_setting = ini_get( 'html_errors' );
			ini_set( 'html_errors', false );
			ini_set( 'xdebug.cli_color', 2 );
			ob_start();
			$trace = debug_backtrace();
			$real_file = $trace[0]['file'];
			foreach ( $var as $v ) {
				var_dump( $v );
			}
			$out1 = ob_get_contents();
			$out1 = str_replace( __FILE__, $real_file, $out1 );
			ob_end_clean();
			error_log( $out1 );
			ini_set( 'xdebug.cli_color', 1 );
			ini_set( 'html_errors', $old_setting );
		} else {
			error_log( var_export( $var, true ) ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log, WordPress.PHP.DevelopmentFunctions.error_log_var_export
		}
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

add_filter( 'x_redirect_by', function( $x_redirect_by, $status, $location ) {
	return sprintf(
		'%s; Debug Backtrace: %s',
		$x_redirect_by,
		wp_debug_backtrace_summary()
	);
}, 10, 3 );

if ( file_exists( __DIR__ . '/sandbox-wp-debugger/sandbox-wp-debugger.php' ) ) {
	require_once __DIR__ . '/sandbox-wp-debugger/sandbox-wp-debugger.php';
}
