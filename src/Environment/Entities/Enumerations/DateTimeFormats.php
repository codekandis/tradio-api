<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\Enumerations;

/**
 * Represents an enumeration of date time formats.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class DateTimeFormats
{
	/**
	 * Represents the long date time format.
	 * @var string
	 */
	public const LONG = 'Y-m-d H:i:s.u';
}
