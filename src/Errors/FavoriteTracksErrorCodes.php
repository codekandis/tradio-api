<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Errors;

/**
 * Represents an enumeration of favored tracks error codes.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class FavoriteTracksErrorCodes
{
	/**
	 * Represents the error code if the favored track does not exist.
	 * @var int
	 */
	public const FAVORITE_TRACK_UNKNOWN = 40001;
}
