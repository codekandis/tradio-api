<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Errors;

use RuntimeException;

/**
 * Represents an exception if an error occurs during CURL operations.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class CurlException extends RuntimeException
{
}
