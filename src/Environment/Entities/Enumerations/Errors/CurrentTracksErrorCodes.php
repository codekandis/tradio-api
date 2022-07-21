<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors;

/**
 * Represents an enumeration of current tracks error codes.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class CurrentTracksErrorCodes
{
	/**
	 * Represents the error code if the current track is not readable.
	 * @var int
	 */
	public const CURRENT_TRACK_NOT_READABLE = 50001;
}
