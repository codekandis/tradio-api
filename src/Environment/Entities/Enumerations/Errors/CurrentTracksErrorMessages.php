<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors;

/**
 * Represents an enumeration of current tracks error messages.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class CurrentTracksErrorMessages
{
	/**
	 * Represents the error message if the currently playing track is not readable.
	 * @var string
	 */
	public const CURRENT_TRACK_NOT_READABLE = 'The currently playing track is not readable.';
}
