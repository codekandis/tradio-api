<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Readers;

use RuntimeException;

/**
 * Represents an exception if a currently playing track name is not extractable.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class CurrentTrackNameNotExtractableException extends RuntimeException
{
}
