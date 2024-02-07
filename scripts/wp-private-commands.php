<?php

/**
 * Load private commands
 * https://github.com/trepmal/vip-go-sandbox-priv/
 *
 * Some commands should not be publicly-accessible and are in the above
 * optional repo, so we include those via this loop, so prevent breakage
 * if not installed
 *
 */
foreach ( glob( '/root/commands/*.php' ) as $command ) {
	require_once $command;
}