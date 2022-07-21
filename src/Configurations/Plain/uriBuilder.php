<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Configurations;

return [
	'schema'       => 'https',
	'host'         => 'api.tradio.codekandis',
	'baseUri'      => '/',
	'relativeUris' => [
		'index'              => '',
		'stations'           => 'stations',
		'station'            => 'stations/%s',
		'currentTrack'       => 'stations/%s/tracklist/current-track',
		'stationUsers'       => 'stations/%s/users',
		'users'              => 'users',
		'user'               => 'users/%s',
		'userStations'       => 'users/%s/stations',
		'userFavoriteTracks' => 'users/%s/favorite-tracks',
		'favoriteTracks'     => 'favorite-tracks',
		'favoriteTrack'      => 'favorite-tracks/%s',
		'favoriteTrackUsers' => 'favorite-tracks/%s/users'
	]
];
