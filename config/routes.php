<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Configurations;

use CodeKandis\Tiphy\Http\Requests\Methods;
use CodeKandis\TradioApi\Actions\Api;

return [
	'^/$'                                                                                    => [
		Methods::GET => Api\Get\IndexAction::class
	],
	'^/stations$'                                                                            => [
		Methods::GET => Api\Get\StationsAction::class
	],
	'^/stations/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                         => [
		Methods::GET => Api\Get\StationAction::class
	],
	'^/stations/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/tracklist/current-track$' => [
		Methods::GET => Api\Get\CurrentTrackAction::class
	],
	'^/stations/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/users$'                   => [
		Methods::GET => Api\Get\StationUsersAction::class
	],
	'^/users$'                                                                               => [
		Methods::GET => Api\Get\UsersAction::class
	],
	'^/users/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                            => [
		Methods::GET => Api\Get\UserAction::class
	],
	'^/users/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/stations$'                   => [
		Methods::GET => Api\Get\UserStationsAction::class
	],
	'^/users/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/favorites$'                  => [
		Methods::GET => Api\Get\UserFavoritesAction::class,
		Methods::PUT => Api\Put\UserFavoriteAction::class
	],
	'^/favorites$'                                                                           => [
		Methods::GET => Api\Get\FavoritesAction::class
	],
	'^/favorites/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                        => [
		Methods::GET => Api\Get\FavoriteAction::class
	],
	'^/favorites/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/stations$'               => [
		Methods::GET => Api\Get\FavoriteStationsAction::class
	],
	'^/favorites/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/users$'                  => [
		Methods::GET => Api\Get\FavoriteUsersAction::class
	]
];
