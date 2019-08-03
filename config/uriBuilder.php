<?php declare( strict_types = 1 );
namespace CodeKandis\ClassListApi\Configurations;

return [
	'schema'       => 'https',
	'host'         => 'api.tradio.codekandis',
	'baseUri'      => '/',
	'relativeUris' => [
		'index'            => '',
		'stations'         => 'stations',
		'station'          => 'stations/%s',
		'currentTrack'     => 'stations/%s/tracklist/current-track',
		'favorites'        => 'favorites',
		'favorite'         => 'favorites/%s',
		'stationFavorites' => 'stations/%s/favorites',
		'stationFavorite'  => 'stations/%s/favorites/%s',
		'users'            => 'users',
		'user'             => 'users/%s',
		'userStations'     => 'users/%s/stations',
		'userStation'      => 'users/%s/stations/%s',
		'userFavorites'    => 'users/%s/favorites',
		'userFavorite'     => 'users/%s/favorites/%s'
	]
];
