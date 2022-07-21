<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

/**
 * Represents the interface of any index.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface IndexEntityInterface extends EntityInterface
{
	/**
	 * Gets the URI of the stations.
	 * @return string The URI of the stations.
	 */
	public function getStationsUri(): string;

	/**
	 * Gets the URI of the stations.
	 * @param string $stationsUri The URI of the stations.
	 */
	public function setStationsUri( string $stationsUri ): void;

	/**
	 * Stores the URI of the favored tracks.
	 * @return string The URI of the favored tracks.
	 */
	public function getFavoriteTracksUri(): string;

	/**
	 * Stores the URI of the favored tracks.
	 * @param string $favoriteTracksUri The URI of the favored tracks.
	 */
	public function setFavoriteTracksUri( string $favoriteTracksUri ): void;

	/**
	 * Stores the URI of the users.
	 * @return string The URI of the users.
	 */
	public function getUsersUri(): string;

	/**
	 * Stores the URI of the users.
	 * @param string $usersUri The URI of the users.
	 */
	public function setUsersUri( string $usersUri ): void;
}
