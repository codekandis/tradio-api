<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Errors;

/**
 * Represents an enumeration of users error messages.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class UsersErrorMessages
{
	/**
	 * Represents the error message if a user does not exist.
	 * @var string
	 */
	public const USER_UNKNOWN = 'The requested user does not exist.';
}
