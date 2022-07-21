<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Configurations;

use CodeKandis\Tiphy\Http\Requests\Methods;
use CodeKandis\TradioApi\Actions\Api;

return [
	'baseRoute' => '',
	'routes'    => [
		'^/$'                                                                                                                                             => [
			Methods::GET => Api\Get\IndexAction::class
		],
		'^/stations$'                                                                                                                                     => [
			Methods::GET => Api\Get\StationsAction::class
		],
		'^/stations/(?<stationId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                                                                           => [
			Methods::GET => Api\Get\StationAction::class
		],
		'^/stations/(?<stationId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/tracklist/current-track$'                                                   => [
			Methods::GET => Api\Get\CurrentTrackAction::class
		],
		'^/stations/(?<stationId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/users$'                                                                     => [
			Methods::GET => Api\Get\StationUsersAction::class
		],
		'^/users$'                                                                                                                                        => [
			Methods::GET => Api\Get\UsersAction::class
		],
		'^/users/(?<userId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                                                                                 => [
			Methods::GET => Api\Get\UserAction::class
		],
		'^/users/(?<userId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/stations$'                                                                        => [
			Methods::GET => Api\Get\UserStationsAction::class
		],
		'^/users/(?<userId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/favorite-tracks$'                                                                 => [
			Methods::GET => Api\Get\UserFavoriteTracksAction::class,
			Methods::PUT => Api\Put\UserFavoriteTrackByCurrentTrackAction::class
		],
		'^/users/(?<userId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/favorite-tracks/plain$'                                                           => [
			Methods::PUT => Api\Put\UserFavoriteTracksAction::class
		],
		'^/users/(?<userId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/favorite-tracks/(?<favoriteTrackId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$' => [
			Methods::DELETE => Api\Delete\UserFavoriteTrackAction::class
		],
		'^/favorite-tracks$'                                                                                                                              => [
			Methods::GET => Api\Get\FavoriteTracksAction::class
		],
		'^/favorite-tracks/(?<favoriteTrackId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                                                              => [
			Methods::GET => Api\Get\FavoriteTrackAction::class
		],
		'^/favorite-tracks/(?<favoriteTrackId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/users$'                                                        => [
			Methods::GET => Api\Get\FavoriteTrackUsersAction::class
		]
	]
];
