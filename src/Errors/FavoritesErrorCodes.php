<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Errors;

/**
 * Represents an enumeration of favorite tracks error codes.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class FavoritesErrorCodes
{
	/**
	 * Represents the error code if the favorite track does not exist.
	 * @var int
	 */
	public const FAVORITE_UNKNOWN = 40001;
}
