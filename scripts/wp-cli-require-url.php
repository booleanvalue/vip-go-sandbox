<?php
$configurator = \WP_CLI::get_configurator();
$argv = array_slice( $GLOBALS['argv'], 1 );
list( $args, $assoc_args, $runtime_config ) = $configurator->parse_args( $argv );
WP_CLI::add_wp_hook( 'setup_theme', function() use( $args, $assoc_args, $runtime_config ) {
 
    // allowed without --url
    if (
        ( 'help' === strtolower( $args[0] ) ) ||
        ( 'site' === strtolower( $args[0] ) &&  'list' === strtolower( $args[1] ) ) ||
        ( 'site' === strtolower( $args[0] ) &&  'update' === strtolower( $args[1] ) ) ||
        ( 'network' === strtolower( $args[0] ) &&  'list' === strtolower( $args[1] ) ) ||
        ( 'app' === strtolower( $args[0] ) ) ||
        ( 'sandbox' === strtolower( $args[0] ) )
    ) {
        return;
    }

    // default state
    $method = 'warning';

    // sometimes we just need a scratch pad, don't make shell too hard
    if ( 'shell' === strtolower( $args[0] ) ) {
        $method = 'warning';
    }

    // for obvious data-impacting commands, error out
    if (
        in_array( 'update', $args ) ||
        in_array( 'delete', $args )
    ) {
        $method = 'error';
    }

    // be strict for cache flush
    if (
        ( 'cache' === strtolower( $args[0] ) &&  'flush' === strtolower( $args[1] ) )
    ) {
        $method = 'error';
    }

    // for strict formats, error out
    // helps when piping output to another command or file
    if ( isset( $assoc_args['format'] ) && in_array( $assoc_args['format'], [ 'json', 'ids', 'yaml', 'csv' ] ) ) {
        $method = 'error';
    }

    if ( function_exists( 'is_multisite' ) && is_multisite() && ! isset( $runtime_config['url'] ) ) {
        WP_CLI::$method(
            sprintf(
                '--url %s specified',
                $method == 'error' ? 'must be' : 'was not'
            )
        );
    }
}, 999 );
