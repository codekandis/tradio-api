<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Configurations;

use CodeKandis\Tiphy\Http\Requests\Methods;
use CodeKandis\TradioApi\Api;

return [
	'baseRoute' => '',
	'routes'    => [
		'^/$'                                                                                                                                             => [
			Methods::GET => Api\Actions\Get\IndexAction::class
		],
		'^/stations$'                                                                                                                                     => [
			Methods::GET => Api\Actions\Get\StationsAction::class
		],
		'^/stations/(?<stationId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                                                                           => [
			Methods::GET => Api\Actions\Get\StationAction::class
		],
		'^/stations/(?<stationId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/tracklist/current-track$'                                                   => [
			Methods::GET => Api\Actions\Get\CurrentTrackAction::class
		],
		'^/stations/(?<stationId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/users$'                                                                     => [
			Methods::GET => Api\Actions\Get\StationUsersAction::class
		],
		'^/users$'                                                                                                                                        => [
			Methods::GET => Api\Actions\Get\UsersAction::class
		],
		'^/users/(?<userId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                                                                                 => [
			Methods::GET => Api\Actions\Get\UserAction::class
		],
		'^/users/(?<userId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/stations$'                                                                        => [
			Methods::GET => Api\Actions\Get\UserStationsAction::class
		],
		'^/users/(?<userId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/favorite-tracks$'                                                                 => [
			Methods::GET => Api\Actions\Get\UserFavoriteTracksAction::class,
			Methods::PUT => Api\Actions\Put\UserFavoriteTrackByCurrentTrackAction::class
		],
		'^/users/(?<userId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/favorite-tracks/plain$'                                                           => [
			Methods::PUT => Api\Actions\Put\UserFavoriteTracksAction::class
		],
		'^/users/(?<userId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/favorite-tracks/(?<favoriteTrackId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$' => [
			Methods::DELETE => Api\Actions\Delete\UserFavoriteTrackAction::class
		],
		'^/favorite-tracks$'                                                                                                                              => [
			Methods::GET => Api\Actions\Get\FavoriteTracksAction::class
		],
		'^/favorite-tracks/(?<favoriteTrackId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                                                              => [
			Methods::GET => Api\Actions\Get\FavoriteTrackAction::class
		],
		'^/favorite-tracks/(?<favoriteTrackId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/users$'                                                        => [
			Methods::GET => Api\Actions\Get\FavoriteTrackUsersAction::class
		]
	]
];
