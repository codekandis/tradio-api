<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors;

/**
 * Represents an enumeration of stations error codes.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class StationsErrorCodes
{
	/**
	 * Represents the error code if the station does not exist.
	 * @var int
	 */
	public const STATION_UNKNOWN = 20001;

	/**
	 * Represents the error code if a station is not reachable.
	 * @var int
	 */
	public const STATION_NOT_REACHABLE = 20002;
}
