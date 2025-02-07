<?php

/**
 * used when debugging concat on sandboxes
 * this needs to be used in concat-util to make 
 * ingress urls validate as 'internal'
 * 
 * taken originally from wp-content/mu-plugins/vip-helpers/sandbox.php
 */

function reverse_wpvip_filter_sandbox_plugins_url( $url ) {
    /** @var array<string,string> */
    global $sandbox_vhosts;
    $host = $_SERVER['HTTP_HOST'] ?? null; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

    if ( empty( $host ) || ! is_array( $sandbox_vhosts ) ) {
        // Not a k8s sandbox or valid host, bail.
        return $url;
    }
    /*
     * $sandbox_vhosts is something like ['subdomain.uuid.sbx-sid.ingress-api.vip-ditto.k8s.dfw.vipv2.net' => 'subdomain.go-vip.net']
     * `sandbox-hosts-config.php` replaces the "sandbox" (key) domain with the "original" (value) domain in `$_SERVER['HTTP_HOST']`.
     * In this filter, we need to reverse that for the given `$url`
     *
     * 1. We need to look up the key matching `$_SERVER['HTTP_HOST']` in `$sandbox_vhosts`
     * 2. We need to replace `://{$_SERVER['HTTP_HOST']}` with `://{$key}`  in `$url`
     */
    if ( in_array( $host, $sandbox_vhosts, true ) ) {
        $flipped = array_flip( $sandbox_vhosts );
        $key     = $flipped[ $host ];
        $url     = str_replace( '://' . $key, '://' . $host, $url );
    }

    return $url;
}




# Below are the mostly-unmodded* contents of
# /var/www/wp-content/mu-plugins/http-concat/concat-utils.php
# *exception is marked with '<----'

class WPCOM_Concat_Utils {
	// Maximum group size, anything over that will be split into multiple groups
	protected static int $concat_max = 150;

	public static function get_concat_max() {
		return self::$concat_max;
	}

    public static function is_internal_url( $test_url, $site_url ) { 

        $test_url = reverse_wpvip_filter_sandbox_plugins_url( $test_url ); /** <---------------------------- */

        $test_url_parsed = parse_url( $test_url );
        $site_url_parsed = parse_url( $site_url );

        if ( isset( $test_url_parsed['host'] )
            && $test_url_parsed['host'] !== $site_url_parsed['host'] ) { 
            return false;
        }   

        if ( isset( $site_url_parsed['path'] )
            && 0 !== strpos( $test_url_parsed['path'], $site_url_parsed['path'] )
            && isset( $test_url_parsed['host'] ) //and if the URL of enqueued style is not relative
        ) { 
            return false;
        }   

        return true;
    }   

    public static function realpath( $url, $site_url ) { 
        $url_path = parse_url( $url, PHP_URL_PATH );
        $site_url_path = parse_url( $site_url, PHP_URL_PATH );
        // To avoid partial matches; subdir install at `/wp` would match `/wp-includes`
        $site_url_path = is_null( $site_url_path ) ? '/' : trailingslashit( $site_url_path );

        // If this is a subdirectory site, we need to strip off the subdir from the URL.
        // In a multisite install, the subdir is virtual and therefore not needed in the path.
        // In a single-site subdir install, the subdir is included in the ABSPATH and therefore ends up duplicated.
        if ( $site_url_path && '/' !== $site_url_path
            && 0 === strpos( $url_path, $site_url_path ) ) { 
            $url_path_without_subdir = preg_replace( '#^' . $site_url_path . '#', '', $url_path, 1 );
            return realpath( ABSPATH . $url_path_without_subdir );
        }   

        return realpath( ABSPATH . $url_path );
    }   

    public static function relative_path_replace( $buf, $dirpath ) { 
        // url(relative/path/to/file) -> url(/absolute/and/not/relative/path/to/file)
        $buf = preg_replace(
            '/(:?\s*url\s*\()\s*(?:\'|")?\s*([^\/\'"\s\)](?:(?<!data:|http:|https:|[\(\'"]#|%23).)*)[\'"\s]*\)/isU',
            '$1' . ( $dirpath == '/' ? '/' : $dirpath . '/' ) . '$2)',
            $buf
        );  

        return $buf;
    }   
}
