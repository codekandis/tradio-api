<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors;

/**
 * Represents an enumeration of common error codes.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class CommonErrorCodes
{
	/**
	 * Represents the error code if an internal error occured.
	 * @var int
	 */
	public const INTERNAL_ERROR = 1;

	/**
	 * Represents the error code if a content type is invalid.
	 * @var int
	 */
	public const INVALID_CONTENT_TYPE = 2;

	/**
	 * Represents the error code if a request body is malformed.
	 * @var int
	 */
	public const MALFORMED_REQUEST_BODY = 3;

	/**
	 * Represents the error code if a request body is invalid.
	 * @var int
	 */
	public const INVALID_REQUEST_BODY = 4;
}
