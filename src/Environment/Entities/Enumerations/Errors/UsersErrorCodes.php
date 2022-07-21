<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\Enumerations\Errors;

/**
 * Represents an enumeration of users error codes.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class UsersErrorCodes
{
	/**
	 * Represents the error code if a user does not exist.
	 * @var int
	 */
	public const USER_UNKNOWN = 30001;
}
