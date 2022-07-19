<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Errors;

/**
 * Represents an enumeration of common error messages.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class CommonErrorMessages
{
	/**
	 * Represents the error message if an internal error occured.
	 * @var string
	 */
	public const INTERNAL_ERROR = 'An internal error occurred.';

	/**
	 * Represents the error message if a content type is invalid.
	 * @var string
	 */
	public const INVALID_CONTENT_TYPE = 'The request content type is invalid.';

	/**
	 * Represents the error message if a request body is malformed.
	 * @var string
	 */
	public const MALFORMED_REQUEST_BODY = 'The request body is malformed.';

	/**
	 * Represents the error message if a request body is invalid.
	 * @var string
	 */
	public const INVALID_REQUEST_BODY = 'The request body is invalid';
}
