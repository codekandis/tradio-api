<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Configurations;

use CodeKandis\Persistence\PersistenceDrivers;

return [
	'driver'       => PersistenceDrivers::MYSQL,
	'host'         => 'localhost',
	'databaseName' => 'api.tradio.codekandis',
	'username'     => 'root',
	'passphrase'   => 'root',
];
