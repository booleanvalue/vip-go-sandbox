<?php
$configurator = \WP_CLI::get_configurator();
$argv = array_slice( $GLOBALS['argv'], 1 );
list( $args, $assoc_args, $runtime_config ) = $configurator->parse_args( $argv );
WP_CLI::add_wp_hook( 'setup_theme', function() use( $args, $runtime_config ) {
 
    if ( 'help' === strtolower( $args[0] ) ) {
        return;
    }
    if (
        'site' === strtolower( $args[0] ) &&
        'list' === strtolower( $args[1] )
    ) {
        return;
    }
    if ( function_exists( 'is_multisite' ) && is_multisite() && ! isset( $runtime_config['url'] ) ) {
        WP_CLI::error( '--url must be specified' );
    }
}, 999 );
