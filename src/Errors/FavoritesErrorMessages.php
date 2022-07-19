<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Errors;

/**
 * Represents an enumeration of favorite tracks error messages.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class FavoritesErrorMessages
{
	/**
	 * Represents the error message if the favorite track does not exist.
	 * @var string
	 */
	public const FAVORITE_UNKNOWN = 'The requested favorite track does not exist.';
}
