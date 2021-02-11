<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Errors;

abstract class StationsErrorMessages
{
	public const STATION_UNKNOWN       = 'The requested station does not exist.';

	public const STATION_NOT_REACHABLE = 'The requested station is not reachable.';
}
