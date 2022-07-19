<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

/**
 * Represents the interface of any user.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface UserEntityInterface extends PersistableEntityInterface
{
	/**
	 * Gets the name of the user.
	 * @return string The name of the user.
	 */
	public function getName(): string;

	/**
	 * Sets the name of the user.
	 * @param string The name of the user.
	 */
	public function setName( string $name ): void;

	/**
	 * Gets the e-mail of the user.
	 * @return string The e-mail of the user.
	 */
	public function getEMail(): string;

	/**
	 * Sets the e-mail of the user.
	 * @param string $eMail The e-mail of the user.
	 */
	public function setEMail( string $eMail ): void;

	/**
	 * Gets the URI of the stations of the user.
	 * @return string The URI of the stations of the user.
	 */
	public function getStationsUri(): string;

	/**
	 * Sets the URI of the stations of the user.
	 * @param string $stationsUri The URI of the stations of the user.
	 */
	public function setStationsUri( string $stationsUri ): void;

	/**
	 * Gets the URI of the favorites of the user.
	 * @return string The URI of the favorites of the user.
	 */
	public function getFavoritesUri(): string;

	/**
	 * Sets the URI of the favorites of the user.
	 * @param string $favoritesUri The URI of the favorites of the user.
	 */
	public function setFavoritesUri( string $favoritesUri ): void;
}
