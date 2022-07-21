<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors;

/**
 * Represents an enumeration of favored tracks error messages.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class FavoriteTracksErrorMessages
{
	/**
	 * Represents the error message if the favored track does not exist.
	 * @var string
	 */
	public const FAVORITE_TRACK_UNKNOWN = 'The requested favored track does not exist.';
}
