<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\Enumerations;

/**
 * Represents an enumeration of tracklist types.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class TracklistTypes
{
	/**
	 * Represents the tracklist type `XML`.
	 * @var string
	 */
	public const XML = 'XML';

	/**
	 * Represents the tracklist type `HTML`.
	 * @var string
	 */
	public const HTML = 'HTML';

	/**
	 * Represents the tracklist type `JSON`.
	 * @var string
	 */
	public const JSON = 'JSON';
}
