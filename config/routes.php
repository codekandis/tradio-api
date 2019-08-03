<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Configurations;

use CodeKandis\Tiphy\Http\Requests\Methods;
use CodeKandis\TradioApi\Actions\Api;

return [
	'^/$'                                                                                    => [
		Methods::GET => Api\Read\GetIndexAction::class,
	],
	'^/stations$'                                                                            => [
		Methods::GET => Api\Read\GetStationsAction::class,
	],
	'^/stations/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})$'                         => [
		Methods::GET => Api\Read\GetStationAction::class,
	],
	'^/stations/(?<id>[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12})/tracklist/current-track$' => [
		Methods::GET => Api\Read\GetCurrentTrackAction::class,
	],
];
