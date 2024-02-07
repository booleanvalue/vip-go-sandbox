<?php

/**
 * commands excluded from this repo
 * https://github.com/trepmal/vip-go-sandbox-priv/
 */
foreach ( glob( __DIR__ . '/priv/*.php' ) as $command ) {
	require_once $command;
}