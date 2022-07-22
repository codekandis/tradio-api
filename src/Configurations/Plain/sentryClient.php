<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Configurations\Plain;

use const E_ALL;

return [
	'dsn'           => '',
	'displayErrors' => false,
	'errorTypes'    => E_ALL,
	'environment'   => 'production',
	'release'       => '0.8.0',
	'serverName'    => 'api.tradio.codekandis'
];
