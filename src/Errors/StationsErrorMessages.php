<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Errors;

/**
 * Represents an enumeration of stations error messages.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class StationsErrorMessages
{
	/**
	 * Represents the error message if the station does not exist.
	 * @var string
	 */
	public const STATION_UNKNOWN = 'The requested station does not exist.';

	/**
	 * Represents the error message if a station is not reachable.
	 * @var string
	 */
	public const STATION_NOT_REACHABLE = 'The requested station is not reachable.';
}
