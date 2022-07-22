<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Readers;

use RuntimeException;

/**
 * Represents an exception if a tracklist is not readable.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class TracklistNotReadableException extends RuntimeException
{
}
