<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Configurations;

use CodeKandis\Tiphy\Http\Requests\Methods;
use CodeKandis\TradioApi\Actions\Api;

return [
	'^/$'                                                                                                                                  => [
		Methods::GET => Api\Get\IndexAction::class
	],
	'^/stations$'                                                                                                                          => [
		Methods::GET => Api\Get\StationsAction::class
	],
	'^/stations/(?<stationId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                                                                => [
		Methods::GET => Api\Get\StationAction::class
	],
	'^/stations/(?<stationId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/tracklist/current-track$'                                        => [
		Methods::GET => Api\Get\CurrentTrackAction::class
	],
	'^/stations/(?<stationId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/users$'                                                          => [
		Methods::GET => Api\Get\StationUsersAction::class
	],
	'^/users$'                                                                                                                             => [
		Methods::GET => Api\Get\UsersAction::class
	],
	'^/users/(?<userId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                                                                      => [
		Methods::GET => Api\Get\UserAction::class
	],
	'^/users/(?<userId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/stations$'                                                             => [
		Methods::GET => Api\Get\UserStationsAction::class
	],
	'^/users/(?<userId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/favorites$'                                                            => [
		Methods::GET => Api\Get\UserFavoritesAction::class,
		Methods::PUT => Api\Put\UserFavoriteAction::class
	],
	'^/users/(?<userId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/favorites/(?<favoriteId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$' => [
		Methods::DELETE => Api\Delete\UserFavoriteAction::class
	],
	'^/favorites$'                                                                                                                         => [
		Methods::GET => Api\Get\FavoritesAction::class
	],
	'^/favorites/(?<favoriteId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                                                              => [
		Methods::GET => Api\Get\FavoriteAction::class
	],
	'^/favorites/(?<favoriteId>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/users$'                                                        => [
		Methods::GET => Api\Get\FavoriteUsersAction::class
	]
];
