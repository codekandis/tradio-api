<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Readers;

use RuntimeException;

/**
 * Represents an exception if an error occurs during a CURL operation.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class CurlException extends RuntimeException
{
}
