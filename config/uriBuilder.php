<?php declare( strict_types = 1 );
namespace CodeKandis\ClassListApi\Configurations;

return [
	'schema'       => 'https',
	'host'         => 'api.tradio.codekandis',
	'baseUri'      => '/',
	'relativeUris' => [
		'index'         => '',
		'stations'      => 'stations',
		'station'       => 'stations/%s',
		'currentTrack'  => 'stations/%s/tracklist/current-track',
		'stationUsers'  => 'stations/%s/users',
		'users'         => 'users',
		'user'          => 'users/%s',
		'userStations'  => 'users/%s/stations',
		'userFavorites' => 'users/%s/favorites',
		'favorites'     => 'favorites',
		'favorite'      => 'favorites/%s',
		'favoriteUsers' => 'favorites/%s/users'
	]
];
