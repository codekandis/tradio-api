<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Configurations;

use CodeKandis\Tiphy\Http\Requests\Methods;
use CodeKandis\TradioApi\Actions\Api;

return [
	'^/$'                                                                                    => [
		Methods::GET => Api\Read\GetIndexAction::class
	],
	'^/stations$'                                                                            => [
		Methods::GET => Api\Read\GetStationsAction::class
	],
	'^/stations/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                         => [
		Methods::GET => Api\Read\GetStationAction::class
	],
	'^/stations/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/tracklist/current-track$' => [
		Methods::GET => Api\Read\GetCurrentTrackAction::class
	],
	'^/stations/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/users$'                   => [
		Methods::GET => Api\Read\GetStationUsersAction::class
	],
	'^/stations/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/favorites$'               => [
		Methods::GET => Api\Read\GetStationFavoritesAction::class
	],
	'^/users$'                                                                               => [
		Methods::GET => Api\Read\GetUsersAction::class
	],
	'^/users/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                            => [
		Methods::GET => Api\Read\GetUserAction::class
	],
	'^/users/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/stations$'                   => [
		Methods::GET => Api\Read\GetUserStationsAction::class
	],
	'^/users/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/favorites$'                  => [
		Methods::GET => Api\Read\GetUserFavoritesAction::class,
		Methods::PUT => Api\Write\AddUserFavoriteAction::class
	],
	'^/favorites$'                                                                           => [
		Methods::GET => Api\Read\GetFavoritesAction::class
	],
	'^/favorites/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                        => [
		Methods::GET => Api\Read\GetFavoriteAction::class
	],
	'^/favorites/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/stations$'               => [
		Methods::GET => Api\Read\GetFavoriteStationsAction::class
	],
	'^/favorites/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/users$'                  => [
		Methods::GET => Api\Read\GetFavoriteUsersAction::class
	]
];
