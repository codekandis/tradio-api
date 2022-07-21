<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Configurations;

use CodeKandis\TradioApi\Entities\Enumerations\UriIdentifiers;

return [
	'schema'       => 'https',
	'host'         => 'api.tradio.codekandis',
	'baseUri'      => '/',
	'relativeUris' => [
		UriIdentifiers::INDEX                => '',
		UriIdentifiers::STATIONS             => 'stations',
		UriIdentifiers::STATION              => 'stations/%s',
		UriIdentifiers::CURRENT_TRACK        => 'stations/%s/tracklist/current-track',
		UriIdentifiers::STATION_USERS        => 'stations/%s/users',
		UriIdentifiers::USERS                => 'users',
		UriIdentifiers::USER                 => 'users/%s',
		UriIdentifiers::USER_STATIONS        => 'users/%s/stations',
		UriIdentifiers::USER_FAVORITE_TRACKS => 'users/%s/favorite-tracks',
		UriIdentifiers::FAVORITE_TRACKS      => 'favorite-tracks',
		UriIdentifiers::FAVORITE_TRACK       => 'favorite-tracks/%s',
		UriIdentifiers::FAVORITE_TRACK_USERS => 'favorite-tracks/%s/users'
	]
];
